$(document).ready(function () {
    $("#submit-new-pwd").on("click", function () {
        var email = document.getElementById("resEmail").value;
        var oib = document.getElementById("resOib").value;
        var password = document.getElementById("resPassword").value;
        var resetToken = getCookie('reset_url');

        var payload = {
            'resetToken': resetToken,
            'email': email,
            'oib': oib,
            'password': password
        }

        fetch('set-new', {
            method: 'post',
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
            toastr.error('Greška kod slanja zahtjeva za promjenu lozinke');
        });
    });

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
      }
});