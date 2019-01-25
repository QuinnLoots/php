<?php 
    session_start();
    include 'config.php';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
    header('Location: login.php');
}
$username = $mysqli->real_escape_string($_SESSION['gebruikernaam']);
$email = $mysqli->real_escape_string($_SESSION['email']);
// check if user exists by checking its query
if ($stmt6 = $mysqli->prepare('SELECT count(1) FROM songs WHERE email=?')) {
    $stmt6->bind_param('s', $email);
    $stmt6->execute();
    $stmt6->bind_result($found);
    $stmt6->fetch();
    if ($found) {
        // echo 'true';
        $_SESSION['exists'] = true;
    } else {
        //echo 'false';
        $_SESSION['exists'] = false;
    }
    $stmt6->close();
}
    $songs = [];
    $artists = [];
include 'config.php';

if ($_SESSION['exists'] == true) {
    //echo 'user exists';

    if ($stmt = $mysqli->prepare('SELECT song, artist FROM songs WHERE email=?')) {
        // Bind a variable to the parameter as a string.
        $stmt->bind_param('s', $email);

        // Execute the statement.
        $stmt->execute();

        // Get the variables from the query.
        $stmt->bind_result($song, $artist);

        // Fetch the data.
        while ($stmt->fetch()) {
            array_push($songs, $song);
            array_push($artists, $artist);
        }

        // Display the data.
        //echo("pass: ".$pass);

        // Close the prepared statement.
        $stmt->close();
    }
    if ($stmt = $mysqli->prepare('SELECT boodschap FROM boodschap WHERE email=?')) {
        // Bind a variable to the parameter as a string.
        $stmt->bind_param('s', $email);

        // Execute the statement.
        $stmt->execute();

        // Get the variables from the query.
        $stmt->bind_result($boodschap);

        // Fetch the data.
        $stmt->fetch();

        // Display the data.
        //echo("pass: ".$pass);

        // Close the prepared statement.
        $stmt->close();
    }
    //print_r($songs);
    //print_r($artists);
    //echo $boodschap;
}

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add songs</title>
    <style>
    h1,h2{
        text-align: center;
    }
    .container{
        text-align: center;
        display: grid;
        grid-template-columns: 20% 30% 30% 20%;
        grid-template-rows: auto;
    }

    .left{
        grid-area: 1 / 2 / 1 / 2;
    }
    .right{
        grid-area: 1 / 3 / 1 /3;
    }
    .middle{
        margin-top: 20px;
        grid-area: 2/ 2/ 2 /4;
    }
    .fullwidth{
        width: 100%;
    }

    </style>
</head>
<body>
    <h1>Welkom, <?php echo $username; ?>  </h1>
    <h2>Geef hier uw favoriete top 3 dans/meezingliedjes op</h2>
<form method="post" action="process.php" >    
    <div class="container">
        <div class="left">
            Song name 1:<br>
            <label for="song1"><?php if (isset($_SESSION['error'][0]) && $_SESSION['error'][0] == 1) {
    echo 'song1 already exists';
} ?></label>
            <input type="text" id="song1" name="song1" value="<?php if (isset($songs[0])) {
    echo $songs[0];
} ?>" required>

<br>
            Song name 2:<br>
            <label for="song2"><?php if (isset($_SESSION['error'][1]) && $_SESSION['error'][1] == 1) {
    echo 'song2 already exists';
} ?></label>
            <input type="text" id="song2" name="song2" value="<?php if (isset($songs[1])) {
    echo $songs[1];
} ?>" required>

<br>
            Song name 3:<br>
            <label for="song3"><?php if (isset($_SESSION['error'][2]) && $_SESSION['error'][2] == 1) {
    echo 'song3 already exists';
} ?></label>
            <input type="text" name="song3" value="<?php if (isset($songs[2])) {
    echo $songs[2];
} ?>" required>

<br>
        </div>
        <div class="right">
            Artist 1:<br>
            <input type="text" name="artist1" value="<?php if (isset($artists[0])) {
    echo $artists[0];
} ?>" required><br>
            Artist 2:<br>
            <input type="text" name="artist2" value="<?php if (isset($artists[1])) {
    echo $artists[1];
} ?>" required><br>
            Artist 3:<br>
            <input type="text" name="artist3" value="<?php if (isset($artists[2])) {
    echo $artists[2];
} ?>" required><br>

        </div>
        <div class="middle">
            Boodschap:<br>
            <textarea rows="4" cols="50" class="fullwidth" name="boodschap" required><?php if (isset($boodschap)) {
    echo $boodschap;
} ?></textarea><br><br>
            <button type="button" class="button button-block" name="back" id="back">Back</button>
            <button type="submit" class="button button-block" name="next" >Save</button>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script>
    $('#back').click(function() {
        location.href = 'index.php';
    });
</script>
</body>
</html>