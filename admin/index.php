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
                <h1><strong>Liste des articles </strong><a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
                
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Catégorie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        
                        require 'database.php';
                        
                        $bdd = Database::connect();
                        $statement = $bdd->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category 
                                                FROM items LEFT JOIN categories ON items.category = categories.id
                                                ORDER BY items.id DESC');
                        
                        while($item = $statement->fetch()) { ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['description'] ?></td>
                            <td><?= number_format((float)$item['price'],2,'.', '') ?> €</td>
                            <td><?= $item['category'] ?></td>
                            <td width=300>
                                <a href="view.php?id=<?= $item['id'] ?>" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>
                                <a href="update.php?id=<?= $item['id'] ?>" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>
                                <a href="delete.php?id=<?= $item['id'] ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>
                            </td>
                        </tr>
                       <?php  
                        }
                        Database::disconnect();
                        ?>     
                       
                    </tbody>
                </table>
            
            </div>
        </div>
    </body>
</html>
