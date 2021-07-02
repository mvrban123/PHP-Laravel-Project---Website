@extends('layouts.admin')

@section('title', 'Detalji o obitelji')

@section('css')
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid col-lg-4 col-md-6 float-sm-left">
    <!-- Card -->
    <div class="card shadow mt-5 mb-4">
        <div class="card-header py-3">
            <p>Obitelj</p>
            <h5 class="m-0 font-weight-bold text-primary"> {{$data[0]['prezime']}}</h5>
        </div>
        <div class="card-body p-0">
            <div class="row resource-content-row mt-4 ml-3">
                <div class="col-md-3 resource-content-label mb-2">
                    Naziv
                </div>

                <div class="col-md-6 resource-content-data">
                    @if(count($data)<=1)
                        {{$data[0]['prezime']}}
                    @else
                        @if($data[0]['prezime']==$data[1]['prezime'])
                            {{$data[0]['prezime']}}
                        @else
                            {{$data[0]['prezime']}} - {{$data[1]['prezime']}}
                        @endif
                    @endif
                </div>
            </div>

            <div class="row resource-content-row ml-3">
                <div class="col-md-3 resource-content-label mb-2">
                    Članovi
                </div>

                <div class="col-md-6 resource-content-data">
                    {{$userCount}}   
                </div>
            </div>


            <!--<div class="row resource-content-row ml-3">
                <div class="col-md-3 resource-content-label mb-2">
                    Email
                </div>

                <div class="col-md-6 resource-content-data">
                    {{$data[0]['email']}} 
                </div>
            </div>-->

            <div class="row resource-content-row ml-3 pb-4">
                <!--<div class="col-md-3 resource-content-label mb-2">
                    Status
                </div>-->

                
            </div>

        </div>
    
    <!-- End Card -->

    <!-- Card Details -->
    <div id="resource-detail" class="app-content">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive bg-white shadow">
                    <div id="details" class="row resource-content-row  ml-0 w-100">
                        ČLANOVI
                    </div>
                    <table id="items" class="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    Ime
                                </th>
                                <th class="text-center">
                                    Prezime
                                </th>
                                <th class="text-center">
                                    Uloga
                                </th>
                                <th class="text-center">
                                   
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $dat)
                            @foreach($roles as $role)
                                @if($dat['uloge_uloga_id']==$role['id'])
                                    <tr>
                                        <td class="text-center">
                                            {{$dat['ime']}}
                                        </td>
                                        <td class="text-center">
                                            {{$dat['prezime']}}
                                        </td>

                                        <td class="text-center">
                                            {{$role['uloga_opis']}}
                                        </td>
                                        <td class="text-center">
                                            <a class="action-icon mr-2 ml-2" href="{{ route('detaljniPrikazObitelji', [ $prviRoditelj,$drugiRoditelj,$dat['id']])  }}">
                                                <i class="far fa-eye fa-fw"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row resource-content-row mb-3 w-100 d-flex justify-content-center">
                        <a class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold" href="{{ route('detaljniPrikazObitelji', [ $prviRoditelj,$drugiRoditelj,0,1])  }}">
                        Prikaz komunikacije
                                            
                        </a>
                    </div>        
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Card Details -->

<div class="modal fade custom-modal" id="single-resource-delete-modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Brisanje korisnika</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Jeste li sigurni da želite obrisati odabranog korisnika ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                <form action="" id="single-resource-delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Obriši</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!--Single User Details-->

