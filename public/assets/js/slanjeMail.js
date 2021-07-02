$(document).ready(function () {
    "use strict";
    
    var table = $("#tablica").DataTable({
        select: {
            style: 'single'
        },
        "ordering": false
    });

    var prikaziButton = document.getElementById("prikaziMail");

    var selectElement = document.getElementById("predlozak");

    var elementTablice = document.getElementsByName("ime");

    function vratiText(){

        var selectedData =  table.rows( {selected: true} ).data().toArray();
        
        /*
        if(selectedData == ""){
            return;
        }
        */

        var stringZaProvjeraPolja = selectedData.join();

        var boolProvjeraPolja = stringZaProvjeraPolja.includes("primatelj");
        
        
        if(boolProvjeraPolja == false){
            var oznaceniRed = table.row( {selected: true} ).index();

           var selectedData = table.rows( oznaceniRed + 1 ).data().toArray();
        }
        
        var idZaPrikazSaZarezima = String(selectedData).match(/("\d+")*/gi);
        var idZaPrikazSaNavodnicima = String(idZaPrikazSaZarezima).replace(/,/gi,"");
        var idZaPrikaz = String(idZaPrikazSaNavodnicima).replace(/"/gi,"");

        //TODO IF AKO NEMA NITI JEDAN OZNAČEN DA PRIMA MAIL
        if(true){
            
        }
        var podaciZaDohvatPredloska = {};
        podaciZaDohvatPredloska["predlozak"] = document.getElementById('predlozak').value;
        podaciZaDohvatPredloska["korisnik"] = idZaPrikaz;
        var rezultat = "";

        var rezultat;
        var rezultatCekanja = fetch('../email/predlozak', {
            method: 'post', // or 'PUT'
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $('input[name="_token"]').val()
            },
            body:  JSON.stringify(podaciZaDohvatPredloska),
        })
        .then(response => response.text())
        .then(data => rezultat = data)
        .then(() => {

        console.log('Success:', rezultat);
        $("#pregledPredloska").empty();
        $("#pregledPredloska").append(rezultat);
        return rezultat;

        })
        .catch((error) => {
        console.error('Error:', error)});
        return rezultat;
        
    }

    /*
    prikaziButton.addEventListener("click", function(){
        
        
        var textZaPrikaz = vratiText();
        
    });

    */

    selectElement.addEventListener("click", function(){
       
        
        var textZaPrikaz = vratiText();
        
        
    });
    

    /*
    elementTablice[0].addEventListener("click", function(){
        
       
        var textZaPrikaz = vratiText();
        
        
    });

    */

    table.on( 'select', function ( e, dt, type, indexes ) {
        textZaPrikaz = vratiText();
    } );

});

