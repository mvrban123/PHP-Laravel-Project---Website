$( document ).ready(function() {
    var table = document.getElementById("dataTable").rows[0].cells[0].innerHTML;
    for (var i=1;i<=table;i++){
        var select1=document.getElementById("dataTable").rows[i].cells[6].innerHTML;
        console.log(select1);
        document.getElementById(select1).addEventListener('click',function(){
            var button = $(this).attr('data');
            console.log(button);
            fetch('/email/prikaz', {
                method: 'post', // or 'PUT'
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                },
                body:  JSON.stringify(button),
            })
            .then(response => response.text())
            .then(data => {
                //console.log('Success:', data);
                $("#elementiPretrage").html(data).text();
                var htmlZaPrikaz = $.parseHTML(document.getElementById("tijeloPoruke").innerHTML);
                console.log(htmlZaPrikaz);
                $("#tijeloPoruke").empty();
                $("#tijeloPoruke").append(htmlZaPrikaz);
                
            })
            .catch((error) => {
                console.error('Error:', error);
                toastr.error('Greška kod ažuriranja')
            });
        });
    }
});
