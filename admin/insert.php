<?php
    require 'database.php';
    
    /* ERROR par défaut */
    $nameError = $descriptionError = $priceError = $categoryError = $imageError = "";
    /* Valeur par défaut*/
    $name = $description = $price = $category = $image = "";

    if(!empty($_POST)) {
        $name           = checkInput($_POST['name']);
        $description    = checkInput($_POST['description']);
        $price          = checkInput($_POST['price']);
        $category       = checkInput($_POST['category']);
        $image          = checkInput($_FILES['image']['name']);
        $imagePath      = '../images/'.basename($image);
        $imageExt       = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess      = true;
        $isUploadSuccess= false;
        
        if(empty($name)) {
            $nameError = "Ce champs est obligatoire";
            $isSuccess = false;
        }
        if(empty($description)) {
            $descriptionError = "Ce champs est obligatoire";
            $isSuccess = false;
        }
        if(empty($price)) {
            $priceError = "Ce champs est obligatoire";
            $isSuccess = false;
        }
        if(empty($category)) {
            $categoryError = "Ce champs est obligatoire";
            $isSuccess = false;
        }
        if(empty($image)) {
            $imageError = "Ce champs est obligatoire";
            $isSuccess = false;
        } else {
            $isUploadSuccess = true;
            /*Verification de l'image */
            if($imageExt != "jpg" && $imageExt != "png" && $imageExt != "jpeg" && $imageExt != "gif") {
                $imageError = "Les fichiers autorises sont : .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath)) {
                $imageError = "Le fichier existe déjà";
                $isUploadSuccess = false;    
            }
            if($_FILES["image"]["size"] > 500000) {
                $imageError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                }
            } 
        }
        if($isSuccess && $isUploadSuccess) {
            $bdd = Database::connect();
            $statement = $bdd->prepare("INSERT INTO items (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)");
            $statement->execute(array($name,$description,$price,$category,$image));
            Database::disconnect();
            header("Location: index.php");
        } 
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
                <h1><strong>Ajout d'un item</strong></h1><br>
                <form class="form" action="insert.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for='name'>Nom:</label>
                        <input type="text" class="form-control" id='name' name='name' placeholder='Nom' value='<?= $name; ?>' >
                        <span class='help-inline'><?= $nameError ?></span>
                    </div>
                    <div class="form-group">
                        <label for='description'>Description: </label>
                        <input type="text" class="form-control" id='description' name='description' placeholder='Description' value='<?= $description; ?>' >
                         <span class='help-inline'><?= $descriptionError ?></span>
                    </div>
                    <div class="form-group">
                        <label for='price'>Prix:  (en €)</label>
                        <input type="number" step="0.01" class="form-control" id='price' name='price' placeholder='Prix' value='<?= $price; ?>' >
                        <span class='help-inline'><?= $priceError ?></span>
                    </div>
                    <div class="form-group">
                        <label for='category'>Catégories: </label>
                        <select class="form-control" name="category"  id="category">
                            <?php
                                $bdd = Database::connect();
                                foreach($bdd->query("SELECT * FROM categories") as $row) { ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>    
                            <?php    
                                }
                            Database::disconnect();
                            ?>
                        </select>
                        <span class='help-inline'><?= $categoryError ?></span>
                    </div>
                    <div class="form-group">
                        <label for='image'>Sélectionner une image : </label>
                        <input type="file" id='image' name='image' >
                        <span class='help-inline'><?= $imageError ?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                        <a href="index.php" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
