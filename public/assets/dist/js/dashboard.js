$(() => {
    $(".show-password").click(function () {
        let inptPassword = $(this).siblings("input");

        console.log(inptPassword);
        if (inptPassword.prop("type") == "password") {
            inptPassword.prop("type", "text");
        } else {
            inptPassword.prop("type", "password");
        }

        let iconEye = $(this).find("i");
        iconEye.toggleClass("fa-eye fa-eye-slash");

        if (iconEye.hasClass("fa-eye")) {
            iconEye.prop("title", "show password");
        } else {
            iconEye.prop("title", "hide password");
        }
    });

    $("#show-profile").on("click", function (e) {
        $(this).siblings('.dropdown-menu').slideToggle();
    });
});
