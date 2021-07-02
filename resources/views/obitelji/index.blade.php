@extends('layouts.admin')

@section('title', 'Obitelji')

@section('css')
<!-- Datatable style -->
<link href="{{ asset('assets/css/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<!-- Begin Page Content -->
    <div class="float-right">
        <button name="btnGrupa" id="btnGrupa" class="d-inline-block d-sm-inline-block btn btn-md btn-primary shadow-sm font-weight-bold mt-4 mr-2" data-toggle="modal" data-target="#edit-modal">Napredno pretraživanje</button>
    </div>
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Obitelji</h1>
    <p class="mb-4">Podaci o obiteljima</p>

    <!-- DataTable -->

    <div>
        <div id="filterForm" name="filterForm" class="filterForm"></div>
        <div id="filterButtonDiv" name="filterButtonDiv" class="filterButtonDiv"></div>
    </div>

    
        </div>
        <div class="card-body row">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">Prvi roditelj</th>
                            <!--<th class="text-center">Email roditelja</th>-->
                            <th class="text-center">Drugi roditelj</th>
                            <!--<th class="text-center">Email roditelja</th>-->
                            <th class="text-center no-sort"></th>
                            <!--<th class="text-center"></th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data3 as $dat)
                        <tr>
                            @if($dat['drugiRoditeljId']!=0)
                                
                                <td class="text-center">{{$dat['prviRoditeljIme']}}</td>

                                <td class="text-center">{{$dat['drugiRoditeljIme']}}</td>
                            @else
                                <td class="text-center">{{$dat['prviRoditeljIme']}}</td>

                                <td class="text-center"></td>

                            @endif
                            <td class="text-center">
                                <a class="action-icon mr-2 ml-2" href="{{ route('detaljniPrikazObitelji', [ $dat['prviRoditeljId'], $dat['drugiRoditeljId'] ])  }}">
                                    <i class="far fa-eye fa-fw"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>    
    </div>

    <div class="row mt-4 mb-4 ml-1 mr-1 float-sm-right">           
                <a href="#" class="d-inline-block d-sm-inline-block btn btn-sm btn-primary shadow-sm font-weight-bold" id ="posaljiMail">
                    
                    Pošalji mail
                </a>
        </div>

    <div class="row mt-4 mb-4 ml-1 mr-1 float-sm-right">           
                <a href="#" class="d-inline-block d-sm-inline-block btn btn-sm btn-primary shadow-sm font-weight-bold">
                    <i class="fas fa-trash fa-sm text-white-50 mr-2"></i>
                    BRISANJE
                </a>
        </div>
</div>

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

<div class="modal fade" id="edit-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
        <h4 class="modal-title" align="center"><b>Napredno pretraživanje</b></h4>
      </div>
      <div class="modal-body">
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <div id="elementiPretrage">

          </div>
          <div class="modal-footer">
            <button id="btnObrisiFilterPretrage" type="button" class="btn btn-default pull-left" data-dismiss="modal">Obriši filter</button>
            <button type="submit" class="btn btn-primary" data-dismiss="modal" onClick="pretraziButton()">Pretraži</button>
          </div>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('assets/js/userFilter.js') }}"></script>
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

@endsection

<form action="" id="single-resource-update-form" method="POST">
    @csrf
    @method('PUT')
</form>



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
        buttons: [
            {
                text: 'My button',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            }
        ],
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

<script type="text/javascript">
$(document).ready(function () {
    "use strict";

    var posaljiButton = document.getElementById("posaljiMail");


    posaljiButton.addEventListener("click", function(){
        var i;
        var poljeZaSlanje = "";
        var table = $('#dataTable').DataTable();
        var selectedData = table.rows( {selected: true} ).data().toArray();


        for (i = 0; i < selectedData.length; i++){
            
            poljeZaSlanje += selectedData[i][2].match(/(\/\d+)*/gi);
            //poljeZaSlanje += selectedData[i][2].match(/(\/[0-9]+)*/gi);
        }

        var rezultat = poljeZaSlanje.replace(/,/gi,"");


        if(rezultat==""){
            return;
        }

        var url = '../email/slanje';
        var form = $('<form action="' + url + '" method="post">' +
        '<input type="text" name="rezultat" id="rezultat" value="' + rezultat + '" />' +
        '@csrf' +
        '</form>');
        $('body').append(form);
        form.submit();
        
        
    });

});
</script>
@endsection