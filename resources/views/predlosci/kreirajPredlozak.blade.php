@extends('layouts.admin')

<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/predlosci_js/kreiranjePredloska.js') }}"></script>

@section('css')
<link href="{{ asset('assets/css/predlosci.css') }}" rel="stylesheet">
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

@if($predlozak['id'] > 0)
<h3 class="text-left mt-5" style="margin-left:3%;">Predložak br. {{$predlozak['id']}}</h3>
@else
<h3 class="text-left mt-5" style="margin-left:3%;">Kreiranje predloška</h3>
@endif




@if($predlozak == null)
<form class="signup-form" action="{{ route('kreiranjePredloska') }}" enctype="multipart/form-data"  method="post">
    <!--token koji zahtjeva laravel -->
    @csrf

        <div class ="container1">

            <div id="ID">
                <input type="text" name="idPredloska" id="idPredloska" class="idPredloska" value="" hidden>
            </div>
            
            <div id="Naziv">
                <label for="nazivPredloska">Naziv predloška</label> 
                <br>
                <input type="text" name="nazivPredloska" id="nazivPredloska" class="nazivPredloska">
            </div>

            <div id="Kategorija">
                <label for="odabirKategorije">Odaberite kategoriju:</label>
                
                <select class="selectpicker form-control" name="odabirKategorije" id="odabirKategorije">
                <!--<option value="0"> -- </option>-->
                @foreach ($sveKategorije as $kategorija)
                    <option value="{{$kategorija->id}}"> {{$kategorija->naziv}} </option>
                @endforeach
                </select>
            </div>


            <div id="Unos" class="mb-3">
                <label for="unosPredloska">Predložak:</label> 
                <br>
                <textarea name="unosPredloska" id="unosPredloska" class="unosPredloska"> </textarea>
            </div>
            

            <div id="Pregled" class="mb-3">
                <label for="pregledPredloska">Konačni izgled:</label>
                <div  id="pregledPredloska">
                </div>
            </div>    
           
            <div class="input-group mb-4" >
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile04" name="filenames[]" style="display:none;" multiple>
                    <label class="custom-file-label" for="inputGroupFile04">Odaberite datoteke</label>
                </div>
            </div>
            <!--
                <div class="input-group hdtuto control-group lst increment" >
                <h6 class="well mr-2">Odaberite datoteke za prijenos:</h6>

                <input type="file" name="filenames[]" class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold" multiple>
                    
            </div>-->

            <div id = "Gumb1" name = "Gumb1"> 
                <input type="button" value="Pregledaj izgled predloška" name="previewPredloska" id="previewPredloska" class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold" >
            </div>
            
            <div id = "Gumb2" name = "Gumb2" >
                <input type="submit" value="Kreiraj predložak" name="kreiranjePredloska" id="kreiranjePredloska" class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold float-md-right" >
             </div>

        </div>
</form>

@else

