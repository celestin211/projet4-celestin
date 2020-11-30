
<?php
/****************************************VIEWS/FRONTEND/LISTPOSTVIEW.PHP****************************************/
session_start();
?>
<?php $title = 'LES CHAPITRES'; ?>
    <?php ob_start(); ?>
    <section class="mainRomanSection firstContainer"> <!--Last post-->
        <div id="secondSideDeco">
            <article id="seleChap"> 
                    <h3 class="chapitre">Les Chapitres:</h3>
                    <?php
                    while ($data = $posts->fetch())
                    {
                    ?>
                        <div class="thumbnail">
                        <p class="anne">
                                <h5><a href="index.php?action=post&amp;id=<?= $data['id']; ?>"><?= htmlspecialchars($data['title']); ?></a></h5>
                                <p class="sumChapters"><?= nl2br(substr($data['content'], 0, 500)); ?> [...]</p>
                            
                                <p>Publié le <?= ($data['post_date_fr']); ?></p></p>
                            
                        </div>
                    <?php          
                    }
                    $posts->closeCursor();
                    ?>
                    
            </article>

        </div>
    </section>
    <?php $content = ob_get_clean(); ?>
<?php require('views/frontend/template.php'); ?>
<?php require('views/frontend/footerView.php');?>

