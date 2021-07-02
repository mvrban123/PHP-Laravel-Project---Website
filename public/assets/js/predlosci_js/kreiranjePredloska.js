$(document).ready(function () {
    "use strict";

    var prikazButton = document.getElementById("previewPredloska");

    prikazButton.addEventListener("click", function(){
       

        var htmlZaPrikaz = $.parseHTML(document.getElementById("unosPredloska").value);
    
        $("#pregledPredloska").empty();
        $("#pregledPredloska").append(htmlZaPrikaz);

        
    });


});