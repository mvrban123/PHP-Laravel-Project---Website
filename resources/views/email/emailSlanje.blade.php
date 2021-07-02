@extends('layouts.admin')

@section('title', 'Slanje')

@section('css')
<!-- Datatable style -->
<link href="{{ asset('assets/css/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@csrf
<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('content')

<div class="row ml-3 mb-5">
  <div class="col-sm-4 mt-5 mr-5">
    <div class="table-responsive mt-4">
      <table class="table table-bordered" id="tablica" cellspacing="0" name="ime">
        <thead style="background-color: #f15a54; color:#fff; ">
          <tr>
            <th class="text-center">#</th>
            <th class="text-center">Obitelj</th>
          </tr>
        </thead>
        <tbody>
        @foreach($sviPrimatelji as $obitelj)
          <tr class="accordion-toggle collapsed" id="accordion{{$obitelj[0]->id}}" data-toggle="collapse" data-parent="#accordion{{$obitelj[0]->id}}" href="#collapse{{$obitelj[0]->id}}">
            <td class="text-center"></td>
            <td class="text-center">{{$obitelj[0]->prezime}}</td>
          </tr>
          @foreach($obitelj as $clan)
          <tr class="hide-table-padding" >
            <td></td>
            <td>
              <div id="collapse{{$obitelj[0]->id}}" class="collapse in p-3">
                <div class="row">
                  <div class="col">{{$clan->ime}}</div>
                  @if($clan->prima_obavijesti_flag == true)
                  <div class="col"> <input type="checkbox" id="primatelj{{$clan->id}}" name="primatelj{{$clan->id}}" value="{{$clan->id}}" checked="true" onClick="ispisiUpozorenje(primatelj{{$clan->id}})"> </div>
                  @else
                  <div class="col"> <input type="checkbox" id="primatelj{{$clan->id}}" onClick="ispisiUpozorenje(primatelj{{$clan->id}})" name="primatelj{{$clan->id}}" value="{{$clan->id}}" > </div>
                  @endif
                </div>
              </div>
            </td>
          </tr>
          @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="col">
    <div class="float-sm-right mr-5">
      <label for="predlozak">Odaberite predložak:</label>
        <select name="predlozak" id="predlozak">
          @foreach($sviPredlosci as $predlozak)
          <option value="{{$predlozak->id}}">{{$predlozak->naslov}}</option>
          @endforeach
        </select>
    </div>
    <div id="Pregled" class="mr-5 mt-5">
      <label for="pregledPredloska">Preview:</label>
        
      <div contenteditable="true" id="pregledPredloska" style="border-style: groove; height:500px; overflow: scroll;">
      </div>
    </div>

    <br>
    <br>
    <div id = "Gumb2" name = "Gumb2" class="float-sm-right mr-5"> 
      <input type="button" value="Pošalji mail" name="posaljiMail" id="posaljiMail" class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold" >
    </div>
  </div>
</div>  


<script src="{{ asset('assets/js/slanjeMail.js') }}"></script>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="{{ asset('assets/js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/responsive.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
    function ispisiUpozorenje(id){
      
      if(id.checked){
        toastr.info('Za slanje ste odabrali korisnika koji nije prihvatio da su me šalje mail');
      }
      
    }

</script>

@endsection

