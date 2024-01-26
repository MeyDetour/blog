<?php
use Core\Session\Session;


?>

<form action="?type=articles&action=update" method="post">
    <input class="form-control form-control-lg" name="titre" value="<?=$article->getTitre()?>" type="text" placeholder="titre" >
    <textarea name="content" id="" class="form-control" cols="30"  rows="10"><?=$article->getContent()?></textarea>
    <button type="submit" class="btn btn-primary">Creer</button>
</form>
