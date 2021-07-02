<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route za login 
*/
Route::get('login', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@login')->name('authenticate');



/*
Route za signout 
*/
Route::post('signout', 'SignOutController@signout')->name('signout');




/*
Route za reset lozinke
*/
Route::post('reset-pwd/request', 'ResetPasswordContoller@request_reset_pwd')->name('request_reset_pwd');
Route::post('reset-pwd/reset/set-new', 'ResetPasswordContoller@set_new_pwd')->name('set_pwd_new');
Route::get('reset-pwd/reset/{url}', 'ResetPasswordContoller@reset_pwd')->name('reset_pwd');




/*
Route za registraciju 
*/
Route::get('registracija', 'RegistrationController@index')->name('registracija');
Route::post('/registracija', 'RegistrationController@registration')->name('registration');




/*
Route za učitavanje dashboarda
Resource se koristi za generiranje izbornika
*/
Route::group(['middleware' => ['web', 'custom_auth']], function () 
{
    Route::get('admin/dashboard', 'DashboardController@index')->name('dashboard');
	Route::resource('admin/obitelji', 'ObiteljController');
	Route::resource('admin/admini', 'AdminController');
});

/*
Route za preglede obitelji
*/
Route::get('detaljniPrikazObitelji/{user}/{user2?}/{detailedUser?}/{getEmails?}', 'ObiteljController@detaljniPrikazObitelji')->name('detaljniPrikazObitelji');
Route::get('deleteAUser/{user}/{user2?}/{detailedUser1?}', 'ObiteljController@deleteAUser')->name('deleteAUser');
Route::post('/filtriraniObiteljskiPodaci', 'ObiteljController@filtriraniObiteljskiPodaci')->name('filtriraniObiteljskiPodaci');
Route::post('updateUser', 'DbControllers\KorisnikController@update')->name('updateUser');

/*
Route za slozeno pretrazivanje
*/
Route::post('/DohvatiViewPretrage', 'PretragaController@DohvatiViewPretrage')->name('DohvatiViewPretrage');
Route::post('/DodajElementPretrage', 'PretragaController@DodajElementPretrage')->name('DodajElementPretrage');
Route::post('/ObrisiFilterPretrage', 'PretragaController@ObrisiFilterPretrage')->name('ObrisiFilterPretrage');
Route::post('/ComboBoxSetValue', 'PretragaController@ComboBoxSetValue')->name('ComboBoxSetValue');
Route::post('/UkloniElementPretrage', 'PretragaController@UkloniElementPretrage')->name('UkloniElementPretrage');
Route::post('/PretraziObitelji', 'PretragaController@PretraziObitelji')->name('PretraziObitelji');
Route::post('/PromjeniTipVeze', 'PretragaController@PromjeniTipVeze')->name('PromjeniTipVeze');
Route::post('/PromjeniTipVezeElementa', 'PretragaController@PromjeniTipVezeElementa')->name('PromjeniTipVezeElementa');

/*
Route za prikaz komunikacije prema korisnicima
*/
Route::get('/popisKomunikacije', 'KomunikacijaController@UcitajKomunikacijuKorisnika')->name('popisKomunikacije');

Route::post('/popisKomunikacije', 'KomunikacijaController@UcitajKomunikacijuKorisnika')->name('popisKomunikacije');

/*
Route za upravljanje html predlošcima
*/
Route::get('/predlosci/kreiranje/{predlozakID?}', 'PredlosciController@prikaziKreiranjePredloska')->name('kreiranjePredloskaIndex');
Route::post('/predlosci/kreiranje', 'PredlosciController@kreirajPredlozak')->name('kreiranjePredloska');
Route::post('/predlosci/dodavanjePriloga', 'PredlosciController@DodajPrilogePostojecemPredlosku')->name('DodajPrilogePostojecemPredlosku');
Route::post('/predlosci/upload', 'PredlosciController@upload')->name('uploadPrilogaPredlosku');
Route::get('/predlosci/skidanje/{odabraniPredlozak}/{prilog}', 'PredlosciController@DowloadFile')->name('DowloadFile');

Route::get('/predlosci/svi', 'PredlosciController@prikaziSvePredloske')->name('sviPredlosciIndex');
Route::get('/predlosci/brisanje/{odabraniPredlozak}', 'PredlosciController@brisiPredlozak')->name('brisanjePredloska');
Route::get('/predlosci/brisanje/{odabraniPredlozak}/{prilogZaBrisanje}', 'PredlosciController@brisiPrilog')->name('brisiPrilog');

Route::get('/predlosci/pregled/{odabraniPredlozak}', 'PredlosciController@prikaziPregledPredloska')->name('pregledPredloskaIndex');


/*
Route za upravljanje postavkama slanja aut.porukama
*/
Route::get('/email/postavke', 'SettingsController@index')->name('emailPostavke');
Route::post('/email/postavke/update', 'SettingsController@updatePredlosci')->name('updatePredlosci');
Route::get('/email/pregled/{id}', 'SettingsController@autoEmails')->name('autoEmails');
Route::post('/email/pregled/{id}', 'SettingsController@filterAutoEmails')->name('filterAutoEmails');
Route::post('/email/prikaz', 'SettingsController@prikazTijelaPoruke')->name('prikazTijelaPoruke');


Route::post('/email/slanje', 'EmailSlanjeController@index')->name('emailSlanje');
Route::post('/email/predlozak', 'EmailSlanjeController@DohvatiPredlozak')->name('emailPredlozak');
