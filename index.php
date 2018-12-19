<?php
    require 'admin/database.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Buger Code</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/main.css">
        <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>

    <body>
        <div class="container site">
            <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Burger Code <span class="glyphicon glyphicon-cutlery"></span></h1>             
            <nav>
                <ul class="nav nav-pills">
                <?php
                    $bdd = Database::connect();
                    $statement = $bdd->query('SELECT * FROM categories');
                    $categories = $statement->fetchAll();
                    
                    foreach($categories as $category) {
                    
                        if($category['id'] == '1') { ?>
                            <li role="presentation" class="active"><a href="#<?= $category['id'] ?>" data-toggle="tab"><?= $category['name'] ?></a></li>
                    <?php } else { ?>
                            <li role="presentation"><a href="#<?= $category['id'] ?>" data-toggle="tab"><?= $category['name'] ?></a></li>
                    <?php   } 
                    }
                ?>                                  
                </ul>
            </nav>
           
                <div class="tab-content">
             <?php
                foreach ($categories as $category) 
                {
                    if($category['id'] == '1')
                        echo '<div class="tab-pane active" id="' . $category['id'] .'">';
                    else
                        echo '<div class="tab-pane" id="' . $category['id'] .'">';
                    
                    echo '<div class="row">';
                    
                    $statement = $bdd->prepare('SELECT * FROM items WHERE items.category = ?');
                    $statement->execute(array($category['id']));
                    while ($item = $statement->fetch()) 
                    {
                        echo '<div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <img src="images/' . $item['image'] . '" alt="...">
                                    <div class="price">' . number_format($item['price'], 2, '.', ''). ' €</div>
                                    <div class="caption">
                                        <h4>' . $item['name'] . '</h4>
                                        <p>' . $item['description'] . '</p>
                                        <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
                                    </div>
                                </div>
                            </div>';
                    }
                   
                   echo    '</div>
                        </div>';
                }
                Database::disconnect();
                ?>
                </div>
        </div>
    </body>
</html>
