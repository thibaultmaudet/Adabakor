<?php
require_once 'inc/functions.php';
require_once 'inc/db.php';
reconnect_from_cookie();
require 'inc/header.php';
$mode = $_GET["mode"];
switch($mode){
    case "edit":
        $itemid = $_GET["id"];
        $req = $pdo->prepare('SELECT * FROM `Users` WHERE id = ?');
        $req->execute(array($itemid));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        echo '
        <h1>Utilisateur :</h1>

        <form action="" method="POST">

        <div class="form-group">
            <label for="">ID</label>
            <input type="text" name="id" class="form-control" value="'.$data["id"].'" readonly/>
        </div>

        <div class="form-group">
            <label for="">Nom</label>
            <input type="text" name="lastName" class="form-control" value="'.$data["lastName"].'" />
        </div>

        <div class="form-group">
            <label for="">Prénom</label>
            <input type="text" name="firstName" class="form-control" value="'.$data["firstName"].'" />
        </div>

        <button type="submit" class="btn btn-primary">Enregister</button>

        </form>
        ';
        $req->closeCursor();
        if(!empty($_POST)){
            $req2 = $pdo->prepare("UPDATE `Users` SET firstName = ?, lastName = ? WHERE id = ?");
            $req2->execute(array($_POST["firstName"],$_POST["lastName"],$itemid));
            $req2->closeCursor();
            header('Location: users.php');
        }
    break;

    case "add":
        echo '
        <h1>Utilisateur :</h1>

        <form action="" method="POST">

        <div class="form-group">
            <label for="">ID</label>
            <input type="text" name="id" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="">Nom</label>
            <input type="text" name="lastName" class="form-control" />
        </div>

        <div class="form-group">
            <label for="">Prénom</label>
            <input type="text" name="firstName" class="form-control"/>
        </div>

        <button type="submit" class="btn btn-primary">Enregister</button>

        </form>
        ';

        if(!empty($_POST)){
            $req = $pdo->prepare('INSERT INTO `Users` (`id`, `firstName`, `lastName`) VALUES (?, ?, ?);');
            $req->execute(array($_POST["id"],$_POST["lastName"],$_POST["firstName"]));
            header('Location: users.php');
        }
    break;

    default:
    break;
}
require 'inc/footer.php'; 
?>