@if($detailUser>0)
<div class="container-fluid col-lg-4 col-md-6 float-sm-left ">
<div class="card shadow mt-5 mb-4 form-group">
    <div class="card-header py-3 mb-4">
            <p>Podaci o</p>
            <h5 class="m-0 font-weight-bold text-primary">{{$detaljanPrikazClana[0]['prezime']}} {{$detaljanPrikazClana[0]['ime']}}</h5>
    </div>
    <form action="{{ route('updateUser') }}" method="post" class="ml-3 mr-3">
    {{ csrf_field() }}
        <table>
            <tbody> 
                <tr>
                    <td hidden><input type="text" id="prviRoditelj" name="prviRoditelj" value="{{$prviRoditelj}}"></td>
                </tr>
                <tr>
                    <td hidden><input type="text" id="drugiRoditelj" name="drugiRoditelj" value="{{$drugiRoditelj}}"></td>
                </tr>    
                <tr hidden>
                    <td>ID:</td>
                    <td><input type="text" id="userID" name="userID" value="{{$detaljanPrikazClana[0]['id']}}"></td>
                </tr>   
                <tr class="form-group">
                    <td>Ime:</td>
                    <td><input type="text" style="width:100%" class="form-control"  id="fname" name="fname" value="{{$detaljanPrikazClana[0]['ime']}}"></td>
                </tr>     
                <tr class="form-group">
                    <td>Prezime:</td>
                    <td><input type="text" class="form-control w-100" id="lname" name="lname" value="{{$detaljanPrikazClana[0]['prezime']}}"></td>
                </tr>            
                <tr class="form-group">
                    <td>OIB:</td>
                    <td><input type="text" class="form-control w-100" id="oib" name="oib" value="{{$detaljanPrikazClana[0]['oib']}}"></td>
                </tr>
                <tr class="form-group">
                    <td>Email:</td>
                    <td><input type="text" class="form-control w-100" id="email" name="email" value="{{$detaljanPrikazClana[0]['email']}}"></td>
                </tr>
                <tr class="form-group">
                    <td class="w-100">Datum rođenja:</td>
                    <td><input type="date" class="form-control w-100" id="birtdate" name="birtdate" value="{{$detaljanPrikazClana[0]['datum_rodenja']}}"></td>
                </tr>  
                <tr class="form-group">
                    <td>Broj mobitela:</td>
                    <td><input type="text" class="form-control w-100" id="mobilni_telefon" name="mobilni_telefon" value="{{$detaljanPrikazClana[0]['mobilni_telefon']}}"></td>
                </tr>
                <tr class="form-group">
                    <td>Broj telefona:</td>
                    <td><input type="text" class="form-control w-100" id="fiksni_telefon" name="fiksni_telefon" value="{{$detaljanPrikazClana[0]['fiksni_telefon']}}"></td>
                </tr>
                <tr class="form-group">
                    <td>Zanimanje:</td>
                    <td><input type="text" class="form-control w-100" id="zanimanje" name="zanimanje" value="{{$detaljanPrikazClana[0]['zanimanje']}}"></td>
                </tr>               
                <tr class="form-group">
                    <td>Korisničko ime:</td>
                    <td><input type="text" class="form-control w-100" id="korisnicko_ime" name="korisnicko_ime" value="{{$detaljanPrikazClana[0]['korisnicko_ime']}}"></td>
                </tr>              
                <!--<tr>
                    <td>Lozinka:</td>
                    <td><input type="text" id="lozinka" name="lozinka" value="{{$detaljanPrikazClana[0]['lozinka']}}"></td>
                </tr>-->              
                <tr class="form-group">
                    <td>Adresa:</td>
                    <td>
                        <select class="form-control" name="adresa" id="adresa">
                            @foreach($sveAdrese as $adresa)
                                @if($adresa['id']==$detaljanPrikazClana[0]['adrese_adresa_id'])
                                    <option value="{{$adresa['id']}}" selected>{{$adresa['ulica_broj']}}, {{$adresa['ulica_broj_dodatak']}}, {{$adresa['naziv']}},{{$adresa['drzava']}}</option>
                                @else
                                <option value="{{$adresa['id']}}">{{$adresa['ulica_broj']}}, {{$adresa['ulica_broj_dodatak']}}, {{$adresa['naziv']}},{{$adresa['drzava']}}</option>
                                @endif
                            @endforeach
                        </select>
                        <!--<input type="text" class="form-control" id="korisnicko_ime" name="korisnicko_ime" value="{{$adresa['ulica_broj']}}, {{$adresa['ulica_broj_dodatak']}}, {{$adresa['naziv']}},{{$adresa['drzava']}}">-->
                    </td>
                </tr>
                <tr class="form-group">
                    <td>Uloga:</td>
                    <td>
                        <select name="uloga" id="uloga" class="form-control w-100" >
                            @foreach($roles as $role)
                                @if($role['id']==$detaljanPrikazClana[0]['uloge_uloga_id'])
                                    <option value="{{$role['id']}}" selected>{{$role['uloga_opis']}}</option>
                                @else
                                    <option value="{{$role['id']}}">{{$role['uloga_opis']}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>   
                        <button type="submit" class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold mt-2" id="filter">Ažuriraj</button>
                    </td>
                    <td>
                        <div class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold mt-2" id="ponisti">
                            <a class="" href="{{ route('deleteAUser', [ $prviRoditelj,$drugiRoditelj,$detailUser])  }}" id="ponistilink">
                            <span>Obriši</span></a>
                        </div>
                        <div class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold float-sm-right mt-2" id="ponisti">
                            <a class="" href="{{ route('detaljniPrikazObitelji', [ $prviRoditelj,$drugiRoditelj])  }}" id="ponistilink">
                            <span>Poništi</span></a>
                        </div>
                    </td>
                </tr>             
            </tbody>
        </table>
    </form>
</div>
</div>
@endif
<!--End Single User Detail-->

<!--Family E-mails section-->

@if(count($obiteljskiMailovi)>0)
<div class="container-fluid float-sm-left">
<div class=" card shadow table-responsive mt-4">
    <div class="card-header py-3 mb-3">
        <h5 class="m-0 font-weight-bold text-primary">E-mail komunikacija</h5>
    </div>
    <table class="table table-bordered" id="dataTable" cellspacing="0">
        <thead>
            <tr>
                <td>Broj poruke</td>
                <td>Datum slanja</td>
                <td>Primatelj</td>
                <td>Pošiljatelj</td>
                <td>Predmet</td>
                <td>Sadržaj</td>
                <td>Prilog</td>
            </tr>
        </thead>
        <tbody>
            @foreach($obiteljskiMailovi as $email)
                <tr>
                    <td>{{$email['id']}}</td>
                    <td>{{$email['datum_vrijeme_poslano']}}</td>
                    <td>{{$email['primatelj']}}</td>
                    <td>{{$email['posiljatelj']}}</td>
                    <td>{{$email['predmet']}}</td>
                    <td><div>{{$email['tijelo']}}</div></td>
                    <td>{{$email['putanja']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endif

<!--End Family E-mails section-->

<form action="" id="single-resource-update-form" method="POST">
    @csrf
    @method('PUT')
</form>

@endsection

@section('js')
<script src="{{ asset('assets/js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $("#dataTable").DataTable({
        pageLength: 10,
        select: true,
        lengthMenu: [10, 25, 50, 100, 500],
        aaSorting: [],
        order: [[0, "asc"]],
        language: {
            searchPlaceholder: "{{ __('global.search') }}",
            search: "",
            info: "{{ __('global.infoenteries') }}",
            lengthMenu: "{{ __('global.showentries') }}",
            infoEmpty: "Prikazujem 0 do 0 od 0 unosa",
            infoFiltered: "(filtrirano od _MAX_ ukupnih unosa)",
            zeroRecords: "{{ __('global.noresult') }}",
            paginate: {
                next: "{{ __('global.next') }}",
                previous: "{{ __('global.previous') }}",
            },
        },
    });
});
</script>
@endsection

<!--
@section('js')
<script type="text/javascript">
	var detailsBtn = $('#details-btn');
	var formDetails = $('#resource-details');
	formDetails.hide();
	detailsBtn.click(function(){
		formDetails.slideToggle(600);
    });
</script>-->   
@endsection