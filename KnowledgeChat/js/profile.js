window.onbeforeunload = function() {
    window.scrollTo(0, 0);
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
$(function() {
    //OPEN
    $('[data-popup-open]').on('click', function(e) {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);

        e.preventDefault();
    });

    //CLOSE
    $('[data-popup-close]').on('click', function(e) {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

        e.preventDefault();
    });
});

function FilerGrid() {

    var input, filter, table, tr, td, i;
    input = document.getElementById("searchPopup");
    filter = input.value.toUpperCase();
    table = document.getElementById("groupsTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
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
        url: "ajaxProfile.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(data) {
            if (data != '') {
                var objData = JSON.parse(data);
            }
            if (objData.hasOwnProperty('imgsrc')) {
                var imgsrc = objData.imgsrc;
                var new_post_id = objData.post_id;
                if (typeof(imgsrc) == 'object') {
                    $('#new_post_form')[0].reset();
                    $('.new_post').addClass("error_placeholder").attr("placeholder", imgsrc[0]);
                    setTimeout(function() {
                        $('.new_post').removeClass("error_placeholder").attr("placeholder", 'What\'s on your mind?');
                    }, 5000);
                    return false;
                }
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
            $('.new_comment div.prof_img img').attr("src", $('.profile-photo img').attr("src"));
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



$("#profile_photo").change(function() {

    if ($('#profile_photo').val() != '') {
        $('#profile_pic_form').submit();
    }
});

$('#profile_pic_form').submit(function(event) {
    event.preventDefault();
    var image_name = $('#profile_photo').val();
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
        url: "ajaxProfile.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function(data) {
            if (data != '') {
                var imgsrc = JSON.parse(data);
                if (typeof(imgsrc) == 'object') {
                    alert(imgsrc[0]);
                    return false;
                }

                $('.profile-photo').find('img#prof_pic').attr("src", imgsrc);
                $('div.card img#main_pic').attr("src", imgsrc);
                $('.new_comment div.prof_img img').attr("src", imgsrc);
            }
        },
        error: function(err) {
            console.log("Error while uploading profile picture!" + err.toString());
        }
    });

});


function newcomment(event) {

    if (event.keyCode === 13) {
        event.preventDefault();
        var body = event.target.value;
        var post_id = event.target.parentElement.getElementsByClassName('post_id_hidden')[0].value;
        $.ajax({
            url: "ajaxProfile.php",
            method: "POST",
            data: { functionName: "newcomment", body: body, post_id: post_id },
            success: function(data) {
                if (data != '' && data != null) {
                    var fullName = JSON.parse(data);
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
document.getElementById("create_new_group_btn").onclick = function(event) {
    event.preventDefault();
    var name = document.getElementById('new_group_name').value;
    var description = document.getElementById('new_group_description').value;
    var topic = document.getElementById('new_group_topic').value;
    var addedMembers = document.getElementById('new_add_members').value;
    if (document.querySelector('input[name="type_of_group"]:checked') != null) {

        var typeOfGroup = document.querySelector('input[name="type_of_group"]:checked').value;
    } else {
        return 0;
    }
    if (name != '') {
        if (description != '') {
            if (topic != '') {
                if (typeOfGroup != '') {
                    // name = htmlEntities(name);
                    description = description;
                    topic = topic;
                    addedMembers = addedMembers;
                    typeOfGroup = typeOfGroup;
                    $.ajax({
                        url: "ajaxProfile.php",
                        method: "POST",
                        data: {
                            functionName: "create_new_group",
                            name: name,
                            description: description,
                            topic: topic,
                            addedMembers: addedMembers,
                            typeOfGroup: typeOfGroup
                        },
                        success: function(data) {
                            console.log(data);
                            window.location.href = JSON.parse(data).location;
                        },
                        error: function(err) {
                            console.log("Error while creating the group!" + err.toString());
                        }
                    });

                }
            } else {
                document.getElementById('new_group_topic').classList.add("error_placeholder");
                document.getElementById('new_group_topic').placeholder = "Please add a topic for your group.";
            }
        } else {
            document.getElementById('new_group_description').classList.add("error_placeholder");
            document.getElementById('new_group_description').placeholder = "Please type a description for your group.";
        }
    } else {
        document.getElementById('new_group_name').classList.add("error_placeholder");
        document.getElementById('new_group_name').placeholder = "Please type a name for your group.";
    }
    console.log('Submited!');
};

function viewMoreComments(event) {
    event.preventDefault();
    var parent = findAncestor(event.target, 'footer').getElementsByClassName('comments_w')[0];
    var hiddenComments = parent.getElementsByClassName('comment_child_hidden');
    for (var i = 0; i < hiddenComments.length; i++) {
        hiddenComments[i].style.display = 'block';
    }
    event.target.style.display = 'none';
}

function findAncestor(el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el;
}
//TODO:FIXME:Permiresim Per kommentet nqs ka shum i merr disa nga db-ja,Per me vone;
// function viewMoreComments(event) {
//     event.preventDefault();
//     var post_id = event.target.parentElement.getElementsByClassName('input')[0].getElementsByClassName('post_id_hidden')[0].value;
//     $.ajax({
//         url: "ajaxProfile.php",
//         method: "POST",
//         data: { functionName: "fetchMoreComments", post_id: post_id },
//         success: function(data) {
//             if (data != '' && data != null) {
//                 var fetchedComments = JSON.parse(data);
//                 var parent = findAncestor(event.target, 'footer').getElementsByClassName('comments_w')[0];
//                 var parent = findAncestor(event.target, 'footer').getElementsByClassName('comments_w');
//                 var newCommentHtml = parent[0].getElementsByClassName('comment_child')[parent[0].getElementsByClassName('comment_child').length - 1].cloneNode(true);
//                 //  var newCommentHtml = parent.children[0].cloneNode(true);
//                 newCommentHtml.style = '';
//                 newCommentHtml.getElementsByClassName('comment_footer')[0].getElementsByClassName('time')[0].innerHTML = "Just Now";
//                 newCommentHtml.getElementsByClassName('user')[0].innerHTML = fullName.first_name + ' ' + fullName.last_name;
//                 newCommentHtml.getElementsByClassName('output')[0].innerHTML = htmlEntities(event.target.value);
//                 newCommentHtml.getElementsByClassName('img-profile profile_picture')[0].src = document.getElementsByClassName('new_comment')[0].getElementsByClassName('img-profile profile_picture')[0].src;
//                 parent[0].getElementsByClassName('comment_child')[0].parentElement.insertBefore(newCommentHtml, parent[0].getElementsByClassName('comment_child')[0]);
//                 event.target.value = '';
//             }
//         },
//         error: function(err) {
//             console.log("Error while creating the comment!" + err.toString());
//         }
//     });
// }