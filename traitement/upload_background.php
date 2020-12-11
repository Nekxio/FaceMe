<?php
        $increment_background = 0;
        $target_dir_background = "uploads/pictures/backgrounds/";
        $target_file_background = $target_dir_background . basename($_FILES["background"]["name"]);
        $uploadOk_background = 1;
        $imageFileType_background = strtolower(pathinfo($target_file_background,PATHINFO_EXTENSION));
        if ($uploadOk_background == 0) {
            echo "Désolé, votre image n'a pas été publié.";
       
        } else {
            if(file_exists($target_file_background)) {
                while(file_exists($target_file_background)) {
                $increment_background++;
                $target_file_background = $target_dir_background.$increment_background.basename($_FILES["background"]["name"]);
            }
            
                if (move_uploaded_file($_FILES["background"]["tmp_name"], $target_file_background)) {
                    echo "Votre image". htmlspecialchars( basename( $_FILES["background"]["name"])). " a bien été publié.";
                } else {
                    echo "Désolé, votre image n'a pas été publié.";
                }
            }else{
                if (move_uploaded_file($_FILES["background"]["tmp_name"], $target_file_background)) {
                    echo "Votre image". htmlspecialchars( basename( $_FILES["background"]["name"])). " a bien été publié.";
                } else {
                    echo "Désolé, votre image n'a pas été publié.";
                }
            }
            
        }
?>