<?php 
require 'function.php';

$id = $_GET['id'] ?? null;

$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM officertable where officerID = '$id'"));



?>
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

            <input type="text" id="name" name="name" value="<?php echo $user['officer_name']; ?>"  >

            <input type="file" id="file" name="file" accept="img/RSO_image/*" required onchange="previewImage()">

            <select id="position" name="position" class="form-select" value="<?php echo $user['officer_position']; ?>">
                <option value="">CHOOSE POSITION</option>
                <option value="President" <?php if ($user['officer_position'] === "President") echo "selected"; ?>>President</option>
                <option value="Vice President" <?php if ($user['officer_position'] === "Vice President") echo "selected"; ?>>Vice President</option>
                <option value="Secretary" <?php if ($user['officer_position'] === "Secretary") echo "selected"; ?>>Secretary</option>
                <option value="Treasurer" <?php if ($user['officer_position'] === "Treasurer") echo "selected"; ?>>Treasurer</option>
                <option value="Auditor" <?php if ($user['officer_position'] === "Auditor") echo "selected"; ?>>Auditor</option>
                <option value="Business Manager" <?php if ($user['officer_position'] === "Business Manager") echo "selected"; ?>>Business Manager</option>
                <option value="PIO" <?php if ($user['officer_position'] === "PIO") echo "selected"; ?>>PIO</option>
                
               
            </select>

            <input type="hidden" id="id" name="id" value="<?php echo $user['officerID']; ?>">
            
            <div id="imagePreview">

            <img id="imagePreview" name="imagePreview" >


            </div>
            <button type="submit" class='btn btn-primary btn-sm' name="submit" id="submit" value="edit"> Edit </button>
            
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
  
</body>
</html>
