<?php
/* Database connection settings */
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
    header('Location: login.php');
}
include 'config.php';

$username = $_SESSION['gebruikernaam'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>showsongs</title>
</head>
<body>
    <h1>Welkom, <?php echo $username; ?>  </h1>
    <ul>
    <?php
        $email = $_SESSION['email'];
        //echo $email;
    if ($stmt = $mysqli->prepare('SELECT song, artist FROM songs WHERE email=?')) {
        // Bind a variable to the parameter as a string.
        $stmt->bind_param('s', $email);

        // Execute the statement.
        //$stmt->execute();
        $stmt->execute();

        // Get the variables from the query.
        $stmt->bind_result($song, $artist);

        // Fetch the data.
        //$stmt->fetch();

        while ($stmt->fetch()) {
            echo '<li>'.$song.', '.$artist.'</li>';
            // echo/return $date column
        }
        if ($song == '') {
            header('Location: addsongs.php');
        }
        // Close the prepared statement.
        $stmt->close();
    } else {
        echo 'error';
    }

    if ($stmt = $mysqli->prepare('SELECT boodschap FROM boodschap WHERE email=?')) {
        // Bind a variable to the parameter as a string.
        $stmt->bind_param('s', $email);

        // Execute the statement.
        //$stmt->execute();
        $stmt->execute();

        // Get the variables from the query.
        $stmt->bind_result($boodschap);

        // Fetch the data.
        //$stmt->fetch();

        while ($stmt->fetch()) {
            echo '<li>'.'boodschap: '.$boodschap.'</li>';
            // echo/return $date column
        }
        // Close the prepared statement.
        $stmt->close();
        $_SESSION['loggedin'] = false;
    } else {
        echo 'error';
    }

    ?>
    </ul>
</body>
</html>