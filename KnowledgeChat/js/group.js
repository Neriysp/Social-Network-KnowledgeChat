$('.tab a').click(function(e) {

    e.preventDefault();

    if ($(this).parent()[0].className.includes("active")) {
        return;
    } else {
        target = $(this).attr('href');
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');

        $('.tab-content > div').not(target).hide();

        $(target).show();
    }
});

$('.show_more_comments').click(function(e) {
    var alternativeParent = $(this).parents('div.comment-main-level');
    var parent = $(this).parents('div.comment-main-reply');
    if (parent.length != 1) {
        parent = alternativeParent.parent();
    } else parent = parent.parent();

    if ($(this).html() !== '<span><i class="fa fa-level-up" aria-hidden="true"></i></span> Hide replies') {
        for (var i = 0; i < parent[0].children.length; i++) {
            if (parent[0].children[i].className.includes("reply-list")) {
                for (var j = 0; j < parent.children().length; j++) {
                    if (parent.children()[j].className.includes("reply-list"))
                        $(parent.children()[j]).fadeIn(500);
                }
            }
        }
        $(this).html('<span><i class="fa fa-level-up" aria-hidden="true"></i></span> Hide replies');
    } else {
        for (var j = 0; j < parent.children().length; j++) {
            if (parent.children()[j].className.includes("reply-list"))
                $(parent.children()[j]).hide();
        }
        $(this).html('<span><i class="fa fa-level-down" aria-hidden="true"></i></span> Show replies');
    }
});

$('.hide_chat').click(function(e) {
    if ($('.sidebar').is(":visible")) {
        $('.sidebar').hide();
        $('.wrapper').css({ "grid-template-columns": " 1fr 1.5fr 1.5fr" });
        $('.hide_chat').html('<i class="fa fa-chevron-left" aria-hidden="true"></i>');
    } else {
        $('.sidebar').show();
        $('.wrapper').css({ "grid-template-columns": " 1fr 1.5fr 1.5fr 20px 0.5fr" });
        $('.hide_chat').html('<i class="fa fa-chevron-right" aria-hidden="true"></i>');
    }
});



