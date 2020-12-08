<?php
        $increment = 0;
        $target_dir = "uploads/coms/";
        $target_file = $target_dir . basename($_FILES["imageCom"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if ($uploadOk == 0) {
            echo "Désolé, votre image n'a pas été publié.";
       
        } else {
            if(file_exists($target_file)) {
                while(file_exists($target_file)) {
                $increment++;
                $target_file = $target_dir.$increment.basename($_FILES["imageCom"]["name"]);
            }
            
                if (move_uploaded_file($_FILES["imageCom"]["tmp_name"], $target_file)) {
                    echo "Votre image". htmlspecialchars( basename( $_FILES["imageCom"]["name"])). " a bien été publié.";
                } else {
                    echo "Désolé, votre image n'a pas été publié.";
                }
            }else{
                if (move_uploaded_file($_FILES["imageCom"]["tmp_name"], $target_file)) {
                    echo "Votre image". htmlspecialchars( basename( $_FILES["imageCom"]["name"])). " a bien été publié.";
                } else {
                    echo "Désolé, votre image n'a pas été publié.";
                }
            }
            
        }
?>