
<?php $title = '404 '; ?>
<section id="section_404">
<br>
<table border=0 width=60% align=center>
<tr>
<td align=left>
<pre>
<div class="section_404"><img src="public/images/404.jpg"></div>
<?=
 '<p class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i>  ERREUR <i class="fas fa-exclamation-triangle"></i><br/>' .$errorMessage. '</p>';
?>
<div class="bouton_404"><a href="index.php?action=listPosts">Retour à l'Accueil</a></div> 
<br>
</div> 
</pre>
</td>
</tr>
</table>
</section>
<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
<?php require('views/frontend/footerView.php');?>