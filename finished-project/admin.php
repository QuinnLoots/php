<?php
/* Database connection settings */
include 'config.php';
session_start();
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
          <form  method="post" action="showsongs.php">
            <div class="form-group">
              <label for="inputName">Name</label>
              <input id="inputName" class="form-control" placeholder="Enter name" name="adminname" />

            </div>
            <div class="form-group">
              <label for="inputPassword">password</label>
              <input class="form-control" placeholder="Enter password" type="password" name="password"/>
            </div>
            
            
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