function newcomment(event) {

    if (event.keyCode === 13) {
        event.preventDefault();
        var body = event.target.value;
        var post_id = event.target.parentElement.getElementsByClassName('post_id_hidden')[0].value;
        $.ajax({
            url: "ajaxGroup.php",
            method: "POST",
            data: { functionName: "newcomment", body: body, post_id: post_id },
            success: function(data) {
                if (data != '' && data != null) {
                    var fullName = JSON.parse(data);
                    if (fullName.hasOwnProperty('error')) {
                        alert(objData.error);
                        return false;
                    }
                    var parent = findAncestor(event.target, 'footer').getElementsByClassName('comments_w');
                    var newCommentHtml = parent[0].getElementsByClassName('comment_child')[parent[0].getElementsByClassName('comment_child').length - 1].cloneNode(true);
                    //  var newCommentHtml = parent.children[0].cloneNode(true);
                    newCommentHtml.style = '';
                    newCommentHtml.getElementsByClassName('comment_footer')[0].getElementsByClassName('time')[0].innerHTML = "Just Now";
                    newCommentHtml.getElementsByClassName('user')[0].innerHTML = fullName.first_name + ' ' + fullName.last_name;
                    newCommentHtml.getElementsByClassName('output')[0].innerHTML = htmlEntities(event.target.value);
                    newCommentHtml.getElementsByClassName('img-profile profile_picture')[0].src = document.getElementsByClassName('new_comment')[0].getElementsByClassName('img-profile profile_picture')[0].src;
                    parent[0].getElementsByClassName('comment_child')[0].parentElement.insertBefore(newCommentHtml, parent[0].getElementsByClassName('comment_child')[0]);
                    event.target.value = '';
                }
            },
            error: function(err) {
                console.log("Error while creating the comment!" + err.toString());
            }
        });

    }
}
$('#new_post_form').submit(function(event) {
    event.preventDefault();
    var image_name = $('#image').val();
    if ($('.new_post').val() == '' && image_name == '') {
        $('.new_post').addClass("error_placeholder").attr("placeholder", 'This post appears to be blank.Please write something or attach a link or photo to post.');
        setTimeout(function() {
            $('.new_post').removeClass("error_placeholder").attr("placeholder", 'What\'s on your mind?');
        }, 5000);
        return false;
    }
    if (image_name == '') {
        var extension = null;
    } else {
        var extension = image_name.split('.').pop().toLowerCase();
        if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            alert("Invalid Image File");
            $('#image').val('');
            return false;
        }
    }
    $.ajax({
        url: "ajaxGroup.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(data) {
            if (data != '') {
                var objData = JSON.parse(data);
                if (objData.hasOwnProperty('error')) {
                    $('#new_post_form')[0].reset();
                    $('.new_post').addClass("error_placeholder").attr("placeholder", objData.error);
                    return false;
                }
            }
            if (objData.hasOwnProperty('imgsrc')) {
                var imgsrc = objData.imgsrc;
                var new_post_id = objData.post_id;

                if ($('div.Posted_posts div.card:first-child').find('img.img-primary').length) {
                    $("div.Posted_posts").prepend('<div class="card">' + $('div.Posted_posts div.card:first-child').html());
                } else {
                    $("<img src='' class='img-primary' style='display:none;'>").insertAfter(".body");
                    $("div.Posted_posts").prepend('<div class="card">' + $('div.Posted_posts div.card:first-child').html());
                }
                $('div.Posted_posts div.card:first-child').find('img.img-primary').css('display', 'block');
                $('div.Posted_posts div.card:first-child img.img-primary').attr("src", imgsrc);
            } else {
                var new_post_id = objData.post_id;
                $("div.Posted_posts").prepend('<div class="card">' + $('div.Posted_posts div.card:first-child').html());
                if ($('div.Posted_posts div.card:first-child').find('img.img-primary').length) {
                    $('div.Posted_posts div.card:first-child').find('img.img-primary').css('display', 'none');
                }
            }
            var body = htmlEntities($('.new_post').val());
            $('div.Posted_posts div.card:first-child p').html(body);
            $('div.Posted_posts div.card:first-child').find('a.time').html('Just now');
            $('.new_comment div.prof_img img').attr("src", document.getElementsByClassName('Posted_posts')[0].getElementsByClassName('card')[document.getElementsByClassName('Posted_posts')[0].getElementsByClassName('card').length - 1].getElementsByClassName('footer')[0].getElementsByClassName('new_comment')[0].getElementsByClassName('img-profile profile_picture')[0].src);
            $('div.Posted_posts div.card:first-child').find('a.time').html('Just now');
            $('div.Posted_posts div.card:first-child').find('.comment_child').hide();
            $('div.Posted_posts div.card:first-child .footer .new_comment .input .post_id_hidden').attr('value', new_post_id);
            $('#new_post_form')[0].reset();

        },
        error: function(err) {
            console.log("Error while uploading new post!" + err.toString());
        }
    });

});

function viewMoreComments(event) {
    event.preventDefault();
    var parent = findAncestor(event.target, 'footer').getElementsByClassName('comments_w')[0];
    var hiddenComments = parent.getElementsByClassName('comment_child_hidden');
    for (var i = 0; i < hiddenComments.length; i++) {
        hiddenComments[i].style.display = 'block';
    }
    event.target.style.display = 'none';
}


function RequestTojoinClosedGroup(event) {

    var group_name = window.location.search.split('=')[window.location.search.split('=').length - 1];

    $.ajax({
        url: "ajaxGroup.php",
        method: "POST",
        data: { functionName: "reqToJoinGroup", group_name: group_name },
        success: function(data) {
            if (data != '') {
                var objData = JSON.parse(data);
                if (objData.hasOwnProperty('error')) {
                    location.reload();
                } else {
                    event.target.innerHTML = "Request sent";
                    event.target.disabled = true;
                    event.target.style.background = '#dddddd';
                }
            }
        },
        error: function(err) {
            console.log("Error while processing request!" + err.toString());
        }
    });
}

