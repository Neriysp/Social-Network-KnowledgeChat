$('.form').find('input, textarea').on('keyup blur focus', function(e) {

    var $this = $(this),
        label = $this.prev('label');

    if (e.type === 'keyup') {
        if ($this.val() === '') {
            label.removeClass('active highlight');
        } else {
            label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
        if ($this.val() === '') {
            label.removeClass('active highlight');
        } else {
            label.removeClass('highlight');
        }
    } else if (e.type === 'focus') {

        if ($this.val() === '') {
            label.removeClass('highlight');
        } else if ($this.val() !== '') {
            label.addClass('highlight');
        }
    }

});

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

$("#resetbtn").click(function() {
    if (($("input[name='confirmpassword']").val() != $("input[name='newpassword']").val()) || $("input[name='confirmpassword']").val() == '') {
        $("input[name='confirmpassword']").val('');
        $("input[name='newpassword']").val('');
        $("#hPass").html("<span style='color:red;'>Passwords do not match or empty!</span>").fadeIn(600);
    } else {
        var newPass = $("input[name='newpassword']").val();
        var confPass = $("input[name='confirmpassword']").val();
        var email = $("input[name='email']").val();
        $.ajax({
            url: 'reset_password.php',
            type: 'POST',
            data: { newPassword: newPass, confirmpassword: confPass, email: email }
        }).done(function(data) {
            window.location.href = data;
        });
    }
})