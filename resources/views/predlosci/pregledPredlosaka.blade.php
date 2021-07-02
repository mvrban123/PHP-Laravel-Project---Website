@extends('layouts.admin')
@section('content')

<table>
<tr>
    <td>
        <table class="table table-bordered" cellspacing="0">
                    <thead> 
                        <h3 class="text-center">Prilozi</h3>
                        <tr>
                            <th class="text-center" hidden>ID priloga</th>
                            <th class="text-center">Naziv priloga</th>
                            <th class="text-center">Putanja priloga</th>
                            <th class="text-center">Brisanje</th>
                        </tr>
                    </thead>

                        <tr>
                            @if ($prilog != NULL)
                            <td class="text-center" hidden>{{$prilog['id']}}</td>
                            <td class="text-center">{{$prilog['naslov']}}</td>
                            <td class="text-center">{{$prilog['putanja']}}</td>
                            <td class="text-center">
                                <a class="action-icon mr-2 ml-2" href="{{ route('brisiPrilog', [$predlozak['id'],$prilog['id']] )  }}">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                            @endif
                        </tr>
        </table>
        
    </td>
    
    <td>
        <table class="table table-bordered" id="dataTable" cellspacing="0" >
            <thead>
                <h3 class="text-center">Predložak</h3>
                    <tr>
                        <th class="text-center">Naslov</th>
                        <th class="text-center">Kategorija</th>
                        <th class="text-center">Kreator</th>
                    </tr>
            </thead>

                        <tr>
                            @if ($predlozak != NULL)
                                
                            
                            <td class="text-center">{{$predlozak['naslov']}}</td>
                            <td class="text-center">{{$predlozak['kategorije_predlozaka_id']}}</td>
                            <td class="text-center">{{$predlozak['korisnici_id']}}</td>

                            @endif
                        </tr>
        </table>
        </td>
        </tr>
        <tr>
        <td></td>
        <td>
        <table class="table table-bordered" id="dataTable" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">Definicija</th>
                        </tr>
                    </thead>

                        <tr>
                            @if ($predlozak != NULL)
                            <td class="text-center">{{html_entity_decode($predlozak['definicija'])}}</td>
                            @endif
                        </tr>
                
        </table>
        </td>
        
        </tr>
    
    
</table>


@endsection
