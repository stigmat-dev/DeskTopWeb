<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" />
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/center.css" />
    <title>АСПОЗ | Регистрация</title>
</head>

<body>
    <!------------------ Форма регистрации ---------------------->

    <div class="form-group">
        <img class="myLogo" src="../img/logo.png" alt="">
        <h6 class="slogan">Автоматизированная Система Подачи и Обработки Заявок</h6>
        <h5 class="slogan2" title="Систематика (наука) — научный метод, заключающийся в упорядочении, 
    структурировании и нотификации больших совокупностей объектов 
    некоторой сферы реальности или отрасли деятельности">«СИСТЕМАТИКА»</h5>
        <br>
        <form class="myAuth" action="signup.php" method="post">
            <h2>Регистрация</h2>
            <p></p>
            <input class="form-control" name="full_name" type="text" placeholder="ФИО" />
            <p></p>
            <input class="form-control" name="login" type="text" placeholder="Логин" />
            <p></p>
            <input class="form-control" name="password" type="password" placeholder="Пароль" />
            <p></p>
            <input class="form-control" name="password_confirm" type="password" placeholder="Подтвердите пароль" />
            <p></p>
            <button type="submit" name="reg_submit" class="form-control btn btn-primary enterBtn">Регистрация</button>
            <p></p>
            <p>Есть аккаунт? <a style="text-decoration: none;" class="reg_link" href="../">Войти</a></p>
            <?php
            if (@$_SESSION['message']) {
                echo '<p class="msg">' . @$_SESSION['message'] . '</p>';
            }
            unset($_SESSION['message']);
            ?>

        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="../js/script.js"></script>
</body>

</html>