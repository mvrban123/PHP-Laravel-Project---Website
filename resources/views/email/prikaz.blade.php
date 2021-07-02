<table id="prikazEmaila">
            <tbody>
                @foreach($mailovi as $mail)
                <tr>
                    <th class="text-left">Datum:</th>
                    <td class="text-left ">{{$mail['datum_vrijeme_poslano']}}</td>
                </tr>
                <tr>
                    <th class="text-left mr-3">Predmet:</th>
                    <td class="text-left">{{$mail['predmet']}}</td>
                </tr>
                <tr>
                    <th class="text-left mr-3">Pošiljatelj:</th>
                    <td class="text-left ml-2">{{$mail['posiljatelj']}}</td>
                </tr> 
                <tr>
                    <th class="text-left mr-3">Primatelj:</th>
                    <td class="text-left">{{$mail['primatelj']}}</td>
                </tr>
                @endforeach
            </tbody>  
            
</table>
<table id="prikazEmaila">
    <hr>
    <tbody>
        @foreach($mailovi as $mail)
            <tr>
            <th class="text-left">Tijelo:</th>
            </tr>
            <tr>
                <td class="text-center">
                    <div id="tijeloPoruke">
                    {{html_entity_decode($mail['tijelo'])}}  
                    </div>
                    </td>  
            </tr>
        @endforeach
                
    </tbody>
</table>