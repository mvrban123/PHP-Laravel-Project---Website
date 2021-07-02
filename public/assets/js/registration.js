$( document ).ready(function() {
"use strict";
var counter= 0;
var nextBtn = document.querySelector(".nextBtn");
var back = document.querySelector(".backBtn");
var dodaj = document.querySelector("#dodaj");
var aktivnoSudjelovanje = document.querySelector("#participation");
var aktivnoSudjelovanje2 = document.querySelector("#participation2");
var konacanKorakRegistracije = false;
var objDjeca = {};
var djecaBrojac = 0;

//sameAddres, ista adresa
document.getElementById("sameAddress").addEventListener("click",function(){
var istaAdresa= document.querySelector(".sameAddress").checked;
if(istaAdresa){
    var rucniUnos= document.getElementById("rucniUnos");
    if (rucniUnos.checked) {
        document.getElementById("AdreseBaza2").style.display = "none";
        document.getElementById("AdreseRucno2").style.display = "grid";
        document.getElementById("rucniUnos2").checked="true";
        document.getElementById("street2").value=document.getElementById("street").value;
        document.getElementById("streetNumber2").value=document.getElementById("streetNumber").value;
        document.getElementById("placeOfResidence2").value=document.getElementById("placeOfResidence").value;
        document.getElementById("country2").value=document.getElementById("country").value;
        document.getElementById("zipCode2").value=document.getElementById("zipCode").value;
    }
    else{
        document.getElementById("street2").value=document.getElementById("street").value;
        document.getElementById("streetNumber2").value=document.getElementById("streetNumber").value;
        document.getElementById("placeOfResidence2").value=document.getElementById("placeFromBase").value;
        document.getElementById("country2").value=document.getElementById("countryFromBase").value;
        document.getElementById("zipCode2").value=document.getElementById("zipCode").value;
    }
     
}
else{
    document.getElementById("street2").value="";
    document.getElementById("streetNumber2").value="";
    document.getElementById("placeOfResidence2").value="";
    document.getElementById("country2").value="";
    document.getElementById("zipCode2").value="";

}

});

//hand input or input from base rucni unos ili unos iz baze
document.getElementById("rucniUnos").addEventListener("click",function(){
    var rucniUnos= document.getElementById("rucniUnos");

    if(rucniUnos.checked){
        document.getElementById("AdreseBaza").style.display = "none";
        document.getElementById("AdreseRucno").style.display = "grid";

    }

    else{
        document.getElementById("AdreseBaza").style.display = "grid";
        document.getElementById("AdreseRucno").style.display = "none";
    }
});
//hand input or input from base rucni unos ili unos iz baze 2
document.getElementById("rucniUnos2").addEventListener("click",function(){
    var rucniUnos= document.getElementById("rucniUnos2");

    if(rucniUnos.checked){
        document.getElementById("AdreseBaza2").style.display = "none";
        document.getElementById("AdreseRucno2").style.display = "grid";

    }

    else{
        document.getElementById("AdreseBaza2").style.display = "grid";
        document.getElementById("AdreseRucno2").style.display = "none";
    }
});

//validation of registration form, validacija registracijske forme

//function set error sets designe for bad inputs 
function setError(input, message) {
	const formGrup = input.parentElement;
	const small = formGrup.querySelector('small');
    const iconError =formGrup.querySelector('i.fa-exclamation-circle');
    const iconSucces =formGrup.querySelector('i.fa-check-circle');
    iconError.style.display = "inline";
    iconError.style.color="#f95959";
    iconSucces.style.display = "none";
	formGrup.className = 'form-grup error';
	small.innerText = message;
}

//function set error sets designe for good inputs 
function setSuccess(input, message) {
	const formGrup = input.parentElement;
    const small = formGrup.querySelector('small');
    const iconError =formGrup.querySelector('i.fa-exclamation-circle');
    const iconSucces =formGrup.querySelector('i.fa-check-circle');
    iconError.style.display = "none";
    iconSucces.style.display = "inline";
    iconSucces.style.color="#1ee018";
	formGrup.className = 'form-grup success';
    small.innerText = message;
}



// variables for 1 st parent varijable za provjeru unosa kod 1 roditelja
var korIme=document.getElementById("userName");
var password=document.getElementById("password");
var passCon=document.getElementById("passwordCon");
var email=document.getElementById("email");
var name=document.getElementById("name");
var surname=document.getElementById("surname");
var OIB=document.getElementById("OIB");
var phone=document.getElementById("phone");
var telephone=document.getElementById("telephone");
var street=document.getElementById("street");
var streetNumber=document.getElementById("streetNumber");
var nameChild=document.getElementById("nameChild");
var lastNameChild=document.getElementById("lastNameChild");
var OIBChild=document.getElementById("OIBChild");
var BirthChild = document.getElementById("BirthChild");
var  confirmation=document.getElementById('confirmation');

function checkChild(){
    var pattern= new RegExp('^([0-9]{11})$');
    if(nameChild.value!=""&&lastNameChild.value!=""&& pattern.test(OIBChild.value) && BirthChild.value!=""){
        return true;
    }
    else return false;
}

function checkParent1(){
    var pattern= new RegExp('^([0-9]{11})$');
    var pattern2= new RegExp('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$');
    if(korIme.value.length>6 &&password.value.length>6 && passCon.value==password.value && pattern.test(OIB.value) && pattern2.test(email.value)
     && name.value!="" && surname.value!="" && street.value!="" && streetNumber.value!="" ){
        return true;
    }
    else return false;
}
//provjera korisničkog unosa na kraju za 1 roditelja
confirmation.addEventListener("click",function(){
    if(confirmation.checked){
        var singleParent=document.querySelector(".singleParent").checked
        if(checkParent1() && singleParent){
            setSuccess(confirmation, "");
            document.getElementById("CTA").style.display = "inherit";
        }else {
            if(singleParent){
            setError(confirmation, " \n Neka polja koja su obavezna (korisnicko ime, ime, prezime, lozinka, email, oib, datum, ulica, ulični broj) nisu ispunjena na pravilan način \n kada ispravite spomenuta polja ponovno odznačite i označite ovo polje");
            document.getElementById("CTA").style.display = "none";
            }
        }

    }
});

//functions that triggers on event change for 1 st parent
korIme.addEventListener("change",function(){
    
    if(korIme.value.length<=6){
        korIme.style.borderColor= "red";
        setError(korIme, "Korisničko ime nema dovoljno znakova");
    }
    if(korIme.value.length>6){
        korIme.style.borderColor= "green";
        setSuccess(korIme, "Korisničko ime je ispravno unesno");
    }
});



password.addEventListener("change",function(){
    if(password.value.length<=6){
        password.style.borderColor= "red";
        setError(password, "Lozinka nema dovoljno znakova");
    }
    if(password.value.length>6){
        password.style.borderColor= "green";
        setSuccess(password, "Lozinka je ispravno unesena");
    }
});

passCon.addEventListener("change",function(){
    if(password.value!=passCon.value){
        passCon.style.borderColor= "red";
        setError(passCon, "Nije ispravno ponovljena vrijednost");
    }
    if(password.value==passCon.value){
        passCon.style.borderColor= "green";
        setSuccess(passCon, "Ispravno");
    }
});

email.addEventListener("change",function(){

var pattern= new RegExp('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$');
if(pattern.test(email.value)){
setSuccess(email,"Ispravan upis");
email.style.borderColor="green";
}
else{
    setError(email,"E-mail nije ispravan");
    email.style.borderColor="red";
}
});

name.addEventListener("change",function(){
if(name.value!=""){
    setSuccess(name,"Ispravan upis");
    name.style.borderColor="green";
}
else{
    setError(name,"Unesite ime");
    name.style.borderColor="red";
}
});

surname.addEventListener("change",function(){
    if(surname.value!=""){
        setSuccess(surname,"Ispravan upis");
        surname.style.borderColor="green";
    }
    else{
        setError(surname,"Unesite prezime");
        surname.style.borderColor="red";
    }
});

OIB.addEventListener("change",function(){
    var pattern= new RegExp('^([0-9]{11})$');
    if(pattern.test(OIB.value)){
        setSuccess(OIB,"Ispravan upis");
        OIB.style.borderColor="green";
    }
    else{
        setError(OIB,"Neispravan OIB, treba sadržavati 11 znamenki");
        OIB.style.borderColor="red";
    }

});

phone.addEventListener("change",function(){
    if(phone.value!=""){
        setSuccess(phone,"Ispravan upis");
        phone.style.borderColor="green";
    }
    else{
        setError(phone,"Unesite broj mobitela ili telefona");
        phone.style.borderColor="red";
    }
});

telephone.addEventListener("change",function(){
    if(telephone.value!=""){
        setSuccess(telephone,"Ispravan upis");
        telephone.style.borderColor="green";
    }
    else{
        setError(telephone,"Unesite broj mobitela ili telefona");
        telephone.style.borderColor="red";
    }
});


street.addEventListener("change",function(){
    if(street.value!=""){
        setSuccess(street,"Ispravan upis");
        street.style.borderColor="green";
    }
    else{
        setError(street,"Unesite svoju ulicu");
        street.style.borderColor="red";
    }
});

streetNumber.addEventListener("change",function(){
    if(streetNumber.value!=""){
        setSuccess(streetNumber,"Ispravan upis");
        streetNumber.style.borderColor="green";
    }
    else{
        setError(streetNumber,"Unesite svoju kućni broj");
        streetNumber.style.borderColor="red";
    }
});

zipCode.addEventListener("change",function(){
    if(zipCode.value!=""){
        setSuccess(zipCode,"Ispravan upis");
        zipCode.style.borderColor="green";
    }
    else{
        setError(zipCode,"Unesite poštanski broj");
        zipCode.style.borderColor="red";
    }

});

nameChild.addEventListener("change",function(){
    if(nameChild.value!=""){
        setSuccess(nameChild,"Ispravan upis");
        nameChild.style.borderColor="green";
        if(checkChild()){
            document.getElementById("dodaj").style.visibility = "visible";
        }
    }
    else{
        setError(nameChild,"Unesite ime djeteta");
        nameChild.style.borderColor="red";
    }
});

lastNameChild.addEventListener("change",function(){
    if(lastNameChild.value!=""){
        setSuccess(lastNameChild,"Ispravan upis");
        lastNameChild.style.borderColor="green";
        if(checkChild()){
            document.getElementById("dodaj").style.visibility = "visible";
        }
    }
    else{
        setError(lastNameChild,"Unesite prezime djeteta");
        lastNameChild.style.borderColor="red";
    }
});

OIBChild.addEventListener("change",function(){
    var pattern= new RegExp('^([0-9]{11})$');
    if(pattern.test(OIBChild.value)){
        setSuccess(OIBChild,"Ispravan upis");
        OIBChild.style.borderColor="green";
        if(checkChild()){
            document.getElementById("dodaj").style.visibility = "visible";
        }
    }
    else{
        setError(OIBChild,"Neispravan OIB, treba sadržavati 11 znamenki");
        OIBChild.style.borderColor="red";
    }
});

//2-nd parent for validation on registration form

// variables for 2nd parent
var korIme2=document.getElementById("userName2");
var password2=document.getElementById("password2");
var passCon2=document.getElementById("passwordCon2");
var email2=document.getElementById("email2");
var name2=document.getElementById("name2");
var surname2=document.getElementById("surname2");
var OIB2=document.getElementById("OIB2");
var phone2=document.getElementById("phone2");
var telephone2=document.getElementById("telephone2");
var street2=document.getElementById("street2");
var streetNumber2=document.getElementById("streetNumber2");
var confirmation2=document.getElementById("confirmation2");

function checkParent2(){
    var pattern= new RegExp('^([0-9]{11})$');
    var pattern2= new RegExp('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$');
    if( korIme2.value.length > 6 && password2.value.length > 6 && passCon2.value==password2.value && pattern.test(OIB2.value) && pattern2.test(email2.value)
     && name2.value!="" && surname2.value!="" && street2.value!="" && streetNumber2.value!="" ){
        return true;
    }
    else return false;
}

//provjera korisničkog unosa na kraju za oba roditelja
confirmation2.addEventListener("click",function(){
    if(confirmation2.checked){
        var singleParent=document.querySelector(".singleParent").checked
        if(checkParent1() && checkParent2()){
            setSuccess(confirmation2, "");
            document.getElementById("CTA").style.display = "inherit";
        }else {
            setError(confirmation2, " \n Neka polja koja su obavezna (korisnicko ime, ime, prezime, lozinka, email, oib, datum, ulica, ulični broj) nisu ispunjena na pravilan način \n kada ispravite spomenuta polja ponovno odznačite i označite ovo polje");
            document.getElementById("CTA").style.display = "none";
        }
    }
});
//functions that triggers on event change for 2 nd parent

korIme2.addEventListener("change",function(){
    
    if(korIme2.value.length<=6){
        korIme2.style.borderColor= "red";
        setError(korIme2, "Korisničko ime nema dovoljno znakova");
    }
    if(korIme2.value.length>6){
        korIme2.style.borderColor= "green";
        setSuccess(korIme2, "Korisničko ime je ispravno unesno");
    }
});



password2.addEventListener("change",function(){
    if(password2.value.length<=6){
        password2.style.borderColor= "red";
        setError(password2, "Lozinka nema dovoljno znakova");
    }
    if(password2.value.length>6){
        password2.style.borderColor= "green";
        setSuccess(password2, "Lozinka je ispravno unesena");
    }
});

passCon2.addEventListener("change",function(){
    if(password2.value!=passCon2.value){
        passCon2.style.borderColor= "red";
        setError(passCon2, "Nije ispravno ponovljena vrijednost");
    }
    if(password2.value==passCon2.value){
        passCon2.style.borderColor= "green";
        setSuccess(passCon2, "Ispravno");
    }
});

email2.addEventListener("change",function(){

var pattern= new RegExp('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$');
if(pattern.test(email2.value)){
setSuccess(email2,"Ispravan upis");
email2.style.borderColor="green";
}
else{
    setError(email2,"E-mail nije ispravan");
    email2.style.borderColor="red";
}
});

name2.addEventListener("change",function(){
if(name2.value!=""){
    setSuccess(name2,"Ispravan upis");
    name2.style.borderColor="green";
}
else{
    setError(name2,"Unesite ime");
    name2.style.borderColor="red";
}
});

surname2.addEventListener("change",function(){
    if(surname2.value!=""){
        setSuccess(surname2,"Ispravan upis");
        surname2.style.borderColor="green";
    }
    else{
        setError(surname2,"Unesite prezime");
        surname2.style.borderColor="red";
    }
});

OIB2.addEventListener("change",function(){
    var pattern= new RegExp('^([0-9]{11})$');
    if(pattern.test(OIB2.value)){
        setSuccess(OIB2,"Ispravan upis");
        OIB2.style.borderColor="green";
    }
    else{
        setError(OIB2,"Neispravan OIB, treba sadržavati 11 znamenki");
        OIB2.style.borderColor="red";
    }

});

phone2.addEventListener("change",function(){
    if(phone2.value!=""){
        setSuccess(phone2,"Ispravan upis");
        phone2.style.borderColor="green";
    }
    else{
        setError(phone2,"Unesite broj mobitela ili telefona");
        phone2.style.borderColor="red";
    }
});

telephone2.addEventListener("change",function(){
    if(telephone2.value!=""){
        setSuccess(telephone2,"Ispravan upis");
        telephone2.style.borderColor="green";
    }
    else{
        setError(telephone2,"Unesite broj mobitela ili telefona");
        telephone2.style.borderColor="red";
    }
});


street2.addEventListener("change",function(){
    if(street2.value!=""){
        setSuccess(street2,"Ispravan upis");
        street2.style.borderColor="green";
    }
    else{
        setError(street2,"Unesite svoju ulicu");
        street2.style.borderColor="red";
    }
});

streetNumber2.addEventListener("change",function(){
    if(streetNumber2.value!=""){
        setSuccess(streetNumber2,"Ispravan upis");
        streetNumber2.style.borderColor="green";
    }
    else{
        setError(streetNumber2,"Unesite svoju kućni broj");
        streetNumber2.style.borderColor="red";
    }
});

zipCode2.addEventListener("change",function(){
    if(zipCode2.value!=""){
        setSuccess(zipCode2,"Ispravan upis");
        zipCode2.style.borderColor="green";
    }
    else{
        setError(zipCode2,"Unesite poštanski broj");
        zipCode2.style.borderColor="red";
    }

});



// hide or display notes
aktivnoSudjelovanje.addEventListener("change",function(){

    if(aktivnoSudjelovanje.checked){
        document.getElementById("notes").style.visibility = "visible";
    }
    else{
        document.getElementById("notes").style.visibility = "hidden";
    }
});


// hide or display notes2
aktivnoSudjelovanje2.addEventListener("change",function(){

if(aktivnoSudjelovanje2.checked){
    document.getElementById("notes2").style.visibility = "visible";
}
else{
    document.getElementById("notes2").style.visibility = "hidden";
}
});

//moving forward on form registration, kretanje unaprijed po formi registracije
nextBtn.addEventListener("click",function(){
    var samohraniRoditelj= document.querySelector(".singleParent").checked;
    counter++;

    if(counter==1){
    document.getElementById("KorisnickiPodaci").style.display = "none";
    document.getElementById("OsobniPodaci").style.display = "grid";
    document.getElementById("natrag").style.visibility = "visible";
    document.getElementById("b2").style.backgroundColor="#f95959";
    document.getElementById("b2").style.color="#fff";
    }

    if(counter==2){
        document.getElementById("OsobniPodaci").style.display = "none";
        document.getElementById("OstaliOsobniPodaci").style.display = "grid";
        document.getElementById("b3").style.backgroundColor="#f95959";
        document.getElementById("b3").style.color="#fff";
    }

    if(counter==3){
        document.getElementById("OstaliOsobniPodaci").style.display = "none";
        document.getElementById("PodaciOAdresi").style.display = "grid";
        document.getElementById("b4").style.backgroundColor="#f95959";
        document.getElementById("b4").style.color="#fff";
        $(".selectpicker").selectpicker({
            "title": "Select Options"        
        }).selectpicker("render");
    }

    if(counter==4){
        document.getElementById("PodaciOAdresi").style.display = "none";
        document.getElementById("UnosDjece").style.display = "grid";
        document.getElementById("b5").style.backgroundColor="#f95959";
        document.getElementById("b5").style.color="#fff";
        //ta linija
        //document.getElementById("dodaj").style.visibility = "visible";
        var numRows = document.getElementById('tablica').rows.length;
        if(numRows<4){
        document.getElementById("dalje").style.visibility = "hidden";
        }
    }

    if(counter==5){
        
        document.getElementById("UnosDjece").style.display = "none";
        document.getElementById("Potvrde").style.display = "grid";
        document.getElementById("b6").style.backgroundColor="#f95959";
        document.getElementById("b6").style.color="#fff";
        document.getElementById("dodaj").style.visibility = "hidden";

        if(samohraniRoditelj){
        //ta linija
        //document.getElementById("CTA").style.display = "inherit";
        document.getElementById("dalje").style.visibility = "hidden";
        }
        nextBtn.textContent="2. roditelj";

    }

    if(counter==6){
        document.getElementById("Potvrde").style.display = "none";
        document.getElementById("KorisnickiPodaci2").style.display = "grid";
        document.getElementById("b2").style.backgroundColor="#fff";
        document.getElementById("b2").style.color="#000000";
        document.getElementById("b3").style.backgroundColor="#fff";
        document.getElementById("b3").style.color="#000000";
        document.getElementById("b4").style.backgroundColor="#fff";
        document.getElementById("b4").style.color="#000000";
        document.getElementById("b6").style.backgroundColor="#fff";
        document.getElementById("b6").style.color="#000000";
        nextBtn.textContent="Dalje";
    }

    if(counter==7){
        document.getElementById("KorisnickiPodaci2").style.display = "none";
        document.getElementById("OsobniPodaci2").style.display = "grid";
        document.getElementById("b2").style.backgroundColor="#f95959";
        document.getElementById("b2").style.color="#fff";
    }
    if(counter==8){
        document.getElementById("OsobniPodaci2").style.display = "none";
        document.getElementById("OstaliOsobniPodaci2").style.display = "grid";
        document.getElementById("b3").style.backgroundColor="#f95959";
        document.getElementById("b3").style.color="#fff";
    }

    if(counter==9){
            document.getElementById("OstaliOsobniPodaci2").style.display = "none";
            document.getElementById("PodaciOAdresi2").style.display = "grid";
            document.getElementById("b4").style.backgroundColor="#f95959";
            document.getElementById("b4").style.color="#fff";
    }

    if(counter==10){
        document.getElementById("PodaciOAdresi2").style.display = "none";
        document.getElementById("Potvrde2").style.display = "grid";
        document.getElementById("b6").style.backgroundColor="#f95959";
        document.getElementById("b6").style.color="#fff";
        //document.getElementById("CTA").style.display = "inherit";
        document.getElementById("dalje").style.visibility = "hidden";
    }
    
});

//moving backwards on form registration, vraćanje po formi registracije
back.addEventListener("click",function(){
    var samohraniRoditelj= document.querySelector(".singleParent").checked;
    counter--;
    if(counter==0){
        document.getElementById("KorisnickiPodaci").style.display = "grid";
        document.getElementById("OsobniPodaci").style.display = "none";
        document.getElementById("natrag").style.visibility = "hidden";
        document.getElementById("b2").style.backgroundColor="#fff";
        document.getElementById("b2").style.color="#000000";
    }

    if(counter==1){
        document.getElementById("OsobniPodaci").style.display = "grid";
        document.getElementById("OstaliOsobniPodaci").style.display = "none";
        document.getElementById("b3").style.backgroundColor="#fff";
        document.getElementById("b3").style.color="#000000";
    }
    if(counter==2){
        document.getElementById("OstaliOsobniPodaci").style.display = "grid";
        document.getElementById("PodaciOAdresi").style.display = "none";
        document.getElementById("b4").style.backgroundColor="#fff";
        document.getElementById("b4").style.color="#000000";
    }
    if(counter==3){
        
        document.getElementById("PodaciOAdresi").style.display = "grid";
        document.getElementById("UnosDjece").style.display = "none";
        document.getElementById("b5").style.backgroundColor="#fff";
        document.getElementById("b5").style.color="#000000";
        document.getElementById("dalje").style.visibility = "visible";
        document.getElementById("dodaj").style.visibility = "hidden";
    }
    if(counter==4){
        document.getElementById("UnosDjece").style.display = "grid";
        document.getElementById("Potvrde").style.display = "none";
        document.getElementById("dalje").style.visibility = "visible";
        document.getElementById("b6").style.backgroundColor="#fff";
        document.getElementById("b6").style.color="#000000";
        document.getElementById("dodaj").style.visibility = "visible";
        document.getElementById("CTA").style.display = "none";
        nextBtn.textContent="Dalje";

        
    }
    
    if(counter==5){
        document.getElementById("Potvrde").style.display = "grid";
        document.getElementById("KorisnickiPodaci2").style.display = "none";
        document.getElementById("b2").style.backgroundColor="#f95959";
        document.getElementById("b2").style.color="#fff";
        document.getElementById("b3").style.backgroundColor="#f95959";
        document.getElementById("b3").style.color="#fff";
        document.getElementById("b4").style.backgroundColor="#f95959";
        document.getElementById("b4").style.color="#fff";
        document.getElementById("b6").style.backgroundColor="#f95959";
        document.getElementById("b6").style.color="#fff";
        if(!samohraniRoditelj){
            nextBtn.textContent="2. roditelj";
        }
    }
    if(counter==6){
        document.getElementById("KorisnickiPodaci2").style.display = "grid";
        document.getElementById("OsobniPodaci2").style.display = "none";
        document.getElementById("b2").style.backgroundColor="#fff";
        document.getElementById("b2").style.color="#000000";
    }
    if(counter==7){
        document.getElementById("OsobniPodaci2").style.display = "grid";
        document.getElementById("OstaliOsobniPodaci2").style.display = "none";
        document.getElementById("b3").style.backgroundColor="#fff";
        document.getElementById("b3").style.color="#000000";
    }

    if(counter==8){
        document.getElementById("OstaliOsobniPodaci2").style.display = "grid";
        document.getElementById("PodaciOAdresi2").style.display = "none";
        document.getElementById("b4").style.backgroundColor="#fff";
        document.getElementById("b4").style.color="#000000";
    }

    if(counter==9){
        
        document.getElementById("PodaciOAdresi2").style.display = "grid";
        document.getElementById("Potvrde2").style.display = "none";
        document.getElementById("CTA").style.display = "none";
        document.getElementById("dalje").style.visibility = "visible";
        document.getElementById("b6").style.backgroundColor="#fff";
        document.getElementById("b6").style.color="#000000";
        
    }
    
});


    //add row to table , dodavanje retka u tablicu 
    dodaj.addEventListener("click",function(){

        var dijete_objekt = {};
            
        var ime = document.getElementById('nameChild');
        var prezime = document.getElementById('lastNameChild');
        var datum = document.getElementById('BirthChild');
        var OIB = document.getElementById('OIBChild');
        var table = document.getElementById('tablica');
        var newRow = table.insertRow(table.rows.length);

        // add cells to the row dodaje polja u red
        var cel1 = newRow.insertCell(0);
        var cel2 = newRow.insertCell(1);
        var cel3 = newRow.insertCell(2);
        var cel4 = newRow.insertCell(3);
        var cel5 = newRow.insertCell(4);

        // add child to the list of children
        dijete_objekt.idx = djecaBrojac;
        dijete_objekt.ime = ime.value;
        dijete_objekt.prezime = prezime.value;
        dijete_objekt.datum = datum.value;
        dijete_objekt.OIB = OIB.value;
        // listaDjece.push(dijete_objekt);
        objDjeca[djecaBrojac] = dijete_objekt;

        // add values to the cells dodaje vrijednosti u polja
        cel1.innerHTML = ime.value;
        cel2.innerHTML = prezime.value;
        cel3.innerHTML = datum.value;
        cel4.innerHTML = OIB.value;
        cel5.innerHTML = '<input type="button" id="' + djecaBrojac.toString() + '" class="brisiDjeteBtn" value="X"/>';
        ime.value = '';
        prezime.value = '';
        datum.value = '';
        OIB.value = '';
        var numRows = table.rows.length;
        if(numRows > 3){
            document.getElementById("dalje").style.visibility = "visible";
        }

        djecaBrojac += 1;

        document.getElementById("dodaj").style.visibility = "hidden";
    });

    // function to delete children from children list and children table row
    document.getElementById("tablica").addEventListener("click", function(e) {
        // console.log("Clicked: ", e.target.className);

        if(e.target && e.target.className == "brisiDjeteBtn") {
            console.log("Clcked className: ", e.target.className);

            this.deleteRow(e.target.parentNode.parentNode.rowIndex); // BUTTON -> TD -> TR.
            var numRows = this.rows.length;
            if(numRows < 4){
                document.getElementById("dalje").style.visibility = "hidden";
            }

            console.log("Clicked id: ", e.target.id);

            delete objDjeca[e.target.id];

            // listaDjece = listaDjece.filter(function( obj ) {
            //     return obj.idx != e.target.id;
            // });
        }

        console.log(objDjeca);
    });


    document.getElementById("dalje").addEventListener("click", function(e){
        // var submitBtn = document.getElementById("submit");
        // submitBtn.click();
        // submitRegistrationData();
    });

    document.getElementById("submit").addEventListener("click", function(e){

        /*
        TODO:
        0) Ugasiti slanje kroz HTML (prevent default)
        1) Dodati svakom dijetetu roditelje - TREBA NA BACKEND-U
        2) Dodati svakom dijetetu adresu - TREBA NA BACKEND-U
        X 3) Provjeriti dodaje li se drugi roditelj
        X 4) Dodati roditelje u listu parametara
        X 5) Poslati sve POST-om na route registracija 
            
        */

        konacanKorakRegistracije = true;
        submitRegistrationData();     
    });

    function submitRegistrationData()
    {
        var post_parameters = {}

        post_parameters["finalRegStep"] = konacanKorakRegistracije;

        var rod_1 = {
            name:  document.getElementById('name').value,
            lname:  document.getElementById('surname').value,
            oib: document.getElementById('OIB').value,
            email: document.getElementById('email').value,
            passwd: document.getElementById('password').value,
            username: document.getElementById('userName').value,
            dob: document.getElementById('dateOfBirth').value,
            gender: document.getElementById('gender').value,
            singleParent: document.getElementById('singleParent').checked,
            phone: document.getElementById('phone').value,
            tel: document.getElementById('telephone').value,
            loedu: document.getElementById('levelOfEducation').value,
            profession: document.getElementById('profession').value,
            married: document.getElementById('marriage').value,
            street_name: document.getElementById('street').value,
            street_number: document.getElementById('streetNumber').value,
            notify:  document.getElementById('notifications').checked,
            active_participant: document.getElementById('participation').checked,
            reg_notes:  document.getElementById('notes').value,
            skills: document.getElementById('skills').value,
            confirmation: document.getElementById('confirmation').checked,
            rucniUnos: document.getElementById("rucniUnos").checked
        };

        if (document.getElementById("rucniUnos").checked)
        {
            rod_1["residence_place"] = document.getElementById('placeOfResidence').value;
            rod_1["country"] = document.getElementById('country').value;
            rod_1["zip"] = document.getElementById('zipCode').value;

            if(rod_1.hasOwnProperty("residence_id"))
            {
                delete rod_1.residence_id;
            }
        }
        else
        {
            rod_1["residence_id"] = document.getElementById("placeFromBase").value;
        }

        post_parameters["rod1"] = rod_1;
        post_parameters["rod2"] = {};

        if (!rod_1.singleParent){
            var rod_2 = {
                name:  document.getElementById('name2').value,
                lname:  document.getElementById('surname2').value,
                oib: document.getElementById('OIB2').value,
                email: document.getElementById('email2').value,
                passwd: document.getElementById('password2').value,
                username: document.getElementById('userName2').value,
                dob: document.getElementById('dateOfBirth2').value,
                gender: document.getElementById('gender2').value,
                phone: document.getElementById('phone2').value,
                tel: document.getElementById('telephone2').value,
                loedu: document.getElementById('levelOfEducation2').value,
                profession: document.getElementById('profession2').value,
                married: document.getElementById('marriage2').value,
                street_name: document.getElementById('street2').value,
                street_number: document.getElementById('streetNumber2').value,
                residence_place: document.getElementById('placeOfResidence2').value,
                country: document.getElementById('country2').value,
                zip: document.getElementById('zipCode2').value,
                notify:  document.getElementById('notifications2').checked,
                active_participant: document.getElementById('participation2').checked,
                reg_notes:  document.getElementById('notes2').value,
                skills: document.getElementById('skills2').value,
                confirmation: document.getElementById('confirmation2').checked,
                same_address: document.getElementById('sameAddress').checked,
                rucniUnos: document.getElementById("rucniUnos2").checked
            };
            
            if (!document.getElementById('sameAddress').checked)
            {
                if (document.getElementById("rucniUnos2").checked)
                {
                    rod_2["residence_place"] = document.getElementById('placeOfResidence2').value;
                    rod_2["country"] = document.getElementById('country2').value;
                    rod_2["zip"] = document.getElementById('zipCode2').value;
                }
                else
                {
                    rod_2["residence_id"] = document.getElementById("placeFromBase2").value;
                }
                
                rod_2["street_name"] = document.getElementById('street2').value;
                rod_2["street_number"] = document.getElementById('streetNumber2').value;
            }
            else
            {
                rod_2["street_name"] = rod_1["street_name"]
                rod_2["street_number"] = rod_1["street_number"]

                if(rod_1.hasOwnProperty("residence_id"))
                {
                    rod_2["residence_id"] = rod_1["residence_id"]
                }

                else
                {
                    rod_2["residence_place"] = rod_1["residence_place"];
                    rod_2["country"] = rod_1["country"];
                    rod_2["zip"] = rod_1["zip"];
                }
            }
            
            post_parameters["rod2"] = rod_2;
        }

        post_parameters["djeca"] = objDjeca;

        fetch('/registracija', {
            method: 'post', // or 'PUT'
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $('input[name="_token"]').val()
            },
            body:  JSON.stringify(post_parameters),
        })
        .then(response => response.text())
        .then(data => {
        console.log('Success:', data);
        })
        .catch((error) => {
        console.error('Error:', error);
        });
    }

});
