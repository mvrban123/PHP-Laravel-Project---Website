{{$querryZaBrojClanovaObitelji}}
<br>

{{$querryZaObaRoditelj}}
<br>

{{$querryZaJednogRoditelj}}


<table class="table table-bordered" id="dataTable" cellspacing="0">
    <thead>
        <tr>
            <th class="text-center">Prvi roditelj</th>
            <th class="text-center">Drugi roditelj</th>
            <th class="text-center no-sort"></th>
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