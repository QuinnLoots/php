<?php
session_start();
include 'config.php';
//echo password_hash('passwd', PASSWORD_DEFAULT);
?>
<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>
</head>
<body>
    <form method="post">    
        <p><label>Enter admin username: </label></p>
        <input type="text" name="adminname"><br><br>
        <p><label>Enter admin password: </label></p>
        <input type="password" name="adminpasswd"><br><br>
        <button type="submit" class="button button-block" name="login">login</button>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $inputusername = $mysqli->real_escape_string($_POST['adminname']);
        $inputpassword = $mysqli->real_escape_string($_POST['adminpasswd']);

        if ($stmt = $mysqli->prepare('SELECT password FROM admin WHERE username=?')) {
            // Bind a variable to the parameter as a string.
            $stmt->bind_param('s', $inputusername);

            // Execute the statement.
            $stmt->execute();

            // Get the variables from the query.
            $stmt->bind_result($pass);

            // Fetch the data.
            $stmt->fetch();

            // Close the prepared statement.
            $stmt->close();
        }
        if ($pass != '') {//user exists
            if (password_verify($inputpassword, $pass)) {
                echo 'Password is valid!';
                $data = [];
                if ($stmt = $mysqli->prepare('SELECT id, song, artist, email FROM songs')) {
                    // Execute the statement.

                    $stmt->execute();

                    // Get the variables from the query.
                    $stmt->bind_result($id, $song, $artist, $email);

                    echo    "<table border='1'> 
                            <tr> 
                            <th>id</th>
                            <th>song</th>
                            <th>artist</th>
                            <th>email</th>
                            </tr>";

                    // Fetch the data.
                    while ($stmt->fetch()) {
                        echo '<tr>';
                        echo '<td>'.$id.'</td>';
                        echo '<td>'.$song.'</td>';
                        echo '<td>'.$artist.'</td>';
                        echo '<td>'.$email.'</td>';
                        echo '</tr>';
                        $list = [$id, $song, $artist, $email];
                        array_push($data, $list);
                    }
                    echo '</table>';
                    // Display the data.

                    // Close the prepared statement.
                    $stmt->close();
                    //print_r($data);
                }
                echo "<button type='submit' name='savesongs' class='button button-block' name='songcsv'>Download songs</button>";
                echo "<button type='submit' name='saveboodschap' class='button button-block' name='boodschapcsv'>Download boodschappen</button>";
            } else {
                echo 'Invalid password.';
            }
        }
    }

    ?>
    <?php
    if (isset($_POST['savesongs'])) {
        header('Location: tocsv.php');
    } elseif (isset($_POST['saveboodschap'])) {
        header('Location: downloadboodschap.php');
        // Save-button was clicked
    }
?>
    </form>
</body>
</html>