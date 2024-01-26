<?php

use Core\Session\Session;


?>


<div class="card" style="width: 18rem;">
    <img src="..." class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title"><?= $article->getTitre() ?></h5>
        <p class="card-text"><?= $article->getContent() ?></p>
        <p class="card-text"><?= $article->getAuthor()->getUsername() ?></p>
        <a href="?type=articles&action=index" class="btn btn-primary">Retour</a>
    </div>
</div>

<div class="d-flex flex-column">
    <?php foreach ($article->getComments() as $comment):; ?>
        <div class="form-control">
            <h4><?= $comment->getAuthor()->getUsername() ?></h4>
            <h5><?= $comment->getContent() ?></h5>
            <?php if(Session::user()['id']==$comment->getUserId()){  ?>
                <a href="?type=comments&action=delete&id=<?=$comment->getId()?>" class="btn btn-primary">Delete</a>
            <?php }?>
        </div>

    <?php endforeach; ?>

</div>
<form action="?type=comments&action=create" method="post">
    <textarea name="content" id="" class="form-control" cols="30" rows="10"></textarea>
    <input type="hidden" name="userId" value="<?= Session::user()['id'] ?>">
    <input type="hidden" name="articleId" value="<?= $article->getId() ?>">
    <button type="submit" class="btn btn-primary">Creer</button>
</form>