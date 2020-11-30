<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?= $title ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="footer, address, phone, icons" />
<meta name="description" content="Découvert le nouveau roman de Jean Forteroche, 'Billet simple pour Alaska'.(Projet Openclassroom)">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<meta name="keywords" content="Billet simple pour l'Alaska, Jean Forteroche, Roman, Livre, En Ligne, nouveautées, Actulitée, Auteur" />
<link href="public/css/styles.css" rel="stylesheet" />
<link href="public/css/menu.css" rel="stylesheet" />
<link href="public/css/stylesA.css" rel="stylesheet" />
<link href="public/css/stylesResponsiv.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
<!--POLICES-->
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
<script src="view/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="view/tinymce/js/tinymce/scroll.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="js/scroll.js"></script>
<script type="text/javascript" src="public/js/bootstrap.min.js"></script>

<!-- Javascript de Bootstrap -->

<script>
tinymce.init({ 
selector:'textarea',
height:'250px'
});
</script>

</script>
<title>Billet simple pour l'Alaska, par JF</title>
</head>
<body>

<header id ="header_Home">
	<div id="headR_Home">		
		<h1><a href="index.php">"Billet simple pour l'Alaska"</a></h1>
	</div>

	<!--nav_bar-->	
	<div id="nav_Log">
		<nav id = "borderTop">
			<div id ="menuToggle">
				<input type="checkbox">
				<span></span>
				<span></span>
				<span></span>
				<ul id ="menu">
						<li>
							<a href="index.php?action=login">Connexion</a>
						</li>
						<li>
							<a href="index.php?action=subscribe">Inscription</a>
						</li>
						<li>
							<a href="index.php?action=listPosts">Les Chapitres</a>
						</li>
					<li>
						<a href="index.php?action=connected">Admin</a>
					 </li>
					
				</ul>

			</div>
		</nav>
			<?php
				if (isset($_SESSION['loginSession'])){//*on récupère le pseudo de l'utilisateur*//
					echo "<p> Bienvenue ".$_SESSION['loginSession']."<br/><a href='index.php?action=disconnect'>Déconnexion</a><p>";
				}
			?>
	</div>
</header>
<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
<?= $content ?>
</body>
</html>