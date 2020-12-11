<?php
        $increment_avatar = 0;
        $target_dir_avatar = "uploads/pictures/avatars";
        $target_file_avatar = $target_dir_avatar . basename($_FILES["avatar"]["name"]);
        $uploadOk_avatar = 1;
        $imageFileType_avatar = strtolower(pathinfo($target_file_avatar,PATHINFO_EXTENSION));
        if ($uploadOk_avatar == 0) {
            echo "Désolé, votre image n'a pas été publié.";
       
        } else {
            if(file_exists($target_file_avatar)) {
                while(file_exists($target_file_avatar)) {
                $increment_avatar++;
                $target_file_avatar = $target_dir_avatar.$increment_avatar.basename($_FILES["avatar"]["name"]);
            }
            
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file_avatar)) {
                    echo "Votre image". htmlspecialchars( basename( $_FILES["avatar"]["name"])). " a bien été publié.";
                } else {
                    echo "Désolé, votre image n'a pas été publié.";
                }
            }else{
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file_avatar)) {
                    echo "Votre image". htmlspecialchars( basename( $_FILES["avatar"]["name"])). " a bien été publié.";
                } else {
                    echo "Désolé, votre image n'a pas été publié.";
                }
            }
            
        }
?>