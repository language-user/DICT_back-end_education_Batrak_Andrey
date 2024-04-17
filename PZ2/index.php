<?php
if(isset($_GET["search"])) {
    $search = htmlspecialchars($_GET["search"]);
    $apiKey = "AIzaSyDnxJRNs6V4gyQf1Lw8w9sLAG3GsIEwdpY";
    $cx = "06305a83c3dc64a9c";
    $url = "https://www.googleapis.com/customsearch/v1?key=$apiKey&cx=$cx&q=$search";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resultJson = curl_exec($ch);
    curl_close($ch);

    $items = json_decode($resultJson, true)["items"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h2>My sites</h2>
<form method="GET" action="/index.php">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" value=""><br><br>
    <input type="submit" value="Submit">
</ form >
<?php

if(!empty($items)) {
    foreach ($items as $item) {
        echo "<p>".$item['title']."</p>";
        echo "<a href='".$item['link']."'>".$item['link']."</a>";
        echo "<br>";
        echo $item['htmlTitle'];
    }
}
?>
</body>
</html>