<form class="signup-form" action="{{ route('kreiranjePredloska') }}" enctype="multipart/form-data"  method="post">
    <!--token koji zahtjeva laravel -->
    @csrf
        <div class ="container1">

            <div id="ID" hidden>
                <input type="text" name="idPredloska" id="idPredloska" class="idPredloska" value="{{$predlozak['id']}}">
            </div>
            
            <div id="Naziv">
                <label for="nazivPredloska">Naziv predloška</label> 
                <br>
                <input type="text" name="nazivPredloska" id="nazivPredloska" class="nazivPredloska" value="{{$predlozak['naslov']}}">
            </div>

            <div id="Kategorija">
                <label for="odabirKategorije">Odaberite kategoriju:</label>
                
                <select class="selectpicker form-control" name="odabirKategorije" id="odabirKategorije">
                <!--<option value="0"> -- </option>-->
                @foreach ($sveKategorije as $kategorija)
                    @if($kategorija['id'] == $predlozak['kategorija_prelozaka_id'])
                        <option value="{{$kategorija->id}}" selected> {{$kategorija->naziv}} </option>
                    @else
                        <option value="{{$kategorija->id}}"> {{$kategorija->naziv}} </option>
                    @endif
                @endforeach
                </select>
            </div>

            <div id="Unos" class="mb-3">
                <label for="unosPredloska">Predložak:</label> 
                <br>
                <textarea name="unosPredloska" id="unosPredloska" class="unosPredloska">{{ html_entity_decode($predlozak['definicija']) }}</textarea>
            </div>
            

            <div id="Pregled" class="mb-3">
                <label for="pregledPredloska">Konačni izgled:</label>
                <div  id="pregledPredloska">
                </div>
            </div>    
           
            <div id = "Gumb1" name = "Gumb1"> 
                <input type="button" value="Pregledaj izgled predloška" name="previewPredloska" id="previewPredloska" class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold" >
            </div> 
            
            <div id = "Gumb2" name = "Gumb2">
                <input type="submit" value="Ažuriraj predložak" name="kreiranjePredloska" id="kreiranjePredloska" class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold float-md-right" >
            </div>

            <div id = "Gumb3" name = "Gumb3" class="mb-5">
                <a class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold float-md-right" href="{{ route('kreiranjePredloskaIndex', $predlozak['id']) }}" id="ponistilink">
                <span>Poništi promjene</span></a>
            </div>
        </div>
</form>
@endif

<div class="float-lg-left" style="width:90%;margin-left:3%;margin-right:7%;">

@if ($prilog != NULL)
<div id="div2" >
    <table class="table table-bordered" id="tablica" cellspacing="0">
        <thead id="priloziTablica" style="background-color: #f15a54; color:#fff; "> 
            <h2 class=" mt-5">Prilozi uz predložak</h2>
            <tr>
                <th class="text-center">Naziv priloga</th>
                <th class="text-center">Link za preuzimanje</th>
                <th class="text-center">Brisanje</th>
            </tr>
        </thead>
        @foreach($prilog as $prilo)
            <tr>
                <td class="text-center" hidden>{{$prilo['id']}}</td>
                <td class="text-center">{{$prilo['naslov']}}</td>
                <td class="text-center">
                    <a href="{{ route ('DowloadFile', [$predlozak['id'],$prilo['id']]) }}" class="btn btn-primary"> Download </a>

                    <!--<a class="action-icon mr-2 ml-2" href="{{ route('DowloadFile', [$predlozak['id'],$prilo['putanja']] )  }}">
                    <i class="far fa-trash-alt" ></i>
                    </a>-->
                </td>
                <td class="text-center">
                    <a id="brisanjePriloga" class="action-icon mr-2 ml-2" href="{{ route('brisiPrilog', [$predlozak['id'],$prilo['id']] )  }}">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>    
</div>
@endif

@if($predlozak != null)
    <div id="div1">
        <h5 class="well">Odaberite prilog predlošku</h5>

        <form method="post" action="{{ route('DodajPrilogePostojecemPredlosku') }}" enctype="multipart/form-data">
        {{csrf_field()}}
            <div id="ID" hidden>
                <input type="text" name="idPredloska" id="idPredloska" class="idPredloska" value="{{$predlozak['id']}}">
            </div>
            
            <div class="input-group" >
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile04" name="filenames[]" style="display:none;" multiple>
                    <label class="custom-file-label" for="inputGroupFile04">Odaberite datoteke</label>
                </div>
                
                <div class="input-group-append">
                    <button type="submit" class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold float-md-right" style="color:fff;">Učitaj datoteku</button>
                </div>
            </div>
        </form>
    </div>
@endif

</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".btn-success").click(function(){
            var lsthmtl = $(".clone").html();
            $(".increment").after(lsthmtl);
        });
        $("body").on("click",".btn-danger",function(){$(this).parents(".hdtuto control-group lst").remove();
        });

        $("#Gumb2").click(function(){
            toastr.info("Ažuriran predložak!");
        });
        $("#Gumb3").click(function(){
            toastr.info("Poništene promjene!");
        });
        $("#brisanjePriloga").click(function(){
            toastr.info("Obrisan prilog!");
        });
    });
    
</script>

@endsection