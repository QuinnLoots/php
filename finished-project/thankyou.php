<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="ie=edge" http-equiv="X-UA-Compatible">
	<title>Document</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm"></div><!-- BIRTHDAY BOX -->
			<div class="col-sm d-flex justify-content-center">
				<h5 class="danku">Dankuwel voor je ingave<br>
				En we zien elkaar terug op zaterdag 4 mei</h5>
				<div class="boxone">
					<div class="boxtwo"></div>
				</div>
			</div>
			<div class="col-sm"></div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js">
	</script> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js">
	</script> 
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js">
	</script> 
	<script src="./lottie.js">
	</script> 
	<script src="./anime-master%205/lib/anime.min.js">
	</script> 
	<script>
	       
	       // birthday box loader
	           var animation = bodymovin.loadAnimation({
	           container: document.querySelector(".boxone"),
	           renderer: 'svg', 
	           loop: true,
	           autoplay: true,
	           path: 'dino.json' 
	       })

	       var animation = bodymovin.loadAnimation({
	           container: document.querySelector(".boxtwo"),
	           renderer: 'svg', 
	           loop: true,
	           autoplay: true,
	           path: 'vuurwerk.json' 
	       })

	       



	</script>
</body>
</html>