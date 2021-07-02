@extends('layouts.admin')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('content')

<form action="{{ route('autoEmails', $mail )  }}" method='POST'>
<h4 class="ml-2">Filtriraj po datumu</h4>
{{ csrf_field() }}
<table class="ml-2">
<tr> 
<td class="mr-3">OD</td>
<td><input type="date" value="<?php echo (new DateTime('last week'))->format('Y-m-d');?>" id="od" class="od mr-3 ml-2" name="od" required></td>
<td class="mr-3">DO</td>
<td><input type="date" value="<?php echo (new DateTime())->format('Y-m-d');?>" id="do" class="do mr-3 ml-2" name="do" required></td>
<td><button type='submit' id='filtirajEmailove' class='btn btn-md btn-primary shadow-sm font-weight-bold mr-2 ml-2'>FIltriraj</button></td>
</tr>
</table>
</form>
<div class="card-body row">
<div class="mt-5 table-responsive">
<table class="table table-bordered " id="dataTable" cellspacing="0" >
            <thead>
                <tr>
                    <th class="text-center" id="brojRedova" hidden>{{$brojRedova}}</th>
                    <th class="text-center">Datum</th>
                    <th class="text-center">Predmet</th>
                    <th class="text-center">Pošiljatelj</th>
                    <th class="text-center">Primatelj</th>
                    <th class="text-center">Prikaz poruke</th>
                    <th class="text-center" hidden>Pregled</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($mailovi as $mail)
                <tr>
                    <td hidden></td>
                    <td class="text-center">{{$mail['datum_vrijeme_poslano']}}</td>
                    <td class="text-center">{{$mail['predmet']}}</td>
                    <td class="text-center">{{$mail['posiljatelj']}}</td>
                    <td class="text-center">{{$mail['primatelj']}}</td>
                    <td class="text-center" value="{{($mail['id'])}}" data="{{($mail['id'])}}">
                        <a class="action-icon mr-2 ml-2" id="{{($mail['id'])}}" data="{{($mail['id'])}}" data-toggle="modal" data-target="#edit-modal" value="{{($mail['id'])}}">
                        <i class="far fa-eye fa-fw"></i>
                        </a>
                    </td>
                    <td hidden>{{($mail['id'])}}</td>
                </tr>
                @endforeach
            </tbody>    
</table>
</div>
</div>
<div class="modal fade" id="edit-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
        <h4 class="modal-title" align="center"><b>Pregled</b></h4>
      </div>
      <div class="modal-body">
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          
          <div id="elementiPretrage">

          </div>
          <div class="modal-footer">
            <a href="https://google.com" class='btn btn-md btn-primary shadow-sm font-weight-bold mt-2 mr-2'>Pogledaj cijelu poruku</a>
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
  </div>
</div>

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script src="{{ asset('assets/js/pregled.js') }}"></script>


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

@endsection