<?php
use Core\Session\Session;


?>

<form action="?type=articles&action=create" method="post">
    <input class="form-control form-control-lg" name="titre" type="text" placeholder="titre" >
    <textarea name="content" id="" class="form-control" cols="30" rows="10"></textarea>
    <input type="hidden" name="userId" value="<?=Session::user()['id']?>">
    <button type="submit" class="btn btn-primary">Creer</button>
</form>
