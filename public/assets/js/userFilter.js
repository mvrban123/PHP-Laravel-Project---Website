$( document ).ready(function() {
    "use strict";
    var filter = document.querySelector(".filter");
});

document.getElementById("btnGrupa").addEventListener("click", function() {
    var parameters = new Array();
    fetch('../DohvatiViewPretrage', {
        method: 'post', // or 'PUT'
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": $('input[name="_token"]').val()
        },
        body:  JSON.stringify(parameters),
    })
    .then(response => response.text())
    .then(data => {
        $("#elementiPretrage").html(data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});

document.getElementById("btnObrisiFilterPretrage").addEventListener("click", function() {
    var parameters = new Array();
    fetch('../ObrisiFilterPretrage', {
        method: 'post', // or 'PUT'
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": $('input[name="_token"]').val()
        },
        body:  JSON.stringify(parameters),
    })
    .then(response => response.text())
    .then(data => {
        console.log('Success:', data);
        $("#elementiPretrage").html(data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});

function promjeniVezuElemenata(elementGrupe){
    var parentElement = document.getElementById(elementGrupe).parentElement.id;
    var value = document.getElementById(elementGrupe).value;
    console.log('Success:', parentElement);
    console.log('Success:', value);
    var parameters={
            elementPretrage: parentElement,
            vrijednost: value
    }
    fetch('../PromjeniTipVeze', {
        method: 'post', // or 'PUT'
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": $('input[name="_token"]').val()
        },
        body:  JSON.stringify(parameters),
    })
    .then(response => response.text())
    .then(data => {
        $("#elementiPretrage").html()
        $("#elementiPretrage").html(data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function promjeniTipVezeElemenata(elementGrupe){
    var parentElement = document.getElementById(elementGrupe).parentElement.id;
    var value = document.getElementById(elementGrupe).value;
    console.log('Success:', parentElement);
    console.log('vrijednost:', value);
    var parameters={
            elementPretrage: parentElement,
            vrijednost: value
    }
    fetch('../PromjeniTipVezeElementa', {
        method: 'post', // or 'PUT'
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": $('input[name="_token"]').val()
        },
        body:  JSON.stringify(parameters),
    })
    .then(response => response.text())
    .then(data => {
        $("#elementiPretrage").html()
        $("#elementiPretrage").html(data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function deleteButton(idPretrage){
    var parentElement = document.getElementById(idPretrage).parentElement.id;
    
    if(parentElement != 'elementiPretrage'){
        var parameters={
            grupaPretrage: parentElement,
            idPretraga: idPretrage
        }
        
        fetch('../UkloniElementPretrage', {
            method: 'post', // or 'PUT'
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $('input[name="_token"]').val()
            },
            body:  JSON.stringify(parameters),
        })
        .then(response => response.text())
        .then(data => {
            console.log('Success:', data);
            $("#elementiPretrage").html();
            $("#elementiPretrage").html(data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
}

function loadButton(idGrupa, tag){
        //toastr.info(tag);
        //var elementPretraga=document.getElementsByClassName("").value;
        var elementPretraga=document.getElementById(tag).value;
        //toastr.info(elementPretraga);
        var parameters={elementPretrage: elementPretraga,
            idGrupe: idGrupa}
        fetch('../DodajElementPretrage', {
            method: 'post', // or 'PUT'
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $('input[name="_token"]').val()
            },
            body:  JSON.stringify(parameters),
        })
        .then(response => response.text())
        .then(data => {
            $("#elementiPretrage").html(data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

function setTypePretrage(idPretrage, idComboBox){
    var element = document.getElementById(idPretrage).getElementsByClassName(idComboBox);
    console.log(element);
    console.log(element[0].value);
    var parameters={idPretraga: idPretrage, 
                    idComboBoxa: idComboBox, 
                    value: element[0].value};   
    fetch('../ComboBoxSetValue', {
        method: 'post', // or 'PUT'
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": $('input[name="_token"]').val()
        },
        body:  JSON.stringify(parameters),
    })
    .then(response => response.text())
    .then(data => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function pretraziButton(){
    fetch('../PretraziObitelji', {
        method: 'post', // or 'PUT'
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": $('input[name="_token"]').val()
        },
        body:  "",
    })
    .then(response => response.text())
    .then(data => {
        //if(!)
        $('table').remove();
        $('.table-responsive').html(data);
        $("#dataTable").DataTable({
            pageLength: 10,
            select: true,
            lengthMenu: [10, 25, 50, 100, 500],
            aaSorting: [],
            order: [[0, "asc"]],
            buttons: [
                {
                    text: 'My button',
                    action: function ( e, dt, node, config ) {
                        alert( 'Button activated' );
                    }
                }
            ],
            language: {
                searchPlaceholder: "Traži",
                search: "",
                info: "Prikazujem _START_ do _END_ od _TOTAL_ unosa",
                lengthMenu: "Prikaži _MENU_ unosa",
                infoEmpty: "Prikazujem 0 do 0 od 0 unosa",
                infoFiltered: "(filtrirano od _MAX_ ukupnih unosa)",
                zeroRecords: "Nisu pronađeni rezultati pretrage",
                paginate: {
                    next: "Sljedeća",
                    previous: "Prethodna",
                },
            },
        });
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

