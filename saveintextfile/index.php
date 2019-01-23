<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>saveintextfile</title>
</head>
<body>
<form name=”web_form” id=”web_form” method=”post” action=”process-form-data.php”>
        <p><label>Enter name: </label><input type=”text” name=”name” id=”name” /></p>
        <p><label>Enter email: </label><input type=”email” name=”email” id=”email” /></p>
        <p><input type=”submit” name=”s1″ id=”s1″ value=”Submit” /></p>
</form>
</body>
</html>




<?php
$name = $_POST[‘name’];
$email = $_POST[’email’];
$fp = fopen(”data.txt”, “a”)or die("can't open file");;
$savestring = $name . ','. $email . 'n';
fwrite($fp, $savestring);
fclose($fp);
echo '<h1>You data has been saved in a text file!</h1>';
?>