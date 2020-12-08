<?php
        $target_dir = "uploads/coms/";
        $target_file = $target_dir . basename($_FILES["imageCom"]["name"]);
        $uploadOk = 1;
        $imageComFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if ($uploadOk == 0) {
            echo "Désolé, votre imageCom n'a pas été publié.";
       
        } else {
            if (move_uploaded_file($_FILES["imageCom"]["tmp_name"], $target_file)) {
                echo "Votre imageCom". htmlspecialchars( basename( $_FILES["imageCom"]["name"])). " a bien été publié.";
            } else {
                echo "Désolé, votre imageCom n'a pas été publié.";
            }
        }
?>