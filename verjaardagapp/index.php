<!DOCTYPE html>
<html>
<head>
  <title>welkom</title>
</head>


<body>
    <form method="post">
        <button type="submit" class="button button-block" name="login">login</button>
    </form>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (isset($_POST['login'])) {
                $url = 'login.php';
                header("Location: $url");
        
            }
        }
    ?>
</body>
</html>