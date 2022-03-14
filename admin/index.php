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
      <h1><strong>Liste des produits </strong><a href="insert.php" class="btn btn-success btn-lg"><span class="bi-plus"></span> Ajouter</a></h1>
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
          $db = Database::connect();
          $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category 
                                                FROM items LEFT join categories on items.category = categories.id
                                                ORDER BY items.id DESC');
          while ($item = $statement->fetch()) {
            echo '<tr>';
            echo '<td>' . $item['name'] . '</td>';
            echo '<td>' . $item['description'] . '</td>';
            echo '<td>' . number_format((float)$item['price'], 2, '.', '') . '</td>';
            echo '<td>' . $item['category'] . '</td>';
            echo '<td width=340>';
            echo '<a class="btn btn-secondary" href="view.php?id=' . $item['id'] . '"><span class="bi-eye"></span> Voir</a>';
            echo ' ';
            echo '<a class="btn btn-primary" href="update.php?id=' . $item['id'] . '"><span class="bi-pencil"></span> Modifier</a>';
            echo ' ';
            echo '<a class="btn btn-danger" href="delete.php?id=' . $item['id'] . '"><span class="bi-x"></span> Supprimer</a>';
            echo '</td>';
            echo '</tr>';
          }

          Database::disconnect()

          ?>

        </tbody>
      </table>
    </div>
  </div>
</body>

</html>