
function fetchRso(){
    var id = document.getElementById("empID").value;
    alert(id);

    $.ajax({
        url: "fetchRSO.php",
        method: "POST",
        data:{
            x : id
        },
        dataType: "JSON",
        success: function(data){
            var orgNAME =  document.getElementById("orgName").value = data.orgName;
            var firstNAME = document.getElementById("firstName").value = data.firstName;
            var middleNAME = document.getElementById("middleName").value = data.middleName;
            var lastNAME = document.getElementById("lastName").value = data.lastName;
            var positioN = document.getElementById("position").value = data.position;
            var contactNO = document.getElementById("contactNo").value = data.contactNo;
            console.log(orgNAME);
            console.log(firstNAME);
            console.log(middleNAME);
            console.log(lastNAME);
            console.log(positioN);
            console.log(contactNO);

        }
            

    })

}