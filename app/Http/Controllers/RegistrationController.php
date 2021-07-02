<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DbControllers\DrzavaController;
use App\Http\Controllers\DbControllers\MjestoController;
use Illuminate\Http\Request;
use App\Modules\Registration\FamilyRegistration;


class RegistrationController extends Controller
{
    public function index(){
        $mjesta = MjestoController::readAll();
        $drzave = DrzavaController::readAll();
        return view('registracija', compact('drzave','mjesta'));
    }
    
    public function registration(Request $request)
    {
        $familyRegistrator = new FamilyRegistration();
        $registerFamilyResult = $familyRegistrator->registerFamily($request);
        // var_dump($registerFamilyResult);

        /*
            TODO:
                Implementirati logiku vraćanja ispravnog pogleda
                ako je registracija uspješna, odnosno ako nije.

                + automatsko slanje email poruke registriranim korisnicima
                roditeljima.
        */

        return view('login');
    }
}