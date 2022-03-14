<?php
    require 'database.php';
    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST))
    {
        $id = checkInput($_POST['id']);
        $db = Database::connect();
        $statement = $db->prepare("DELETE FROM items WHERE id = ?");
        $statement->execute(array($id));
        Database::disconnect();
        header("Location: index.php");
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
                <h1><strong>Supprimer un produit</strong></h1>
                <br>
                <form class="form" role="form" action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <p class="alert alert-warning">Etes-vous sûr de vouloir supprimer ?</p>
                    <button type="submit" class="btn btn-warning">Oui</button>
                        <a href="index.php" class="btn btn-default">Non</a>
                    </div> 
                </form>
            </div>
        </div>
</body>
</html>