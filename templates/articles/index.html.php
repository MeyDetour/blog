<div class="d-flex flex-row">
    <?php foreach ($articles as $article) : ?>
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= $article->getTitre() ?></h5>
                <p class="card-text"><?= $article->getContent() ?></p>
                <p class="card-text">   <?= $article->getAuthor()->getUsername() ?></p>


                <a href="?type=articles&action=show&id=<?= $article->getId() ?>" class="btn btn-primary">Voir</a>

                <?php if (\Core\Session\Session::userConnected()) {
                    if ($article->getUserId() == \Core\Session\Session::user()['id']) {
                        ?>
                        <a href="?type=articles&action=delete&id=<?= $article->getId() ?>" class="btn btn-primary">Delete</a>
                        <a href="?type=articles&action=update&id=<?= $article->getId() ?>"
                           class="btn btn-primary">Edit</a>
                    <?php }
                } ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>