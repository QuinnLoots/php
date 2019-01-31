<?php
/* Database connection settings */
include 'config.php';

session_start();

if (isset($_POST['adminname']) && isset($_POST['password'])) {
    $inputusername = $mysqli->real_escape_string($_POST['adminname']);
    $inputpassword = $mysqli->real_escape_string($_POST['password']);
} else {
    header('Location: admin.php');
}
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
    if (password_verify($inputpassword, $pass)) {
        $isLoggedIn = true;
        $data = [];
    } else {
        header('Location: admin.php');
    }

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

  <form method="post">
<div class="container-fluid">
      <div class="row">
        <div class="col-sm"></div>
            
            <div class="col-sm d-flex flex-column justify-content-center align-items-center animated fadeInDown">
            <div class="mb-3">
            <h3>Overzicht liedjes en boodschappen</h3>
            </div>
<?php


       if (isset($isLoggedIn) && $isLoggedIn == true) {
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
               }
               echo '</table>';

               echo'<br>';
               // Display the data.

               // Close the prepared statement.
               $stmt->close();
               //print_r($data);
           }
           echo "<button type='submit' name='savesongs' class='button button-block' name='songcsv'>Download liedjes</button>";
           echo'<br>';
           if ($stmt = $mysqli->prepare('SELECT id,boodschap,email FROM boodschap')) {
               // Execute the statement.

               $stmt->execute();

               // Get the variables from the query.
               $stmt->bind_result($id, $boodschap, $email);

               echo    "<table border='1'> 
                         <tr> 
                         <th>id</th>
                         <th>boodschap</th>
                         <th>email</th>
                         </tr>";

               // Fetch the data.
               while ($stmt->fetch()) {
                   echo '<tr>';
                   echo '<td>'.$id.'</td>';
                   echo '<td>'.$boodschap.'</td>';
                   echo '<td>'.$email.'</td>';
                   echo '</tr>';
               }
               echo '</table>';

               echo'<br>';
               // Display the data.

               // Close the prepared statement.
               $stmt->close();
               //print_r($data);
           }
           echo "<button type='submit' name='saveboodschap' class='button button-block' name='boodschapcsv'>Download boodschappen</button>";
           echo'</div>';
       }

    if (isset($_POST['savesongs'])) {
        header('Location: tocsv.php');
    } elseif (isset($_POST['saveboodschap'])) {
        header('Location: downloadboodschap.php');
        // Save-button was clicked
    }
?>
 <div class="col-sm"></div>
            </div>
           
        </div>
    </div>
</div>
</form>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="./lottie.js"></script>
    <script src="./anime-master%205/lib/anime.min.js"></script>
    <script></script>
  </body>
</html>
