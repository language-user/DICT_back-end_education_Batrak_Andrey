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


    $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $infoMessage = "Такой пользователь уже существует! Перейдите на страницу входа. ";
        $infoMessage .= "<a href='/login.php'>Страница входа</a>";
    } else {

        $stmt = $db->prepare("INSERT INTO users (email, password, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();

        header('Location: /login.php');
        die;
    }

    $stmt->close();

} elseif (!empty($_POST)) {
    $infoMessage = 'Заполните форму регистрации!';
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
        <div class="card-header bg-success text-light">
            Register form
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email" required/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" required/>
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="formRegister"/>
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
