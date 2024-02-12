<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OFFICERS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
   <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="file"] {
            margin-bottom: 15px;
        }
        #imagePreview {
            text-align: center;
            margin-bottom: 15px;
        }
        #imagePreview img {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
        }
        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        select {

            width: 200px;
        }
        #name{
         
            margin: 10px;
            width: 300px;
        }
        #back, #list{
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Image</h1>
        <form  method="post" enctype="multipart/form-data" action="function.php">
            <label for="file">Name:</label>

            <input type="text" id="name" name="name"  >

            <input type="file" id="file" name="file" accept="img/RSO_image/*" required onchange="previewImage()">

            <select id="position" name="position" class="form-select">
                <option value="">CHOOSE POSITION</option>
                <option value="President">President</option>
                <option value="Vice President">Vice President</option>
                <option value="Secretary">Secretary</option>
                <option value="Treasurer">Treasurer</option>
                <option value="Auditor">Auditor</option>
                <option value="Business Manager">Business Manager</option>
                <option value="PIO">PIO</option>
               
            </select>




            
            <div id="imagePreview">

            <img id="imagePreview" name="imagePreview">


            </div>
            <button type="submit" class='btn btn-primary btn-sm' name="submit" id="submit" value="add">Upload Image</button>

            <a type="button" id="back" name="back" class='btn btn-danger' href="home.php">BACK</a>

            <a type="button" id="list" name="list" class='btn btn-primary' href="file_upload.php">OFFICERS</a>
        </form>
    </div>

    <script>
        function previewImage() {
            var preview = document.querySelector('#imagePreview img');
            var file = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
    <script>
        function getValue() {
            // Get the dropdown element
            var dropdown = document.getElementById("position");
            // Get the selected value
            var selectedValue = dropdown.value;
            // Display the selected value
            document.getElementById("selectedValue").textContent = "Selected value: " + selectedValue;
        }
    </script>
</body>
</html>
