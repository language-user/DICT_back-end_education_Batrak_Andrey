<?php
// TODO 1: PREPARING ENVIRONMENT: 1) session 2) functions
session_start();

function write($data, $filename) {
    $jsonString = json_encode($data);
    $fileStream = fopen ($filename , 'a');
    fwrite ( $fileStream, $jsonString ."\n");
    fclose ($fileStream );
}

function format($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

function read($filename) {
    $comments = [];
    if( file_exists ($filename)) {
        $fileStream = fopen ( $filename , "r");

        while (! feof ($fileStream )) {
            $jsonString = fgets ($fileStream);
            $array = json_decode ( $jsonString , true);
            if ( empty ($array)) break ;
            $comments[$array['name']] = $array['text'];
        }
        fclose ($fileStream );
    }
    return $comments;
}

// TODO 2: ROUTING

// TODO 3: CODE by REQUEST METHODS (ACTIONS) GET, POST, etc. (handle data from request): 1) validate 2) working with data source 3) transforming data
$guestbook = "guestbook.csv";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $name = $text = "";

    if (!empty($_POST["email"]) && !empty($_POST["name"]) && !empty($_POST["text"])) {
        $email = format($_POST["email"]);
        $name = format($_POST["name"]);
        $text = format($_POST["text"]);
        $record = ['name' => $name, 'email' => $email, 'text' => $text];
        write($record, $guestbook);
    }
    else {
        echo "<p>Заповніть всі поля!</p>";
    }
}


//TODO 4: RENDER: 1) view (html) 2) data (from php)

?>

<!DOCTYPE html>
<html lang="">

<?php require_once 'sectionHead.php' ?>

<body>

<div class="container">

    <!-- navbar menu -->
    <?php require_once 'sectionNavbar.php' ?>
    <br>

    <!-- guestbook section -->
    <div class="card card-primary">
        <div class="card-header bg-primary text-light">
            GuestBook form
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-6">

                    <!-- TODO: create guestBook html form   -->
                    <form action="" method="POST">
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email"><br>
                        <label for="name">Name:</label><br>
                        <input type="text" id="name" name="name"><br>
                        <label for="text">Text:</label><br>
                        <textarea id="text" name="text"></textarea><br>
                        <input type="submit" value="Відправити">
                    </form>

                </div>
            </div>

        </div>
    </div>

    <br>

    <div class="card card-primary">
        <div class="card-header bg-body-secondary text-dark">
            Сomments
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">

                    <!-- TODO: render guestBook comments   -->
                    <?php
                    $data = read($guestbook);
                    foreach ($data as $name => $comment) {
                        echo "<p>".$name.":"."<br>".$comment."</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>