<?php

    require_once 'libs/RedBean/rb-mysql.php';
    require_once 'controllers/dbConnect.php';

    session_start();

?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Гостевая книга</title>
        <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
    <div id="wrapper">
        <h1>Гостевая книга</h1>
        <?php

            $allRecords = R::getAll('SELECT * FROM records');
            $length = count($allRecords);

            for ($i = $length - 1; $i >= 0; $i--) {

                $name = $allRecords[$i]['name'];
                $reviews = $allRecords[$i]['reviews'];
                $testDate = $allRecords[$i]['date'];
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $testDate)
                    ->format('d.m.Y H:i:s');

                echo "<div class='note'>
    
                            <p>
                                <span class='date'>$date</span>
                                <span class='name'>$name</span> 
                            </p>
                            
                            <p>$reviews</p>
                            
                        </div>";

            }

            switch (true) {

                case $_SESSION['error']:
                    echo "<div class='info alert alert-danger'>" .
                        $_SESSION['error'] . "</div>";
                    break;

                case $_SESSION['success']:
                    echo "<div class='info alert alert-success'>" .
                        $_SESSION['success'] . "</div>";
                    $_SESSION = [];
                    break;

            }
        ?>
        <div id="form">
            <form action="controllers/RecordsController.php" method="POST">
                <p>
                    <label>
                        <input class="form-control" placeholder="Ваше имя" name="name"
                               value="<?php echo @$_SESSION['insert_name'] ?>">
                    </label>
                </p>
                <p>
                    <label style="width: 100%">
                        <textarea class="form-control" placeholder="Ваш отзыв"
                                  name="reviews"><?php echo @$_SESSION['insert_reviews'] ?></textarea>
                    </label>
                </p>
                <p><input type="submit" class="btn btn-info btn-block" value="Сохранить"></p>
            </form>
        </div>
    </div>
    </body>
    </html>

<?php

    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

?>