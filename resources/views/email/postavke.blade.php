@extends('layouts.admin')

@section('title', 'Detalji o obitelji')

@section('css')
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('content')
<div class="card-body row">
            <div class="table-responsive">
                <table class="table table-bordered" id="tablicaPostavke" cellspacing="0">
                    
                        <tr>
                            <th class="text-center" id="brojRedova" hidden>{{$brojRedova}}</th>
                            <th class="text-center">Opis</th> 
                            <th class="text-center">Kreator</th>
                            <th class="text-center no-sort">Korišteni predložak</th>  
                            <th class="text-center no-sort">Automatsko slanje</th>
                            <th class="text-center no-sort">Odgoda slanja</th>
                            <th class="text-center">Poslane poruke</th>   
                        </tr>
                        @foreach($autoPoruke as $poruke)
                        <tr>
                            <td class="text-center" hidden>{{$poruke['id']}}</td>
                            <td class="text-center">{{$poruke['opis']}}</td>
                            <td class="text-center">{{$poruke['kreator']}}</td>
                            <td class="text-center">
                                <select name="pets" id="pet-select">
                                    @foreach($sviPredlosci as $predlozak)
                                        @if($predlozak['id']==$poruke['email_predlosci_id'])
                                            <option value="{{$predlozak['id']}}" selected>{{$predlozak['naslov']}}</option>
                                        @else
                                            <option value="{{$predlozak['id']}}" >{{$predlozak['naslov']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            @if($poruke['omoguceno'])
                                <td class="text-center">
                                    <input type="checkbox" id="autoSlanje" name="autoSlanje" checked> 
                                </td>
                            @else
                                <td class="text-center">
                                    <input type="checkbox" id="autoSlanje" name="autoSlanje" > 
                                </td>
                            @endif
                            <td class="text-center">
                                <select name="pets" id="pet-select">
                                    @foreach($odgodeSlanja as $odgodaSlanja)
                                        @if($odgodaSlanja['id']==$poruke['tipovi_odgode_id'])
                                            <option value="{{$odgodaSlanja['id']}}" selected>{{$odgodaSlanja['naziv']}}</option>
                                        @else
                                            <option value="{{$odgodaSlanja['id']}}" >{{$odgodaSlanja['naziv']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center">
                                <a class="action-icon mr-2 ml-2" href="{{ route('autoEmails', $poruke['id'] )  }}">
                                <i class="far fa-eye fa-fw"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    
                </table>
            </div>
            <button id='spremiPromjene' class='btn btn-md btn-primary shadow-sm font-weight-bold mt-2 mr-2'>Spremi</button>
            <div class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold float-sm-right mt-2" id="ponisti">
                            <a class="" href="{{ route('emailPostavke')}}" id="ponistilink">
                            <span>Poništi promjene</span></a>
            </div>

        </div>    

<script src="{{ asset('assets/js/postavkePredlosci.js') }}"></script>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
@endsection