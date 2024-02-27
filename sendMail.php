<?php
$subject = 'New Email';

echo '----------' . "\n";
echo $subject . "\n";
echo '----------' . "\n";

$firstName = 'Andrey';
$text1 = "firstName : {$firstName}" . "\n";

$lastName = 'Batrak';
$text2 = "lastName : {$lastName}" . "\n";

$location = 'Kharkiv, Ukraine';
$text3 = "location : {$location}" . "\n";

$occupaion = 'student';
$text4 = "firstName : {$occupaion}" . "\n";

$date = '18.09.2002';
$text5 = "date : {$date}" . "\n";
$text6 = "What's up, bro";
$message = $text1 . $text2 . $text3. $text4. $text5. $text6;
echo $message;
$headers = 'From: a.y.batrak@student.khai.edu';
mail('frostbitefff@gmail.com', $subject, $message, $headers);