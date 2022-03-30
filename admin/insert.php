<?php
    require 'database.php';

    $nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";
    
    if(!empty($_POST))
    {
        $name               = checkInput($_POST['name']);
        $description        = checkInput($_POST['description']);
        $price              = checkInput($_POST['price']);
        $category           = checkInput($_POST['category']);
        $image              = checkInput($_FILES['image']['name']);
        $uniqueName         = uniqid('', true).basename($image);
        $imagePath          = '../images/'.$uniqueName;
        $imageExtension     = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess          = true;
        $isUploadSuccess    = false;

        if(empty($name))
        {
            $nameError = "Ce champ ne peut pas être vide !";
            $isSuccess = false;  
        }
        if(empty($description))
        {
            $descriptionError = "Ce champ ne peut pas être vide !";
            $isSuccess = false;  
        }
        if(empty($price))
        {
            $priceError = "Ce champ ne peut pas être vide !";
            $isSuccess = false;  
        }
        if(empty($category))
        {
            $categoryError = "Ce champ ne peut pas être vide !";
            $isSuccess = false;  
        }
        if(empty($image))
        {
            $imageError = "Ce champ ne peut pas être vide !";
            $isSuccess = false;  
        }
        else
        {
            $isUploadSuccess = true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) {
                $imageError = "Les fichiers autorisés sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath)) {
                $imageError = "Le fichier existe déjà";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 500000) {
                $imageError = "Le fichier ne doit pas dépasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                } 
            } 

        }

        if($isSuccess && $isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO items (name,description,price,category,image) values(?, ?, ?, ?, ?)");
            $statement->execute(array($name,$description,$price,$category,$uniqueName));
            Database::disconnect();
            header("Location: index.php");
        }
    }

    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }

?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Projet Burger</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/style.css"> 
</head>
<body>
<h1 class="text-logo"><span class="bi-shop"></span> FOODBOX Burger <span class="bi-shop"></span></h1>
        <div class="container admin">
            <div class="row">
                <h1><strong>Ajouter un produit</strong></h1>
                <br>
                <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">
                    <br>
                    <div class="form-group">
                        <label class="form-label" for="name">Nom: </label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                        <span class="help-inline"><?php echo $nameError; ?></span>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="form-label" for="description">Description: </label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                        <span class="help-inline"><?php echo $descriptionError; ?></span>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="form-label" for="price">Prix: (en €)</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                        <span class="help-inline"><?php echo $priceError; ?></span>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="form-label" for="category">Categorie: </label>
                        <select class="form-control" id="category" name="category">
                            <?php
                                $db = Database::connect();
                                foreach($db->query('SELECT * FROM categories') as $row)
                                {
                                    echo '<option value="'. $row['id'] . '">' .$row['name'] .'</option>';
                                }
                                Database::disconnect();

                            ?>
                        </select>
                        <span class="help-inline"><?php echo $categoryError; ?></span>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="form-label" for="image">Sélectionner une image: </label>
                        <input type="file" id="image" name="image">
                        <span class="help-inline"><?php echo $imageError; ?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="bi-plus"></span>Ajouter</button>
                        <a href="index.php" class="btn btn-primary"><span class="bi-plus"></span>Retour</a>
                    </div> 
                </form>
            </div>
        </div>
</body>
</html>