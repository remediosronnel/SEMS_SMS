<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Convert HTML To Image</title>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js">
    </script>
  </head>
  <style media="screen">
    #htmlContent{
      background: lightblue;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 300px;
      height: 200px;
    }
  </style>
  <body onload = "autoClick();">

    <div id = "htmlContent">
      <h1>Hello World!</h1>
    </div>
    <a id="download">Download</a>

    <script type="text/javascript">
      function autoClick(){
        $("#download").click();
      }

      $(document).ready(function(){
        var element = $("#htmlContent");

        $("#download").on('click', function(){

          html2canvas(element, {
            onrendered: function(canvas) {
              var imageData = canvas.toDataURL("image/jpg");
              var newData = imageData.replace(/^data:image\/jpg/, "data:application/octet-stream");
              $("#download").attr("download", "image.jpg").attr("href", newData);
            }
          });

        });
      });
    </script>
  </body>
</html>