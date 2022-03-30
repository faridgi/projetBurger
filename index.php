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
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container site">

        <h1 class="text-logo"><span class="bi-shop"></span> FOODBOX Burger <span class="bi-shop"></span></h1>
        <?php
            require 'admin/database.php';
            echo '<nav>
                <ul class="nav nav-pills" role="tablist">';
            $db = Database::connect();
            $statement = $db->query('SELECT * FROM categories');
            $categories = $statement->fetchAll();
            foreach ($categories as $category) 
            {
                if ($category['id'] == '1') 
                {
                    echo '<li class="nav-item" role="presentation"><a class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab' . $category['id'] . '" role="tab">' . $category['name'] . '</a></li>';
                } 
                else 
                {
                    echo '<li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="pill" data-bs-target="#tab' . $category['id'] . '" role="tab">' . $category['name'] . '</a></li>';
                }
            }

            echo    '</ul>
            </nav>';
            echo '<div class="tab-content">';

            foreach ($categories as $category) {
                if ($category['id'] == '1') 
                {
                    echo '<div class="tab-pane active" id="tab' . $category['id'] . '" role="tabpanel">';
                } 
                else 
                {
                    echo '<div class="tab-pane" id="tab' . $category['id'] . '" role="tabpanel">';
                }

                echo '<div class="row">';

                $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
                $statement->execute(array($category['id']));
                while ($item = $statement->fetch()) 
                {
                    echo '<div class="col-md-6 col-lg-4">
                            <div class="img-thumbnail">
                                <img src="images/' . $item['image'] . '" class="img-fluid" alt="...">
                                <div class="price">' . number_format($item['price'], 2, '.', '') . ' €</div>
                                <div class="caption">
                                    <h4>' . $item['name'] . '</h4>
                                    <p>' . $item['description'] . '</p>
                                    <a href="#" class="btn btn-order" role="button"><span class="bi-cart-fill"></span> Commander</a>
                                </div>
                            </div>
                        </div>';
                }

                echo    '</div>
                    </div>';
            }
            Database::disconnect();
            echo  '</div>';

        ?>
    </div>
    <div class="theme-color fixed">
        <div class="teal"></div>
        <div class="red"></div>
        <div class="green"></div>
        <div class="blue"></div>
        <div class="black"></div>
        <div class="yellow"></div>
        <div class="orange"></div>
        <div class="grey"></div>
        <div class="purple"></div>
        <div class="magenta"></div>
        <div class="brown"></div>
        <div class="pink"></div>
    </div>
</body>
<script src="js/theme.js"></script>

</html>