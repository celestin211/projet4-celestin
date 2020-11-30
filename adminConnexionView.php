<?php
/****************************************VIEWS/FRONTEND/ADMINCREATEVIEW.PHP****************************************/

?>

<?php
// Vérifie si l'administrateur est déjà en ligne. Si c'est le cas il est redirigé vers l'espace admin
if (isset($_SESSION['loginSession']) && ($_SESSION['loginSession']=="admin")) {
    header('Location: index.php?action=admin');
}

?>

<?php 
            if (isset($_GET['loginSession']) && $_GET['loginSession'] === 'admin') {
                echo '<p class="msg_confirm"> Mauvais identifiant ou mot de passe.</p>';
            }

            if (isset($_GET['loginSession']) && $_GET['loginSession'] === 'disconnect') {
                echo '<p class="msg_confirm">Vous êtes déconnecté.</p>';
            }
        ?>
<!--AdminView-->
<?php $title = 'ADMINISTRATEUR | Jean FORTEROCHE';?>
<?php ob_start(); ?>
         
            <section id="secondSideDec">
            <div id="subBlock">
                <section class="formulaires">
                <form action="index.php?action=auth" method="post">
			        <h1 class="inscrit">ADMINISTRATEUR</h1>
						<label name="pseudo"> Nom utilisateur:<input type="text" name="pseudo" id="pseudoMember" required></label>
						<label name="mdp"> Mot de passe:<input type="password" name="mdp" id="passeMember" required /></label>
                            <input id="validation" type="submit" name="submit" value="Se connecter">
					</form>
                    <?php
                    if(isset($succesMessage))
                    {
                        echo $succesMessage;
                    }
                    ?>
                    <?php
                    if(isset($errorMessage))
                    {
                        echo $errorMessage;
                    }
                    ?>      
            </div>  
</section>
<?php $content = ob_get_clean(); ?>
<?php require('views/frontend/template.php'); ?>
<?php require('views/frontend/footerView.php');?>
