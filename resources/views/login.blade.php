@extends('layouts.login')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('content')

<section id="formHolder">

    <div class="row">

        <!-- Brand Box -->
        <div class="col-sm-6 brand">
            <div class="success-msg">
                <p>Odlično! Postali ste naš novi član.</p>
                <a href="#" class="profile">Vaš profil</a>
            </div>
        </div>


        <!-- Form Box -->
        <div class="col-sm-6 form">

            <!-- Login Form -->
            <div class="login form-piece">
                <form class="login-form" action="{{ route('authenticate') }}" method="post">

                    <!--token koji zahtjeva laravel -->
                    @csrf

                    <div class="form-group">
                        <label for="oib_web">OIB</label>
                        <input type="text" name="loginoib" id="oib_web" required>
                    </div>

                    <div class="form-group">
                        <label for="loginemail">E-mail</label>
                        <input type="email" name="loginemail" id="loginemail" required>
                    </div>

                    <div class="form-group">
                        <label for="loginPassword">Lozinka</label>
                        <input type="password" name="loginPassword" id="loginPassword" required>
                    </div>

                    <div class="CTA">
                        <input type="submit" value="Prijava">
                        <a id="reg" href="registracija">Nemate račun? Napravite ga</a>
                        <a id="pwd_res" data-toggle="modal" data-target="#exampleModalCenter">Zatraži promjenu lozinke</a>
                    </div>
                </form>
            </div>
            <!-- End Login Form -->



            <!-- Signup Form -->
            <div class="signup form-piece switched">
                <form class="signup-form" action="#" method="post">

                    <div class="form-group">
                        <label for="name">Ime i prezime</label>
                        <input type="text" name="username" id="name" class="name">
                        <span class="error"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="emailAdress" id="email" class="email">
                        <span class="error"></span>
                    </div>

                    <div class="form-group">
                        <label for="phone">Broj</label>
                        <input type="text" name="phone" id="phone">
                    </div>

                    <div class="form-group">
                        <label for="password">Lozinka</label>
                        <input type="password" name="password" id="password" class="pass">
                        <span class="error"></span>
                    </div>

                    <div class="form-group">
                        <label for="passwordCon">Potvrdite lozinku</label>
                        <input type="password" name="passwordCon" id="passwordCon" class="passConfirm">
                        <span class="error"></span>
                    </div>

                    <div class="CTA">
                        <input type="submit" value="Registracija" id="submit">
                        <a href="#" class="switch">Imate račun? Prijavite se</a>
                    </div>
                </form>
            </div><!-- End Signup Form -->
        </div>
    </div>

    <!-- Reset/Change password Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Promjena lozinke</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pwd_res_email">E-mail</label>
                        <input type="text" name="pwd_res_email" id="pwd_res_email" required>
                    </div>

                    <div class="form-group">
                        <label for="pwd_res_oib">OIB</label>
                        <input type="email" name="pwd_res_oib" id="pwd_res_oib" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                    <button id="rst-submit" type="button" class="btn btn-primary">Zatraži promjenu lozinke</button>
                </div>

                <div id="reset-ok" class="card text-white bg-success mb-3" style="max-width: 100%; margin: 15px 15px; padding: 5px 5px; display:none;">
                    <!-- <div class="card-header">Header</div> -->
                    <div class="card-body">
                        <!-- <h5 class="card-title">Success card title</h5> -->
                        <p class="card-text">
                            Na Vašu je E-mail adresu poslana poveznica koju možete iskoristiti kako biste promijenili svoju lozinku. 
                        </p>
                    </div>
                </div>

                <div id="reset-err" class="card text-white bg-danger mb-3" style="max-width: 100%; margin: 15px 15px; padding: 5px 5px; display:none;">
                    <!-- <div class="card-header">Header</div> -->
                    <div class="card-body">
                        <!-- <h5 class="card-title">Success card title</h5> -->
                        <p class="card-text">
                            Ispričavamo se, dogodila se pogreška! Molimo Vas, pokušajte ponovno kasnije.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection