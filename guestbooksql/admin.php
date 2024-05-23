<?php

session_start();

if (empty($_SESSION['auth'])) {
    header('Location: /index.php');
    die;
}
?>

<!DOCTYPE html>
<html>

<?php require_once 'sectionHead.php' ?>

<body>

<div class="container">

    <?php require_once 'sectionNavbar.php' ?>
    <br>

    <div class="card card-primary">
        <div class="card-header bg-warning text-light">
            Admin
        </div>
        <div class="card-body">
        </div>
    </div>
</div>

</body>
</html>