function joinOpenGroup(event) {

    var group_name = window.location.search.split('=')[window.location.search.split('=').length - 1];

    $.ajax({
        url: "ajaxGroup.php",
        method: "POST",
        data: { functionName: "JoinOpenGroup", group_name: group_name },
        success: function(data) {
            event.target.style.display = "none";
            location.reload();
        },
        error: function(err) {
            console.log("Error while adding to the group!" + err.toString());
        }
    });
}

function acceptReq(event) {
    var user_id = event.target.parentElement.querySelector('#user_id').value;
    var group_name = window.location.search.split('=')[window.location.search.split('=').length - 1];
    $.ajax({
        url: "ajaxGroup.php",
        method: "POST",
        data: { functionName: "AcceptReqClosedGroup", user_id: user_id, group_name: group_name },
        success: function(data) {
            findAncestor(event.target, 'popup_tojoin_row').innerHTML = "User Added Successfully!";
            if (parseInt(document.querySelector('#nr_reqto_join').innerHTML) > 1) {
                document.querySelector('#nr_reqto_join').innerHTML = parseInt(document.querySelector('#nr_reqto_join').innerHTML) - 1;
            } else {
                document.querySelector('#nr_reqto_join').style.display = "none";
            }
        },
        error: function(err) {
            console.log("Error while adding to the group!" + err.toString());
        }
    });
}

function rejectReq(event) { //FIXME:Permiresim fut req_to_join_id direkt ose jo :P
    var user_id = event.target.parentElement.querySelector('#user_id').value;
    var group_name = window.location.search.split('=')[window.location.search.split('=').length - 1];
    $.ajax({
        url: "ajaxGroup.php",
        method: "POST",
        data: { functionName: "RejectReqClosedGroup", user_id: user_id, group_name: group_name },
        success: function(data) {
            findAncestor(event.target, 'popup_tojoin_row').innerHTML = "User Recejted!";
            if (parseInt(document.querySelector('#nr_reqto_join').innerHTML) > 1) {
                document.querySelector('#nr_reqto_join').innerHTML = parseInt(document.querySelector('#nr_reqto_join').innerHTML) - 1;
            } else {
                document.querySelector('#nr_reqto_join').style.display = "none";
            }
        },
        error: function(err) {
            console.log("Error while rejecting to the group!" + err.toString());
        }
    });
}

function chatScroll() {
    if (document.documentElement.scrollTop > 70) {
        document.getElementById("chatUl").className = "top0";
    } else {
        document.getElementById("chatUl").className = "";
    }
}

function suggestEvent(event) {

    var group_name = window.location.search.split('=')[window.location.search.split('=').length - 1];
    var task = document.querySelector('#suggest_event_task').value;
    if (document.querySelector('input[name="type_of_event"]:checked') != null) {

        var difficulty = document.querySelector('input[name="type_of_event"]:checked').value;
    }

    $.ajax({
        url: "ajaxGroup.php",
        method: "POST",
        data: { functionName: "SuggestEvent", task: task, difficulty: difficulty, group_name: group_name },
        success: function(data) {
            if (data != '') {
                var objData = JSON.parse(data);
                if (objData.hasOwnProperty('success')) {
                    var element = findAncestor(event.target, 'container_suggestEvent');
                    var originalHtml = element.innerHTML;
                    element.innerHTML = objData.success;

                    setTimeout(() => {
                        document.getElementsByClassName('container_suggestEvent')[0].innerHTML = originalHtml
                        if (objData.hasOwnProperty('admin')) {
                            location.reload();
                        }
                    }, 1500);
                }
            }
        },
        error: function(err) {
            console.log("Error while suggesting event!" + err.toString());
        }
    });
}

