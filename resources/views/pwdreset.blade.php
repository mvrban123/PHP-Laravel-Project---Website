@extends('layouts.login')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="{{ asset('assets/css/pwdreset.css') }}">
@section('content')



<h1>
    Promjena lozinke
</h1>

<section id="formHolder">
    @if ($error)
        <div id="reset-pre-err" class="card text-white bg-danger mb-3" style="max-width: 100%; margin: 15px 15px; padding: 5px 5px; display:block;">
            <!-- <div class="card-header">Header</div> -->
            <div class="card-body">
                <!-- <h5 class="card-title">Success card title</h5> -->
                <p class="card-text">
                    Ispričavamo se, dogodila se pogreška! 
                    Molimo Vas, pokušajte ponovno kasnije ili zatražite novi zahtjev za promjenu lozinke.
                </p>
            </div>
        </div>
    @else
        <h2>Unesite podatke: </h2>
        <form class="login-form" method="post">

            <!--token koji zahtjeva laravel -->
            @csrf

            <div class="form-group">
                <label for="resEmail">E-mail:</label>
                <input type="email" name="resEmail" id="resEmail" required>
            </div>

            <div class="form-group">
                <label for="resOib">OIB:</label>
                <input type="text" name="resOib" id="resOib" required>
            </div>

            <div class="form-group">
                <label for="resPassword">Nova lozinka:</label>
                <input type="password" name="resPassword" id="resPassword" required>
            </div>

            <div class="CTA">
                <input id="submit-new-pwd" value="Promijeni lozinku">
            </div>

            <div id="reset-ok" class="card text-white bg-success mb-3" style="max-width: 100%; margin: 15px 15px; padding: 5px 5px; display:none;">
                <!-- <div class="card-header">Header</div> -->
                <div class="card-body">
                    <!-- <h5 class="card-title">Success card title</h5> -->
                    <p class="card-text">
                        Vaša je lozinka uspješno ažurirana!
                    </p>
                </div>
            </div>

            <div id="reset-err" class="card text-white bg-danger mb-3" style="max-width: 100%; margin: 15px 15px; padding: 5px 5px; display:none;">
                <!-- <div class="card-header">Header</div> -->
                <div class="card-body">
                    <!-- <h5 class="card-title">Success card title</h5> -->
                    <p class="card-text">
                        Ispričavamo se, dogodila se pogreška! Molimo Vas, pokušajte ponovno kasnije ili
                        provjerite jeste li unijeli točne podatke i pokušajte ponovno.
                    </p>
                </div>
            </div>
        </form>
    @endif

</section>


<script src="{{ asset('assets/js/pwdreset.js') }}"></script>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
@endsection