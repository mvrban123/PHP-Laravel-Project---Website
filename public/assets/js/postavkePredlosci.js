document.getElementById("spremiPromjene").addEventListener("click", function(e){
    //getTableData;
    var table=document.getElementById("tablicaPostavke");
    var rows=document.getElementById("tablicaPostavke").rows[0].cells[0].innerHTML;
    console.log(rows);
    var dataArray=Array();
    for (i=1;i<=rows;i++){
        var a=document.getElementById("tablicaPostavke").rows[i].cells[0].innerHTML;
        var predlozak=table.rows[i].cells[3].childNodes[1].value;
        var slanje=table.rows[i].cells[4].childNodes[1].checked;
        var odgoda=table.rows[i].cells[5].childNodes[1].value;
        dataArray[i-1]={
            poruka_id:a,
            predlozak:predlozak,
            autoSlanje:slanje,
            odgoda:odgoda
        };
    }
    console.log(dataArray);

    fetch('/email/postavke/update', {
        method: 'post', // or 'PUT'
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
        },
        body:  JSON.stringify(dataArray),
    })
    .then(response => response.text())
    .then(data => {
        console.log('Success:', data);
        toastr.success('Uspješno ažuriranje');
        
    })
    .catch((error) => {
        console.error('Error:', error);
        toastr.error('Greška kod ažuriranja')
    });
});
 