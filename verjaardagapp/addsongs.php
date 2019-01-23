<?php 
    session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
    header('Location: login.php');
}
include 'config.php';
$username = $mysqli->real_escape_string($_SESSION['gebruikernaam']);
$email = $mysqli->real_escape_string($_SESSION['email']);
$songs = [];
$artists = [];
if ($_SESSION['exists'] == true) {
    for ($x = 0; $x < 3; ++$x) {
        if ($stmt = $mysqli->prepare('SELECT song, artist FROM songs WHERE email=?')) {
            // Bind a variable to the parameter as a string.
            $stmt->bind_param('s', $email);

            // Execute the statement.
            $stmt->execute();

            // Get the variables from the query.
            $stmt->bind_result($song, $artist);

            // Fetch the data.
            $stmt->fetch();
            array_push($songs, $song);
            array_push($artists, $artist);
            // Display the data.
            //echo("pass: ".$pass);

            // Close the prepared statement.
            $stmt->close();
        }
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
<form method="post" >    
    <div class="container">
        <div class="left">
            Song name 1:<br>
            <input type="text" name="song1" value="<?php if (isset($songs[0])) {
    echo $songs[0];
} ?>"><br>
            Song name 2:<br>
            <input type="text" name="song2" value="<?php if (isset($songs[1])) {
    echo $songs[1];
} ?>"><br>
            Song name 3:<br>
            <input type="text" name="song3" value="<?php if (isset($songs[2])) {
    echo $songs[2];
} ?>"><br>
        </div>
        <div class="right">
            Artist 1:<br>
            <input type="text" name="artist1" value="<?php if (isset($artists[0])) {
    echo $artists[0];
} ?>"><br>
            Artist 2:<br>
            <input type="text" name="artist2" value="<?php if (isset($artists[1])) {
    echo $artists[1];
} ?>"><br>
            Artist 3:<br>
            <input type="text" name="artist3" value="<?php if (isset($artists[2])) {
    echo $artists[2];
} ?>"><br>

        </div>
        <div class="middle">
            Boodschap:<br>
            <textarea rows="4" cols="50" class="fullwidth" name="boodschap"><?php if (isset($boodschap)) {
    echo $boodschap;
} ?></textarea><br><br>
            <button type="button" class="button button-block" name="back" id="back">Back</button>
            <button type="submit" class="button button-block" name="next" >Save</button>
        </div>
    </div>
</form>
<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $songs = array($mysqli->real_escape_string($_POST['song1']), $mysqli->real_escape_string($_POST['song2']), $mysqli->real_escape_string($_POST['song3']));
    $artists = array($mysqli->real_escape_string($_POST['artist1']), $mysqli->real_escape_string($_POST['artist2']), $mysqli->real_escape_string($_POST['artist3']));
    $boodschap = $mysqli->real_escape_string($_POST['boodschap']);

    if (!in_array('', $songs) && !in_array('', $artists) && $boodschap != '') {
        $oldsongs = [];
        $oldartists = [];
        if ($_SESSION['exists'] == false) {
            //print_r ($songs);

            for ($i = 0; $i < 3; ++$i) {
                if ($stmt = $mysqli->prepare('SELECT song FROM songs WHERE song=? AND artist=?')) {
                    // Bind a variable to the parameter as a string.
                    $stmt->bind_param('ss', $songs[$i], $artists[$i]);

                    // Execute the statement.
                    $stmt->execute();

                    // Get the variables from the query.
                    $stmt->bind_result($pass);

                    // Fetch the data.
                    $stmt->fetch();

                    // Display the data.
                    //echo("pass: ".$pass);

                    // Close the prepared statement.
                    $stmt->close();
                }
                if ($stmt = $mysqli->prepare('SELECT email FROM boodschap WHERE email=?')) {
                    // Bind a variable to the parameter as a string.
                    $stmt->bind_param('s', $email);

                    // Execute the statement.
                    $stmt->execute();

                    // Get the variables from the query.
                    $stmt->bind_result($pass2);

                    // Fetch the data.
                    $stmt->fetch();

                    // Display the data.
                    //echo("pass: ".$pass);

                    // Close the prepared statement.
                    $stmt->close();
                }

                if ($pass == '') {// song doesn't exist
                    // echo("song doesnt exist, ");

                    if ($stmt = $mysqli->prepare('INSERT INTO songs (song, artist, email,songid) VALUES (?, ?, ?,?)')) {
                        // Bind the variables to the parameter as strings.
                        $stmt->bind_param('ssss', $songs[$i], $artists[$i], $email, $i);

                        // Execute the statement.
                        //$stmt->execute();
                        if ($stmt->execute()) {
                            echo 'song added, ';
                        } else {
                            echo 'song not added, ';
                        }

                        // Close the prepared statement.
                        $stmt->close();
                    }
                } else { // Song exists
                //echo("song exists");
                }
            }
            if ($pass2 == '') {
                if ($stmt = $mysqli->prepare('INSERT INTO boodschap (boodschap, email) VALUES (?, ?)')) {
                    // Bind the variables to the parameter as strings.
                    $stmt->bind_param('ss', $boodschap, $email);

                    // Execute the statement.
                    //$stmt->execute();
                    if ($stmt->execute()) {
                        echo 'boodschap added, ';
                    } else {
                        echo 'boodschap not added, ';
                    }

                    // Close the prepared statement.
                    $stmt->close();
                }
                //header('Refresh:0');
            } else {
                echo 'boodschap already exists, ';
            }
            $_SESSION['exists'] = true;
        } else {
            for ($j = 0; $j < 3; ++$j) {
                if ($stmt = $mysqli->prepare('UPDATE songs SET song = ?, artist = ?  WHERE email = ? AND songid=?')) {
                    $stmt->bind_param('ssss', $songs[$j], $artists[$j], $email, $j);
                    if ($stmt->execute()) {
                        echo 'song updated, ';
                    } else {
                        echo 'song not updated, ';
                    }
                    $stmt->close();

                    //echo 'update complete';
                }
            }

            if ($stmt = $mysqli->prepare('UPDATE boodschap SET boodschap = ? WHERE email = ?')) {
                $stmt->bind_param('ss', $boodschap, $email);
                if ($stmt->execute()) {
                    echo 'boodschap updated, ';
                } else {
                    echo 'boodschap not updated, ';
                }
                $stmt->close();
                //echo 'update complete';
            }
            //header('Refresh:0');
        }
    } else {
        echo 'gelieve alle velden in te vullen';
    }
}

?> 
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script>
    $('#back').click(function() {
        location.href = 'index.php';
    });
</script>
</body>
</html>