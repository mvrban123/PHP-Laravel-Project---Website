$(document).ready(function () {
    "use strict";

    var usernameError = true,
        emailError = true,
        passwordError = true,
        passConfirm = true;

    // Detect browser for css purpose
    if (navigator.userAgent.toLowerCase().indexOf("firefox") > -1) {
        $(".form form label").addClass("fontSwitch");
    }

    // Label effect
    $("input").focus(function () {
        $(this).siblings("label").addClass("active");
    });

    // Form validation
    $("input").blur(function () {
        // User Name
        if ($(this).hasClass("name")) {
            if ($(this).val().length === 0) {
                $(this)
                    .siblings("span.error")
                    .text("Unesite vaše ime i prezime")
                    .fadeIn()
                    .parent(".form-group")
                    .addClass("hasError");
                usernameError = true;
            } else if ($(this).val().length > 1 && $(this).val().length <= 6) {
                $(this)
                    .siblings("span.error")
                    .text("Korisničko ime mora imati više od 6 znakova")
                    .fadeIn()
                    .parent(".form-group")
                    .addClass("hasError");
                usernameError = true;
            } else {
                $(this)
                    .siblings(".error")
                    .text("")
                    .fadeOut()
                    .parent(".form-group")
                    .removeClass("hasError");
                usernameError = false;
            }
        }
        // Email
        if ($(this).hasClass("email")) {
            if ($(this).val().length == "") {
                $(this)
                    .siblings("span.error")
                    .text("Unesite vaš e-mail")
                    .fadeIn()
                    .parent(".form-group")
                    .addClass("hasError");
                emailError = true;
            } else {
                $(this)
                    .siblings(".error")
                    .text("")
                    .fadeOut()
                    .parent(".form-group")
                    .removeClass("hasError");
                emailError = false;
            }
        }

        // PassWord
        if ($(this).hasClass("pass")) {
            if ($(this).val().length < 8) {
                $(this)
                    .siblings("span.error")
                    .text("Lozinka mora imati više od 7 znakova")
                    .fadeIn()
                    .parent(".form-group")
                    .addClass("hasError");
                passwordError = true;
            } else {
                $(this)
                    .siblings(".error")
                    .text("")
                    .fadeOut()
                    .parent(".form-group")
                    .removeClass("hasError");
                passwordError = false;
            }
        }

        // PassWord confirmation
        if ($(".pass").val() !== $(".passConfirm").val()) {
            $(".passConfirm")
                .siblings(".error")
                .text("Passwords don't match")
                .fadeIn()
                .parent(".form-group")
                .addClass("hasError");
            passConfirm = false;
        } else {
            $(".passConfirm")
                .siblings(".error")
                .text("")
                .fadeOut()
                .parent(".form-group")
                .removeClass("hasError");
            passConfirm = false;
        }

        // label effect
        if ($(this).val().length > 0) {
            $(this).siblings("label").addClass("active");
        } else {
            $(this).siblings("label").removeClass("active");
        }
    });

    // form switch
    $("a.switch").click(function (e) {
        $(this).toggleClass("active");
        e.preventDefault();

        if ($("a.switch").hasClass("active")) {
            $(this)
                .parents(".form-peice")
                .addClass("switched")
                .siblings(".form-peice")
                .removeClass("switched");
        } else {
            $(this)
                .parents(".form-peice")
                .removeClass("switched")
                .siblings(".form-peice")
                .addClass("switched");
        }
    });

    // Form submit
    $("form.signup-form").submit(function (event) {
        event.preventDefault();

        if (
            usernameError == true ||
            emailError == true ||
            passwordError == true ||
            passConfirm == true
        ) {
            $(".name, .email, .pass, .passConfirm").blur();
        } else {
            $(".signup, .login").addClass("switched");

            setTimeout(function () {
                $(".signup, .login").hide();
            }, 700);
            setTimeout(function () {
                $(".brand").addClass("active");
            }, 300);
            setTimeout(function () {
                $(".heading").addClass("active");
            }, 600);
            setTimeout(function () {
                $(".success-msg p").addClass("active");
            }, 900);
            setTimeout(function () {
                $(".success-msg a").addClass("active");
            }, 1050);
            setTimeout(function () {
                $(".form").hide();
            }, 700);
        }
    });

    // Reload page
    $("a.profile").on("click", function () {
        location.reload(true);
    });

    $("#rst-submit").on("click", function () {

        /*
            1. pokupi podatke s gumbova
            2. validiraj (//TODO)
            3. pošalji zahtjev na kontroler
            4. ako ok:
                poruka o poslanom emailu
               inače: 
                poruka pogreške 
        */

        var email = document.getElementById("pwd_res_email").value;
        var oib = document.getElementById("pwd_res_oib").value;
        // console.log(email + " " + oib);

        var payload = {
            'email': email,
            'oib': oib
        }

        fetch('reset-pwd/request', {
            method: 'post', // or 'PUT'
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
            },
            body:  JSON.stringify(payload),
        })
        .then(response => response.json())
        .then(data => {
            if (data["status"] == "error")
            {
                document.getElementById("reset-ok").style.display = "none";
                document.getElementById("reset-err").style.display = "block";
            }
            else
            {
                document.getElementById("reset-err").style.display = "none";
                document.getElementById("reset-ok").style.display = "block";
            }
        })
        .catch((error) => {
            document.getElementById("reset-err").style.display = "block";
            console.error('Error:', error);
            toastr.error('Greška kod slanja zahtjeva za promijenu lozinke');
        });

    });
});
