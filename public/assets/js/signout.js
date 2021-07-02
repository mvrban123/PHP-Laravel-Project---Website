$(document).ready(function () {

    $("#a-signout").on("click", function (e) {
        e.preventDefault();
        var payload = {
            'signout': '1'
        };

        fetch('../signout', {
            method: 'post',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
            },
            body:  JSON.stringify(payload),
        })
        .then(response => response.json())
        .then(data => {
            if (data["status"] == "error")
            {
                console.error('Error:', error);
                toastr.success('Došlo je do pogreške prilikom pokušaja odjave.');

            }
            else
            {
                window.location.replace("../login");
            }
        })

        .catch((error) => {
            console.error('Error:', error);
        });


    });

});