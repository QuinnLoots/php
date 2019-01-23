
<?php
/* Database connection settings */
include 'config.php';
include './securimage/securimage.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <form method="post">
        <p><label>Enter username: </label><input type="text" name="username" id="username" value="<?php if (isset($_POST['username'])) {
    echo $_POST['username'];
} ?>" /></p>
        <p><label>Enter email: </label><input type="email" name="email" id="email" value="<?php if (isset($_POST['email'])) {
    echo $_POST['email'];
} ?>"/></p>
        
        <img id="captcha" src="./securimage/securimage_show.php" alt="CAPTCHA Image" /><br><br> 
        <input type="text" name="captcha_code" size="10" maxlength="6" />
<a href="#" onclick="document.getElementById('captcha').src = './securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
        
        <button type="submit" class="button button-block" name="next">next</button>
        
    </form>

<?php
/* User login process, checks if email exists */

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $securimage = new Securimage();
        $username = $mysqli->real_escape_string($_POST['username']);
        //echo($username);
        $email = $mysqli->real_escape_string($_POST['email']);
        //echo($email);
        if ($username != '' && $email != '' && $securimage->check($_POST['captcha_code']) == true) {
            if ($stmt = $mysqli->prepare('SELECT email FROM user WHERE email=?')) {
                // Bind a variable to the parameter as a string.
                $stmt->bind_param('s', $email);

                // Execute the statement.
                $stmt->execute();

                // Get the variables from the query.
                $stmt->bind_result($pass);

                // Fetch the data.
                $stmt->fetch();

                // Display the data.
                //echo($pass);

                // Close the prepared statement.
                $stmt->close();
            }

            if ($pass == '') {// User doesn't exist
                if ($stmt = $mysqli->prepare('INSERT INTO user (username, email) VALUES (?, ?)')) {
                    // Bind the variables to the parameter as strings.
                    $stmt->bind_param('ss', $username, $email);

                    // Execute the statement.
                    //$stmt->execute();
                    if ($stmt->execute()) {
                        echo 'user added';
                    } else {
                        echo 'user not added';
                    }

                    // Close the prepared statement.
                    $stmt->close();
                    $_SESSION['gebruikernaam'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['loggedin'] = true;
                    $_SESSION['exists'] = false;
                    header('Location: addsongs.php');
                }
            } else { // User exists
                $_SESSION['loggedin'] = true;
                $_SESSION['exists'] = true;
                $_SESSION['email'] = $email;
                header('Location: addsongs.php');
            }
        } else {
            if ($username == '' || $email == '') {
                echo 'gelieve beide velden in te vullen <br>';
            }
            if ($securimage->check($_POST['captcha_code']) == false) {
                echo 'gelieve de juiste code in te typen';
            }
        }
    }

?>    
</body>
</html>





