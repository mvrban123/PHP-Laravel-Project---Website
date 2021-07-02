@extends('layouts.admin')

@section('content')

<h3 class="ml-2"> 
Upravljanje predlošcima
</h3>
<div class="card-body row">
    <div class="table-responsive">
    <div class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold mt-2 mb-3 mr-3 float-md-right" id="kreirajPredlozak">
        <a style="text-decoration:none;  color: inherit;"  href="{{ route('kreiranjePredloskaIndex')  }}" id="ponistilink">
        <span>Kreiraj novi predložak</span>
        </a>
    </div>
        <table class="table table-bordered" id="dataTable" cellspacing="0">
            <thead style="background-color: #f15a54; color:#fff; ">
                <tr>
                    <th class="text-center">Naslov</th>
                    <th class="text-center">Kategorija</th>
                    <th class="text-center">Kreator</th>
                    <th class="text-center">Pregled</th>
                    <th class="text-center no-sort">Brisanje</th>  
                </tr>
            </thead>
            <tbody>
                @foreach($sviPredlosci as $predlozak)
                <tr>
                    <td class="text-center">{{$predlozak['naslov']}}</td>
                    <td class="text-center">{{$predlozak['naziv']}}</td>
                    <td class="text-center">{{$predlozak['ime']}} {{$predlozak['prezime']}}</td>
                    <td class="text-center">
                        <a class="action-icon mr-2 ml-2" href="{{ route('kreiranjePredloskaIndex', $predlozak['id'] )  }}">
                            <i class="far fa-eye fa-fw"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="action-icon mr-2 ml-2" href="{{ route('brisanjePredloska', $predlozak['id'] )  }}">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>



@endsection