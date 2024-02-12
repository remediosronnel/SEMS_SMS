<?php
session_start();
$id = $_SESSION['studentID'];


        $sname = "127.0.0.1";
        $uname = "root";
        $password = "";
        $db_name = "lazaca";
       
        
        
        
        $conn = mysqli_connect($sname, $uname, $password, $db_name);
        if ($conn->connect_error) { 
            die("Connection failed: " . $conn->connect_error); 
        } 
          
            $sql = "SELECT *  FROM studenttable WHERE studenttable.studentID = '$id'";
            $result = $conn -> query($sql);
            $row = mysqli_fetch_array($result);
           
 ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>QR Code Generator</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="js/qrcode.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/build/qrious.min.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js">
    </script>
    <style>
      .hidden {
          display: none;
      }

      
    </style>
    
    <style media="screen">
    #htmlContent{
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 300px;
      height: 300px;
    }
  </style>

</head> 
        
<body onload = "autoClick();">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card">
      <div class="card-header bg">
        <h1>QR Code Generator</h1>

      </div>
          <div class="card-body">
          <form onsubmit="generate();return false;">
          

           
           <input type="hidden" class="form-control" value = "<?php echo $row['idNumber'];?>" id="qr" name="qr">
           
           <input type="submit" name= "btnSubmit" id= "btnSubmit"  class="btn btn-primary" value="Generate QRCode">

      
           <div class="card-header">
            <button class="btn btn-primary" id="download" name="download" disabled onclick="download()">Download</button>
    </div>
              
           
              
      

           <div class="card-header">
           <a class="btn btn-danger" name="cancel" id="cancel"  href="home.php" >CANCEL</a>
           </div>
           
</form>
<div id = "htmlContent" style="height:500px; width:500px; float:center;">

</div>
          </div>
      </div>
    </div>
  </div>	

 
     
   
  <script type="text/javascript">

    var qrcode= new QRCode(document.getElementById('htmlContent'),{
    width:300,
    height:300
    });
   
    function generate(){
     
      var message = document.getElementById('qr');
      qrcode.makeCode(message.value);
     

    }
 
  </script>
 
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>


<script>
    $(document).ready(function() {
    var element = $("#htmlContent");

    // Function to generate QR code
    function generate() {
        var message = document.getElementById('qr');
        qrcode.makeCode(message.value);
        // Enable download button after QR code is generated
        $("#download").removeAttr('disabled');
    }

    // Event listener for download button click
    function download() {
        html2canvas(element, {
            onrendered: function(canvas) {
                var imageData = canvas.toDataURL("image/png");
                var newData = imageData.replace(/^data:image\/png/, "data:application/octet-stream");
                var link = document.createElement('a');
                link.setAttribute('download', 'image.png');
                link.setAttribute('href', newData);
                link.click();
            }
        });
    };

    // Event listener for Generate QRCode button click
    $("#btnSubmit").on('click', function() {
        generate();
    });

    // Event listener for Cancel button click
    $("#cancel").on('click', function() {
        // Add your cancel logic here
    });

    $("#download").on('click', function() {
       download();
    });
});
</script>
   


<script>

  document.querySelector('#btnSubmit').addEventListener('onclick', () => {
    document.querySelector('#download').setAttribute('enabled',"");
    document.querySelector('#cancel').setAttribute('enabled',"");
    
  });
</script>
</body>

</html>