function acceptSug(event) {
    var event_suggestion_id = event.target.parentElement.querySelector('#event_suggestion_id').value;

    $.ajax({
        url: "ajaxGroup.php",
        method: "POST",
        data: { functionName: "AcceptEventSuggestion", event_suggestion_id: event_suggestion_id },
        success: function(data) {
            var element = findAncestor(event.target, 'parent_sugg');
            element.innerHTML = "Suggestion added to next event vote!";
            if (parseInt(document.querySelector('#nr_reqto_join_sugg').innerHTML) > 1) {
                document.querySelector('#nr_reqto_join_sugg').innerHTML = parseInt(document.querySelector('#nr_reqto_join_sugg').innerHTML) - 1;
            } else {
                document.querySelector('#nr_reqto_join_sugg').style.display = "none";
            }
            setTimeout(() => {
                element.innerHTML = "";
            }, 2000);
        },
        error: function(err) {
            console.log("Error while submiting the event suggestion!" + err.toString());
        }
    });
}

function rejectSug(event) {
    var event_suggestion_id = event.target.parentElement.querySelector('#event_suggestion_id').value;

    $.ajax({
        url: "ajaxGroup.php",
        method: "POST",
        data: { functionName: "RejectEventSuggestion", event_suggestion_id: event_suggestion_id },
        success: function(data) {
            var element = findAncestor(event.target, 'parent_sugg');
            element.innerHTML = "Suggestion Recejted!";
            if (parseInt(document.querySelector('#nr_reqto_join_sugg').innerHTML) > 1) {
                document.querySelector('#nr_reqto_join_sugg').innerHTML = parseInt(document.querySelector('#nr_reqto_join_sugg').innerHTML) - 1;

            } else {
                document.querySelector('#nr_reqto_join_sugg').style.display = "none";
            }
            setTimeout(() => {
                element.innerHTML = "";
            }, 2000);
        },
        error: function(err) {
            console.log("Error while submiting the event suggestion!" + err.toString());
        }
    });
}

//Voting for event

function upVote(e){

    var element = findAncestor(event.target, 'parent_sugg');
    var id = element.querySelector('#id_next_event').value;
    var group_name = window.location.search.split('=')[window.location.search.split('=').length - 1];

    $.ajax({
        url: "ajaxGroup.php",
        method: "POST",
        data: { functionName: "upVoteEventSuggestion", event_suggestion_id: id, group_name: group_name },
        success: function (data) {

            
            var childElement = element.getElementsByClassName('ThumbDown')[0];
            if (childElement.className.includes('clicked')) {
                childElement.style.color = "black";
                childElement.className = childElement.className.split(' clicked')[0];
            }
            if (!e.target.className.includes('clicked')) {
                e.target.style.color = "rgb(64, 128, 255)";
                e.target.className += " clicked";
            }
            else {
                e.target.style.color = "black";
                e.target.className = e.target.className.split(' clicked')[0];
            }

        },
        error: function (err) {
            console.log("Error while submiting the event vote!" + err.toString());
        }
    });
}
function downVote(e) {

    var element = findAncestor(event.target, 'parent_sugg');
    var id = element.querySelector('#id_next_event').value;
    var group_name = window.location.search.split('=')[window.location.search.split('=').length - 1];

    $.ajax({
        url: "ajaxGroup.php",
        method: "POST",
        data: { functionName: "downVoteEventSuggestion", event_suggestion_id: id, group_name: group_name },
        success: function (data) {
           
            var childElement = element.getElementsByClassName('ThumbUp')[0];
            if (childElement.className.includes('clicked')) {
                childElement.style.color = "black";
                childElement.className = childElement.className.split(' clicked')[0];
            } 

            if (!e.target.className.includes('clicked')) {
                e.target.style.color = "rgb(64, 128, 255)";
                e.target.className += " clicked";
            }
            else {
                e.target.style.color = "black";
                e.target.className = e.target.className.split(' clicked')[0];
            }
        },
        error: function (err) {
            console.log("Error while submiting the event vote!" + err.toString());
        }
    });
}

function markEventDone(){

    var group_name = window.location.search.split('=')[window.location.search.split('=').length - 1];

    $.ajax({
        url: "ajaxGroup.php",
        method: "POST",
        data: { functionName: "newMainEvent", group_name: group_name },
        success: function (data) {
            location.reload();
        },
        error: function (err) {
            console.log("Error while creating the new main event!" + err.toString());
        }
    });
}