<?php
session_start();

// ... Your existing PHP code

if (isset($_POST['submitLogo'])) {
    $targetDir = 'C:\xampp\htdocs\SSG\RSO\logos\\'; // Corrected directory path with escaped backslash
    $targetFile = $targetDir . basename($_FILES['logoFile']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a PNG
    if ($imageFileType !== 'png') {
        echo 'Sorry, only PNG files are allowed.';
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo 'Sorry, file already exists.';
        $uploadOk = 0;
    }

    // Upload file
    if ($uploadOk === 0) {
        echo 'Sorry, your file was not uploaded.';
    } else {
        if (move_uploaded_file($_FILES['logoFile']['tmp_name'], $targetFile)) {
            echo 'The file ' . htmlspecialchars(basename($_FILES['logoFile']['name'])) . ' has been uploaded.';
        } else {
            echo 'Sorry, there was an error uploading your file.';
        }
    }
    // header("Location: home.php");
}
?>
