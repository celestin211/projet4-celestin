<?php
session_start();
?>
<?php $title = 'CONNEXION';?>
<?php ob_start();?>
<section id="secondSideDec">
            <div id="subBlock">
                <section class="formulaires">
			        <h1 class="inscrit">CONNEXION</h1>
                    <form class="form-signin" action="index.php?action=connect" method="post">
						<label name="login"> Nom utilisateur:<input type="text" name="login" id="pseudoMember" required></label>
						<label name="pass">Mot de passe:<input type="password" name="pass" id="passeMember" required /></label>
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
                </section>
            </div>
</section>
    <?php $content = ob_get_clean(); ?>
<?php require('views/frontend/template.php'); ?>
<?php require('views/frontend/footerView.php');?>

