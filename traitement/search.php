<?php
    include("../config/config.php");
    include("../config/bd.php");
    session_start();

    $keyword = $_GET['recherche'];
    $sql1 = "SELECT id,email,name FROM user WHERE name like '%$keyword%' AND id NOT IN (SELECT user.id from user WHERE id = ?)";
    $query1 = $pdo->prepare($sql1);
    $query1->execute(array($_SESSION['id']));
    while($result1 = $query1 -> fetch()){
?>
    <li id="results_search"><a href="index.php?action=profile&id=<?=$result1['id']?>"><?=$result1['name']?></a></li>
<?php
    };
?>