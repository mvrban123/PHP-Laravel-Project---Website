@extends('layouts.registration')

@section('content')

<div class="Header">
<div class="Logo">
    <img src="{{asset('assets/images/logo.png')}}"></img>
    </div>
    <p>Postanite dio naše obitelji</p>
</div>

<section class="formHolder">

<div class="signup form-piece switched">
    <div class="ProgressBar">
                <div class="step">
                    <p>Podaci korisničkog računa</p>
                    <div class="bullet" id="b1">
                        <span>1</span>
                    </div>
                    
                </div>

                <div class="step">
                        <p>Osobni podaci</p>
                    <div class="bullet" id="b2">
                        <span>2</span>
                    </div>
                    
                </div>
                <div class="step">
                        <p>Ostali osobni podaci</p>
                    <div class="bullet" id="b3">
                                <span>3</span>
                    </div>
                    
                </div>
                <div class="step">
                        <p>Podaci o adresi stanovanja</p>
                    <div class="bullet" id="b4">
                                <span>4</span>
                    </div>
                   
                </div>
                <div class="step">
                        <p>Unos djece</p>
                    <div class="bullet" id="b5">
                                <span>5</span>
                    </div>
                    
                </div>
                <div class="step">
                        <p>Potvrde</p>
                    <div class="bullet" id="b6">
                                <span>6</span>
                    </div>
                    
                </div>
    </div>
    
                <form class="signup-form" action="{{ route('registration') }}" method="post">
                    <!--token koji zahtjeva laravel -->
                    @csrf
                
                    <fieldset id="KorisnickiPodaci">
                        <p>Korisnički podaci</p>
    
                        <div class="form-group">
                            <label for="userName">Korisničko ime</label>
                            <input type="text" name="userName" id="userName" class="userName">
                            <i class="fas fa-check-circle"></i>
			                <i class="fas fa-exclamation-circle fa"></i>
                            <small>Moje poruke</small>
                            <br>
                            <br>
                        </div>
    
                        <div class="form-group">
                            <label for="password">Lozinka</label>
                            <input type="password" name="password" id="password" class="pass">
                            <i class="fas fa-check-circle"></i>
			                <i class="fas fa-exclamation-circle"></i>
                            <small>Moje poruke</small>
                            <br>
                            <br>
                        </div>
    
                        <div class="form-group">
                            <label for="passwordCon">Potvrdite lozinku</label>
                            <input type="password" name="passwordCon" id="passwordCon" class="passConfirm">
                            <i class="fas fa-check-circle"></i>
			                <i class="fas fa-exclamation-circle"></i>
                            <small>Moje poruke</small>
                            <br>
                            <br>
                        </div>
    
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" name="emailAdress" id="email" class="email">
                            <i class="fas fa-check-circle"></i>
			                <i class="fas fa-exclamation-circle"></i>
                            <small>Moje poruke</small>
                            <br>
                            <br>
                        </div>
                        
                    </fieldset>
                    
                <fieldset id="OsobniPodaci">
                    <p>Osobni podaci</p>

                    
                    <div class="form-group">

                        <label for="name">Ime</label>
                        <input type="text" name="name" id="name" class="name">
                        <i class="fas fa-check-circle"></i>
			            <i class="fas fa-exclamation-circle"></i>
                        <small>Moje poruke</small>
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="surname">Prezime</label>
                        <input type="text" name="surname" id="surname" class="">
                        <i class="fas fa-check-circle"></i>
			            <i class="fas fa-exclamation-circle"></i>
                        <small>Moje poruke</small>
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="OIB">OIB</label>
                        <input type="text" name="OIB" id="OIB" class="OIB">
                        <i class="fas fa-check-circle"></i>
			            <i class="fas fa-exclamation-circle"></i>
                        <small>Moje poruke</small>
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="dateOfBirth">Datum rođenja</label>
                        <input type="date" name="dateOfBirth" id="dateOfBirth" class="dateOfBirth">
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="gender">Spol</label>
                        <select id="gender" name="gender">
                        <option value="f">Žensko</option>
                        <option value="m">Muško</option>
                        </select>
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                    <label for="singleParent">Samohrani roditelj</label>
                     <input type="checkbox" name="singleParent" id="singleParent" class="singleParent">
                     <br>
                     <br>
                    </div>

                </fieldset>

                <fieldset id="OstaliOsobniPodaci">
                <p>Ostali osobni podaci</p>
                <div class="form-group">
                        <label for="phone">Mobitel</label>
                        <input type="tel" name="phone" id="phone">
                        <i class="fas fa-check-circle"></i>
			            <i class="fas fa-exclamation-circle"></i>
                        <small>Moje poruke</small>
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="telephone">Telefon</label>
                        <input type="tel" name="telephone" id="telephone">
                        <i class="fas fa-check-circle"></i>
			            <i class="fas fa-exclamation-circle"></i>
                        <small>Moje poruke</small>
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="levelOfEducation">Razina obrazovanja</label>
                        <select id="levelOfEducation" name="levelOfEducation">
                        <option value="1">Osnovna škola</option>
                        <option value="2">Srednja škola</option>
                        <option value="3">Viša stručna sprema / Bakalaureat (BA)</option>
                        <option value="4">Visoka stručna sprema / Magistar struke (MA)</option>
                        <option value="5">Poslijediplomski specijalistički studij</option>
                        <option value="6">Magisterij znanosti (mr. sc.)</option>
                        <option value="7">Doktorat znanosti (dr. sc.)</option>
                        </select>
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="profession">Zanimanje</label>
                        <input type="text" name="profession" id="profession" class="profession">
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="marriage">Bračni status</label>
                        <select id="marriage" name="marriage">
                        <option value="1">Oženjen/Udana</option>
                        <option value="0">Neoženjen/Neudana</option>
                        </select>
                        <br>
                        <br>
                    </div>
                </fieldset>

               

                <fieldset id="PodaciOAdresi">
                    <p>Podaci o adresi</p>

                    <div class="form-group">
                    <label for="rucniUnos">Ručni unos</label>
                    <input type="checkbox" name="rucniUnos" id="rucniUnos" class="rucniUnos">
                    <br>
                    <br>
                    </div>

                    <div class="AdreseRucno" id="AdreseRucno">
                        <div class="form-group">
                            <label for="country">Država</label>
                            <input type="text" name="country" id="country" class="country">
                            <br>
                            <br>
                        </div>

                        <div class="form-group">
                            <label for="placeOfResidence">Mjesto prebivališta</label>
                            <input type="text" name="placeOfResidence" id="placeOfResidence" class="placeOfResidence">
                            <br>
                            <br>
                        </div>
                    </div>

                <div class="AdreseBaza" id="AdreseBaza">
                    <div class="form-group">
                    <label for="countryFromBase">Država</label>
                    <select class="selectpicker" name="countryFromBase" id="countryFromBase" data-live-search="true" data-width="97%" data-size="5"
                    style="background-color: white; padding: 10px 0;
                            padding-left: 25px;
                            margin-bottom: 10px;
                            width: 97%; ">
                        @foreach($drzave as $drzava)                    
                            <option value="{{ $drzava['id'] }}" >{{ $drzava['naziv'] }}</option>                    
                        @endforeach
                    </select>
                    <br>
                    <br>
                    </div>

                    <div class="form-group">
                    <label for="placeFromBase">Mjesto</label>
                    <select class="selectpicker" name="placeFromBase" id="placeFromBase" data-live-search="true" data-width="97%" data-size="6" 
                    style="background-color: white; padding: 10px 0;
                            padding-left: 25px;
                            margin-bottom: 10px;
                            width: 97%; ">
                        @foreach($mjesta as $mjesto)                    
                            <option value="{{ $mjesto['id'] }}" >{{ $mjesto['naziv'] }}</option>                    
                        @endforeach
                    </select>
                    <br>
                    <br>
                    </div>
                </div>
                    

                    <div class="form-group">
                        <label for="street">Ulica</label>
                        <input type="text" name="street" id="street" class="street">
                        <i class="fas fa-check-circle"></i>
			            <i class="fas fa-exclamation-circle"></i>
                        <small>Moje poruke</small>
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="streetNumber">Ulični broj</label>
                        <input type="text" name="streetNumber" id="streetNumber" class="streetNumber">
                        <i class="fas fa-check-circle"></i>
			            <i class="fas fa-exclamation-circle"></i>
                        <small>Moje poruke</small>
                        <br>
                        <br>
                    </div>



                    <div class="form-group">
                        <label for="zipCode">Poštanski broj</label>
                        <input type="number" name="zipCode" id="zipCode" class="zipCode">
                        <i class="fas fa-check-circle"></i>
			            <i class="fas fa-exclamation-circle"></i>
                        <small>Moje poruke</small>
                        <br>
                        <br>
                    </div>

                </fieldset>

                <fieldset id="UnosDjece" >
                        <p>Unos djece</p>
                        <div class="containerChildren">
                        <table id="tablica">
                                <tr>
                                    <th>Ime</th>
                                    <th>Prezime</th>
                                    <th>Datum rođenja</th>
                                    <th>OIB</th>
                                    <th>Brisi</th>
                                </tr>
                        </table>
                        <div class="inputiDjece">
                            <div class="form-group">
                                <label for="nameChild">Ime djeteta</label>
                                <input type="text" name="nameChild" id="nameChild" class="nameChild">
                                <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                            </div>
                        
                            <div class="form-group">
                                <label for="lastNameChild">Prezime djeteta</label>
                                <input type="text" name="lastNameChild" id="lastNameChild" class="lastNameChild">
                                <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="BirthChild">Datum rođenja djeteta</label>
                                <input type="date" name="BirthChild" id="BirthChild" class="BirthChild">
                                <br>
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="OIBChild">OIB djeteta</label>
                                <input type="number" name="OIBChild" id="OIBChild" class="OIBChild">
                                <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                            </div>
                            <div class="Buttons">
                            <button type="button" class="addChildBtn" id="dodaj">Spremi</button>
                             </div>
                        </div>
                        </div>
                    </fieldset>
                   
               
                

                <fieldset id="Potvrde" >
                    <p>Potvrde</p>

                    <div class="form-group">
                        <label for="notifications">Želim primati obavijesti</label>
                        <input type="checkbox" name="notifications" id="notifications" class="notifications">
                        <br>
                            <br>
                    </div>

                    <div class="form-group">
                        <label for="participation">Želim aktivno sudjelovati u aktivnositma Udruge</label>
                        <input type="checkbox" name="participation" id="participation" class="participation">
                        <br>
                            <br>
                    </div>

                    
                    <div class="form-group">
                        <label for="notes">Navedite svoja znanja za koje mislite da bi mogla pomoći udruzi</label>
                        <input type="textarea" name="notes" id="notes" class="notes">
                        <br>
                            <br>
                    </div>

                    <div class="form-group">
                        <label for="skills">Napomene uz registracije</label>
                        <input type="textarea" name="skills" id="skills" class="skills">
                        <br>
                            <br>
                    </div>

                    <div class="form-group">
                        <label for="confirmation">Potvrđujem istinitost podataka, slažem
                        se sa svrhom  njihova <br>korištenja te pristajem postati član Udruge</label>
                        <input type="checkbox" name="confirmation" id="confirmation" class="confirmation">
                        <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                    </div>

                    
                </fieldset>

                <fieldset id="KorisnickiPodaci2">
                        <p>Korisnički podaci</p>
    
                        <div class="form-group">
                            <label for="userName2">Korisničko ime</label>
                            <input type="text" name="userName2" id="userName2" class="userName2">
                            <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                        </div>
    
                        <div class="form-group">
                            <label for="password2">Lozinka</label>
                            <input type="password" name="password2" id="password2" class="pass2">
                            <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                        </div>
    
                        <div class="form-group">
                            <label for="passwordCon2">Potvrdite lozinku</label>
                            <input type="password" name="passwordCon2" id="passwordCon2" class="passConfirm2">
                            <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                        </div>
    
                        <div class="form-group">
                            <label for="email2">E-mail</label>
                            <input type="email" name="emailAdress2" id="email2" class="email2">
                            <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                        </div>
                        
                    </fieldset>

                <fieldset id="OsobniPodaci2">
                    <p>Osobni podaci</p>

                    
                    <div class="form-group">

                        <label for="name2">Ime</label>
                        <input type="text" name="name2" id="name2" class="name2">
                        <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                    </div>

                    <div class="form-group">
                        <label for="surname2">Prezime</label>
                        <input type="text" name="surname2" id="surname2" class="surname2">
                        <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                    </div>

                    <div class="form-group">
                        <label for="OIB2">OIB</label>
                        <input type="text" name="OIB2" id="OIB2" class="OIB2">
                        <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                    </div>

                    <div class="form-group">
                        <label for="dateOfBirth2">Datum rođenja</label>
                        <input type="date" name="dateOfBirth2" id="dateOfBirth2" class="dateOfBirth2">
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="gender2">Spol</label>
                        <select id="gender2" name="gender2">
                        <option value="f">Žensko</option>
                        <option value="m">Muško</option>
                        </select>
                        <br>
                        <br>
                    </div>

                </fieldset>

                <fieldset id="OstaliOsobniPodaci2">
                <p>Ostali osobni podaci</p>
                <div class="form-group">
                        <label for="phone2">Mobitel</label>
                        <input type="tel" name="phone2" id="phone2">
                        <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                    </div>

                    <div class="form-group">
                        <label for="telephone2">Telefon</label>
                        <input type="tel" name="telephone2" id="telephone2">
                        <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                    </div>

                    <div class="form-group">
                        <label for="levelOfEducation2">Razina obrazovanja</label>
                        <select id="levelOfEducation2" name="levelOfEducation2">
                        <option value="1">Osnovna škola</option>
                        <option value="2">Srednja škola</option>
                        <option value="3">Viša stručna sprema / Bakalaureat (BA)</option>
                        <option value="4">Visoka stručna sprema / Magistar struke (MA)</option>
                        <option value="5">Poslijediplomski specijalistički studij</option>
                        <option value="6">Magisterij znanosti (mr. sc.)</option>
                        <option value="7">Doktorat znanosti (dr. sc.)</option>
                        </select>
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="profession2">Zanimanje</label>
                        <input type="text" name="profession2" id="profession2" class="profession2">
                        <br>
                        <br>
                    </div>
                    
                    <div class="form-group">
                        <label for="marriage2">Bračni status</label>
                        <select id="marriage2" name="marriage2">
                        <option value="1">Oženjen/Udana</option>
                        <option value="0">Neoženjen/Neudana</option>
                        </select>
                        <br>
                        <br>
                    </div>

                    <!-- <div class="form-group">
                        <label for="sameAddress">Živim na istoj adresi kao i prethodni roditelj</label>
                        <input type="checkbox" name="sameAddress" id="sameAddress" class="sameAddress">
                      
                    </div> -->
                </fieldset>

               

                <fieldset id="PodaciOAdresi2">
                    <p>Podaci o adresi</p>
                    <div class="form-group">
                        <label for="sameAddress">Živim na istoj adresi kao i prethodni roditelj</label>
                        <input type="checkbox" name="sameAddress" id="sameAddress" class="sameAddress">
                        <br>
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="rucniUnos2">Ručni unos</label>
                        <input type="checkbox" name="rucniUnos2" id="rucniUnos2" class="rucniUnos2">
                        <br>
                        <br>
                    </div>

                    <div class="AdreseRucno2" id="AdreseRucno2">
                        <div class="form-group">
                            <label for="country2">Država</label>
                            <input type="text" name="country2" id="country2" class="country2">
                            <br>
                            <br>
                        </div>

                        <div class="form-group">
                            <label for="placeOfResidence2">Mjesto prebivališta</label>
                            <input type="text" name="placeOfResidence2" id="placeOfResidence2" class="placeOfResidence2">
                            <br>
                            <br>
                        </div>
                    </div>

                <div class="AdreseBaza2" id="AdreseBaza2">
                    <div class="form-group">
                    <label for="countryFromBase">Država</label>
                    <select class="selectpicker" name="countryFromBase2" id="countryFromBase2" data-live-search="true" data-width="97%" data-size="5"
                    style="background-color: white; padding: 10px 0;
                            padding-left: 25px;
                            margin-bottom: 10px;
                            width: 97%; ">
                        @foreach($drzave as $drzava)                    
                            <option value="{{ $drzava['id'] }}" >{{ $drzava['naziv'] }}</option>                    
                        @endforeach
                    </select>
                    <br>
                     <br>
                    </div>
                

                    <div class="form-group">
                    <label for="placeFromBase2">Mjesto</label>
                    <select class="selectpicker" name="placeFromBase2" id="placeFromBase2" data-live-search="true" data-width="97%" data-size="6" 
                    style="background-color: white; padding: 10px 0;
                            padding-left: 25px;
                            margin-bottom: 10px;
                            width: 97%; ">
                        @foreach($mjesta as $mjesto)                    
                            <option value="{{ $mjesto['id'] }}" >{{ $mjesto['naziv'] }}</option>                    
                        @endforeach
                    </select>
                    <br>
                    <br>
                    </div>
                </div>

                    <div class="form-group">
                        <label for="street2">Ulica</label>
                        <input type="text" name="street2" id="street2" class="street2">
                        <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                    </div>

                    <div class="form-group">
                        <label for="streetNumber2">Ulični broj</label>
                        <input type="text" name="streetNumber2" id="streetNumber2" class="streetNumber2">
                        <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                       
                    </div>

                    <div class="form-group">
                        <label for="zipCode2">Poštanski broj</label>
                        <input type="number" name="zipCode2" id="zipCode2" class="zipCode2">
                        <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                    </div>
                </fieldset>

                <fieldset id="Potvrde2" >
                    <p>Potvrde</p>

                    <div class="form-group">
                        <label for="notifications2">Želim primati obavijesti</label>
                        <input type="checkbox" name="notifications2" id="notifications2" class="notifications2">
                        <br>
                            <br>
                    </div>

                    <div class="form-group">
                        <label for="participation2">Želim aktivno sudjelovati u aktivnositma Udruge</label>
                        <input type="checkbox" name="participation2" id="participation2" class="participation2">
                        <br>
                            <br>
                    </div>

                    
                    <div class="form-group">
                        <label for="notes2">Navedite svoja znanja za koje mislite da bi mogla pomoći udruzi</label>
                        <input type="textarea" name="notes2" id="notes2" class="notes2">
                        <br>
                            <br>
                    </div>

                    <div class="form-group">
                        <label for="skills2">Napomene uz registracije</label>
                        <input type="textarea" name="skills2" id="skills2" class="skills2">
                        <br>
                            <br>
                    </div>

                    <div class="form-group">
                        <label for="confirmation2">Potvrđujem istinitost podataka, slažem
                        se sa svrhom njihova <br> korištenja te pristajem postati član Udruge</label>
                        <input type="checkbox" name="confirmation2" id="confirmation2" class="confirmation2">
                        <i class="fas fa-check-circle"></i>
			                    <i class="fas fa-exclamation-circle"></i>
                                <small>Moje poruke</small>
                                <br>
                                <br>
                    </div>

                    
                </fieldset>
                
                <div class="CTA" id="CTA">
                        <input type="button" value="Registracija" id="submit" >
                </div>

                </form>

                

                <div class="Buttons">
                        <button class="nextBtn" id="dalje">Dalje</button>
                        <button class="backBtn" id="natrag">Natrag</button>
                </div>
</section>
@endsection