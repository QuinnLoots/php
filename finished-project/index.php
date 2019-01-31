<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="ie=edge" http-equiv="X-UA-Compatible"/>
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
  </head>

  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm"></div>
        <!-- BIRTHDAY BOX -->
        <div class="col-sm d-flex justify-content-center">
          <div class="box"></div>
        </div>
        <div class="col-sm"></div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="./lottie.js"></script>
    <script src="./anime-master%205/lib/anime.min.js"></script>
    <script>
      // birthday box loader
      setTimeout(function () {
        var animation = bodymovin.loadAnimation({container: document.querySelector(".box"), renderer: "svg", loop: true, autoplay: true, path: "data.json"});

        // birthday box animatie
        anime({targets: ".box", translateX: 800, delay: 3000});
        setTimeout(function () {
          location.href = "./formOne.php";
        }, 3500); //overschakeling naar ander formone pagina
      }, 500);
    </script>
  </body>

</html>
