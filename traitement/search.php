<?php
    include("../config/config.php");
    include("../config/bd.php");
    session_start();

    $keyword = $_GET['recherche'];
    $sql1 = "SELECT id,email,name FROM user WHERE name like '%$keyword%'";
    $query1 = $pdo->prepare($sql1);
    $query1->execute();
    while($result1 = $query1 -> fetch()){
?>
    <li id="results_search"><a href="index.php?action=profile&id=<?=$result1['id']?>"><?=$result1['name']?></a><a href="index.php?action=friendship&id=<?=$result1['id']?>">Ajouter</a></li>
<?php
    };
?>