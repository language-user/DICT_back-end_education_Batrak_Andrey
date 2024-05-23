<?php

session_start();

$aConfig = require_once 'config.php';
$db = mysqli_connect ($aConfig['host'],
    $aConfig ['user'],
    $aConfig ['pass'],
    $aConfig ['name']
);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (!empty($_SESSION['auth'])) {
    header('Location: /admin.php');
    die;
}


$infoMessage = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {

    $email = $db->real_escape_string($_POST['email']);
    $password = $db->real_escape_string($_POST['password']);

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['auth'] = true;
        header("Location: admin.php");
        die;
    } else {
        $infoMessage = "Такого пользователя не существует. Перейдите на страницу регистрации. ";
        $infoMessage .= "<a href='register.php'>Страница регистрации</a>";
    }
} elseif (!empty($_POST)) {
    $infoMessage = 'Заполните форму авторизации!';
}

$db->close();
?>

<!DOCTYPE html>
<html>

<?php require_once 'sectionHead.php' ?>

<body>

<div class="container">

    <?php require_once 'sectionNavbar.php' ?>

    <br>

    <div class="card card-primary">
        <div class="card-header bg-primary text-light">
            Login form
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email"/>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password"/>
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="form"/>
                </div>
            </form>

            <?php
            if ($infoMessage) {
                echo '<hr/>';
                echo "<span style='color:red'>$infoMessage</span>";
            }
            ?>

        </div>
    </div>
</div>

</body>
</html>
