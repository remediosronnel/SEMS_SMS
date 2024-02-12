
function fetchRSO(){
    var y = document.getElementById("recePient").value;
    alert(y);

    $.ajax({
        url: "fetchNumber.php",
        method: "POST",
        data:{
            id : y
        },
        dataType: "JSON",
        success: function(data){
           $("#ans").html(data);

        }
    })

}