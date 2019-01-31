<?php 
    session_start();
    include 'config.php';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
    header('Location: formOne.php');
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
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
  </head>

  <body>
  <form method="post" action="process.php">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm"></div>
        
        
        <!-- BIRTHDAY BOX -->
        <div class="col-sm d-flex flex-column">
       
          <h3>Vul hieronder je 3 favoriete liedjes in</h3>
          
          <label class="field a-field a-field_a1 page__field dd">
            <input id="artist1" name="artist1" class="field__input a-field__input" placeholder="bv. Beyonce" value="<?php if (isset($songs[0])) {
    echo $artists[0];
} ?>" required>

            <span class="a-field__label-wrap"><span class="a-field__label">Artist name</span></span></label>
          <label class="field a-field a-field_a2 page__field aa">
            <input id="song1" name="song1" class="field__input a-field__input" placeholder="bv. Crazy in love" value="<?php if (isset($songs[0])) {
    echo $songs[0];
} ?>" required>
            <span class="a-field__label-wrap"><span class="a-field__label">Song name</span></span></label>
            <label class="fault"><?php if ($_SESSION['error'][0] == 1) {
    echo 'Liedje staat al in de lijst';
} ?></label>
          <label class="field a-field a-field_a1 page__field">
            <input id="artist2" name="artist2" class="field__input a-field__input" placeholder="bv. Madonna" value="<?php if (isset($songs[0])) {
    echo $artists[1];
} ?>" required>
            <span class="a-field__label-wrap"><span class="a-field__label">Artist name</span></span></label>
          <label class="field a-field a-field_a2 page__field bb">
            <input id="song2" name="song2" class="field__input a-field__input" placeholder="bv. Celebration" value="<?php if (isset($songs[0])) {
    echo $songs[1];
} ?>" required>
            <span class="a-field__label-wrap"><span class="a-field__label">Song name</span></span></label>
            <label class="fault"><?php if ($_SESSION['error'][1] == 1) {
    echo 'Liedje staat al in de lijst';
} ?></label>

          <label class="field a-field a-field_a1 page__field">
            <input id="artist3" name="artist3" class="field__input a-field__input" placeholder="bv. Ed Sheeran" value="<?php if (isset($songs[0])) {
    echo $artists[2];
} ?>" required>
            <span class="a-field__label-wrap"><span class="a-field__label">Artist name</span></span></label>
          <label class="field a-field a-field_a2 page__field cc">
            <input id="song3" name="song3" class="field__input a-field__input" placeholder="bv. Perfect" value="<?php if (isset($songs[0])) {
    echo $songs[2];
} ?>" required>
            <span class="a-field__label-wrap"><span class="a-field__label">Song name</span></span></label>
            <label class="fault"><?php if ($_SESSION['error'][2] == 1) {
    echo 'Liedje staat al in de lijst';
} ?></label>

          <!-- boodschap input -->
          <label class="field a-field a-field_a2 page__field cc">
            <input id="boodschap" name="boodschap" class="field__input a-field__input" placeholder="bv. Gelukkige verjaardag!" value="<?php if (isset($boodschap)) {
    echo $boodschap;
} ?>" required>
            <span class="a-field__label-wrap"><span class="a-field__label">Boodschap</span></span></label>

          <!-- submit button -->
          <a href="javascript: testForm()">
            <div class="btn d-flex justify-content-center">
              <span>S U B M I T</span>
            </div>
          </a>
        </div>
        <div class="col-sm"></div>
      </div>
    </div>
   
</form>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="./lottie.js"></script>
    <script src="./anime-master%205/lib/anime.min.js"></script>
    <script>
      function testForm(){
        if($("#song1").val()==""||$("#song2").val()==""||$("#song3").val()==""||$("#artist1").val()==""||$("#artist2").val()==""||$("#artist3").val()==""||$("#boodschap").val()==""){
          alert("gelieve alle velden in te vullen");
        }else{
          $( "form" ).submit();
        }
      }
    </script>
  </body>

</html>

