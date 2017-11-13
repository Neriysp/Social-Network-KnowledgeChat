$(function() {
    //----- OPEN
    $('[data-popup-open]').on('click', function(e) {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);

        e.preventDefault();
    });

    //----- CLOSE
    $('[data-popup-close]').on('click', function(e) {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

        e.preventDefault();
    });
});

function FilerGrid() {
    // Declare variables
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
    if (image_name == '') {
        var extension = null;
    } else {
        var extension = $('#image').val().split('.').pop().toLowerCase();
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
            var arr = JSON.parse(data);
            if (arr.length == 2) {
                var imgsrc = arr[1];
                if ($('div.Posted_posts div.card:first-child').find('img.img-primary').length) {
                    $("div.Posted_posts").prepend('<div class="card">' + $('div.Posted_posts div.card:first-child').html());
                } else {
                    $("<img src='' class='img-primary' style='display:none;'>").insertAfter(".body");
                    $("div.Posted_posts").prepend('<div class="card">' + $('div.Posted_posts div.card:first-child').html());
                }
                $('div.Posted_posts div.card:first-child').find('img.img-primary').css('display', 'block');
                $('div.Posted_posts div.card:first-child img.img-primary').attr("src", imgsrc);
            } else {
                $("div.Posted_posts").prepend('<div class="card">' + $('div.Posted_posts div.card:first-child').html());
                if ($('div.Posted_posts div.card:first-child').find('img.img-primary').length) {
                    $('div.Posted_posts div.card:first-child').find('img.img-primary').css('display', 'none');
                }
            }
            var body = arr[0];
            $('#new_post_form')[0].reset();
            $('div.Posted_posts div.card:first-child p').html(body);
            $('div.Posted_posts div.card:first-child').find('a.time').html('Just now');
        }
    });

});