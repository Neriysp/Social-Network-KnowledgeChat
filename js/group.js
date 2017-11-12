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
        $('.wrapper').css({ "grid-template-columns": " 1fr 1.5fr 1.5fr 20px" });
        $('.hide_chat').html('<i class="fa fa-chevron-left" aria-hidden="true"></i>');
    } else {
        $('.sidebar').show();
        $('.wrapper').css({ "grid-template-columns": " 1fr 1.5fr 1.5fr 20px 0.5fr" });
        $('.hide_chat').html('<i class="fa fa-chevron-right" aria-hidden="true"></i>');
    }
})