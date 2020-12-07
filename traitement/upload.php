<?php
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if ($uploadOk == 0) {
            echo "Désolé, votre image n'a pas été publié.";
       
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "Votre image". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " a bien été publié.";
            } else {
                echo "Désolé, votre image n'a pas été publié.";
            }
        }
?>