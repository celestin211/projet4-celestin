<?php
/****************************************VIEWS/FRONTEND/SUBSCRIBEVIEW.PHP****************************************/

?>
<?php $title = 'INSCRIPTION'; ?>
<?php ob_start(); ?>
	<section id="secondSideDeco">
			<article id="rules">
				<h4 class="subInfo">Avant de continuer..</h4>
					<p> Remplissez le formulaire  pour rejoindre notre communauté! </br>
					Devenez membre et profiter de contenus exclusifs.
					Paratger vos impressions avec les autres utilisateurs, en postant des messages sur les chapitres postés par l'auteur.  </br></br>

					<i>En remplissant, et acceptant l'envoi du formulaire vous acceptez l'utilisation des cookies.</br>
					Les informations renseignées ne seront utilisées que sur ce site.
					</p>
					<p id="mentions">Projet réalisé dans le cadre de la formation OpenClassroom: Développeur Web Junior.</p></i>
			</article>

        	<div id="subBlock">
                <section class="formulaires">
                    <form  action="index.php?action=register" method="post">
                        <h1 class="inscrit">INSCRIPTION
                        </h1>
                            <label for="username" >Choisir nom d'utilisateur
                            </label>
                                <input type="text" id="username" name="username" class="form-control" placeholder="Nom d'utilisateur"  autofocus="">
                                     <label for="pass" >Choisir mot de passe
                                     </label>
                                        <input type="password" id="pass" name="pass" class="form-control" placeholder="Mot de passe" >
                                            <label for="re_pass" >Confirmer mot de passe
                                            </label>
                            <input type="password" id="re_pass" name="re_pass" class="form-control" placeholder="Mot de passe" >
                    
                            <input id="validation" type="submit" name="submit" value="S'inscrire">
                            <?php
                            if(isset($errorMessage))
                                {
                                echo $errorMessage;
                                }
                             ?>
                        <div>
                                <a href="index.php?action=login"><p>Déjà enregistré ?</p></a>
                         </div>
                        <p class="mt-5 mb-3 text-muted">© 2018-2019</p>
                    </form>
            </section>
            </div>
	</section>	
<?php $content = ob_get_clean(); ?>
<?php require('views/frontend/template.php'); ?>
<?php require('views/frontend/footerView.php');?>