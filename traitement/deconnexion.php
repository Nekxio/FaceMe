<?php
    sleep(2);
    session_destroy();
    header('Location: index.php');
?>