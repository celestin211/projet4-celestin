
<?php $title = 'Jean FORTEROCHE'; ?>
    <?php ob_start(); ?>
    <section>
	<div id="secondSideDeco">
		<aside id="introChapters">
			<h3 class="chapitre">Chapitre récent:</h3>
			
		</aside>
		
		<article id="seleChap">

                    <?php
                        while ($data = $lastPost->fetch())
                    {
                    ?>
				<div class="thumbnail">
					<div class="panne"></div>
					
					<h5><a href="index.php?action=post&amp;id=<?= $data['id']; ?>"><?= htmlspecialchars($data['title']); ?></a></h5>
					</h5>
						<p class="sumChapters"> <?=substr($data['content'], 0, 500);?> [...]</br></p> 
						Mise en ligne le:<?php echo htmlspecialchars($data['post_date_fr']);?>
                        <a href="index.php?action=post&amp;id=<?= $data['id'] ?>" role="button">Lire</a>
				</div>
				
				<?php
					}
                    $lastPost->closeCursor();
				?>
				
		</article>
	</div>
</section>

        <article id="showComms">
               
                    <h3>Commentaires récents</h3>
                    <?php
                    while ($dataComment = $lastComments->fetch())
                    {
                    ?>
                        <div class="comments-box">
                            <p class="meta">
                                Le <?= $dataComment['comment_date_fr']; ?> 
                                <br/>
                                <span class="homeAuthorComment"><?= htmlspecialchars($dataComment['author']); ?></span> a dit : 
                            </p>
                            <p class="homeLastComment"><?= nl2br(htmlspecialchars($dataComment['comment'])); ?></p>
                        </div>
                    <?php          
                    }
                    $lastComments->closeCursor();
                    ?>
        </article>
<?php $content = ob_get_clean(); ?>
<?php require('views/frontend/template.php'); ?> 
<?php require('views/frontend/footerView.php'); ?> 
    
