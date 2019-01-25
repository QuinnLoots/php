
<?php
 session_start();
include 'config.php';
$songs = array($mysqli->real_escape_string($_POST['song1']), $mysqli->real_escape_string($_POST['song2']), $mysqli->real_escape_string($_POST['song3']));
$artists = array($mysqli->real_escape_string($_POST['artist1']), $mysqli->real_escape_string($_POST['artist2']), $mysqli->real_escape_string($_POST['artist3']));
$boodschap = $mysqli->real_escape_string($_POST['boodschap']);
$email = $mysqli->real_escape_string($_SESSION['email']);
$username = $mysqli->real_escape_string($_SESSION['gebruikernaam']);

    for ($x = 0; $x < 3; ++$x) {
        if ($stmt1 = $mysqli->prepare('SELECT count(1) FROM songs WHERE song = ? AND artist=?')) {
            $stmt1->bind_param('ss', $songs[$x], $artists[$x]);
            $stmt1->execute();
            $stmt1->bind_result($found);
            $stmt1->fetch();
            if ($found) {
                $_SESSION['error'][$x] = 1;
            } else {
                $_SESSION['error'][$x] = 0;
            }
            $stmt1->close();
        }
    }

 if ($_SESSION['exists'] == true) {
     //is user bestaande: JA

     for ($j = 0; $j < 3; ++$j) {
         if ($_SESSION['error'][$j] == 0) {
             $_SESSION['error'][$j] = 2;
             // if (check_song($j) == '') {
             if ($stmt2 = $mysqli->prepare('UPDATE songs SET song = ?, artist = ?  WHERE email = ? AND songid=?')) {
                 $stmt2->bind_param('ssss', $songs[$j], $artists[$j], $email, $j);
                 if ($stmt2->execute()) {
                     echo 'song updated, ';
                 } else {
                     echo 'song not updated, ';
                 }
                 $stmt2->close();
             }
             //   }
         }
     }
     // if (check_boodschap() == '') {
     if ($stmt3 = $mysqli->prepare('UPDATE boodschap SET boodschap = ? WHERE email = ?')) {
         $stmt3->bind_param('ss', $boodschap, $email);
         if ($stmt3->execute()) {
             echo 'boodschap updated, ';
         } else {
             echo 'boodschap not updated, ';
         }
         $stmt3->close();
         //echo 'update complete';
     }

     header('Location: addsongs.php');
 //header('Refresh:0');
 } elseif ($_SESSION['exists'] == false) {
     //is user bestaande: NEE
     //is er minstens één liedje bestaande (geen insert maar redirect)
     if (in_array(true, $_SESSION['error'])) {
         header('Location: addsongs.php');
     }

     for ($i = 0; $i < 3; ++$i) {
         // if (check_song($i) == '') {
         if ($stmt4 = $mysqli->prepare('INSERT INTO songs (song, artist, email,songid) VALUES (?, ?, ?,?)')) {
             // Bind the variables to the parameter as strings.
             $stmt4->bind_param('ssss', $songs[$i], $artists[$i], $email, $i);

             // Execute the statement.
             //$stmt->execute();
             if ($stmt4->execute()) {
                 echo 'song added, ';
             } else {
                 echo 'song not added, ';
             }

             // Close the prepared statement.
             $stmt4->close();
         }
         //  }
     }
     // if (check_boodschap() == '') {
     if ($stmt5 = $mysqli->prepare('INSERT INTO boodschap (boodschap, email) VALUES (?, ?)')) {
         // Bind the variables to the parameter as strings.
         $stmt5->bind_param('ss', $boodschap, $email);

         // Execute the statement.
         //$stmt->execute();
         if ($stmt5->execute()) {
             echo 'boodschap added, ';
         } else {
             echo 'boodschap not added, ';
         }

         // Close the prepared statement.
         $stmt5->close();
     }
     // }

     $_SESSION['exists'] = true;
     header('Location: addsongs.php');
 }

?>