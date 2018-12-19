<?php
    require 'database.php';
    
    if(!empty($_GET['id'])) {
        $id= checkInput($_GET['id']);
    }

    if(!empty($_POST)) {
        $id= checkInput($_POST['id']);
        
        $bdd = Database::connect();
        
        $statement = $bdd->prepare("DELETE FROM items WHERE id = ?");
        $statement->execute(array($id));
        
        Database::disconnect();
        header("Location: index.php");
    }

    function checkInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Buger Code</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../css/main.css">
        <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>

    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>
        <div class="container admin">
            <div class="row">
                <h1><strong>Supprimer l'article n°<?= $id ?></strong></h1><br>
                <form class="form" action="delete.php" method="post">
                  <input type="hidden" name="id" value="<?= $id ?>" />
                  <p class="alert alert-warning">Etes vous sur de vouloir supprimer cet article ?</p>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Oui</button>
                        <a href="index.php" class="btn btn-default">Non</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
