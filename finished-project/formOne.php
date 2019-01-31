<?php
/* Database connection settings */
include 'config.php';
include './securimage/securimage.php';
session_start();
$_SESSION['error'][0] = $_SESSION['error'][1] = $_SESSION['error'][2] = 0;
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="ie=edge" http-equiv="X-UA-Compatible"/>
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="./animate.css" rel="stylesheet"/>
    <link href="./style.css" rel="stylesheet"/>
  </head>

  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm"></div>
        <div class="col-sm d-flex justify-content-center align-items-center animated fadeInDown">
          <form method="post">
            <div class="form-group">
              <label for="inputName">Name</label>
              <input id="inputName" class="form-control" placeholder="Enter name" name="username" value="<?php if (isset($_POST['username'])) {
    echo $_POST['username'];
} ?>" />

            </div>
            <div class="form-group">
              <label for="inputEmail">Email address</label>
              <input aria-describedby="emailHelp" class="form-control" id="inputEmail" placeholder="Enter email" type="email" name="email" value="<?php if (isset($_POST['email'])) {
    echo $_POST['email'];
} ?>"/>
              <small class="form-text text-muted" id="emailHelp">We'll never share your email with anyone else.</small >
            </div>
            
              
            <!-- captcha -->
              <label for="captcha">Captcha</label>
             
              
            <div class="d-flex justify-content-center">
              <img id="captcha" src="./securimage/securimage_show.php" alt="CAPTCHA Image" />
            </div>
            <br>
            
            <div class="d-flex justify-content-center">
              <input id="captcha"type="text" name="captcha_code" size="10" maxlength="6" />
            </div>
            <div class="d-flex justify-content-center">
              <a href="#" onclick="document.getElementById('captcha').src = './securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
            </div> 
            <br>
            
            <!-- submit button -->
            <a href="javascript:$('form').submit()">
              <div class="btn d-flex justify-content-center">
                <span>S U B M I T</span>
              </div>
            </a>
          </form>
        </div>
        <div class="col-sm"></div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="./lottie.js"></script>
    <script src="./anime-master%205/lib/anime.min.js"></script>
    <script></script>
  </body>
</html>

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
                    header('Location: ./playlist.php');
                }
            } else { // User exists
                $_SESSION['gebruikernaam'] = $username;
                $_SESSION['loggedin'] = true;
                $_SESSION['exists'] = true;
                $_SESSION['email'] = $email;
                header('Location: ./playlist.php');
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
