<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Core\Controller\Controller;
use Core\Session\Session;

class CommentsController extends Controller
{
    public function create()
    {
        if (!Session::userConnected()) {
            $this->addFlash('Connectez-vous pour créer un article', 'danger');
            return $this->redirect('?type=security&action=signIn');
        }
        $content = null;
        $articleId = null;
        $userId = null;

        if (!empty($_POST['content'])) {
            $content = $_POST['content'];
        }
        if (isset($_POST['userId']) && ctype_digit($_POST['userId'])) {
            $userId = $_POST['userId'];
        }
        if (isset($_POST['articleId']) && ctype_digit($_POST['articleId'])) {
            $articleId = $_POST['articleId'];
        }

        if ($content && $userId && $articleId) {
            $repo = new CommentRepository();
            $comment = new Comment();
            $comment->setContent($content);
            $comment->setUserId($userId);
            $comment->setArticleId($articleId);
            $repo->save($comment);
            $this->addFlash('commentaire added', 'success');
            return $this->redirect("?type=articles&action=show&id=" . $comment->getArticleId());
        }

        $this->addFlash('Erreur dans les données envoyé', 'success');

        return $this->redirect();

    }

    public function delete()
    {
        $id = null;
        $user = $this->getUser();
        if (!$user){
            $this->addFlash('CONNECTE TOI POUR SUPPRIMER', 'danger');
            return $this->redirect();

        }

        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            $id = $_GET['id'];
        }
        if (!$id) {
            return $this->redirect();
        }
        $repo = new CommentRepository();
        $comment = $repo->find($id);

        if (!$comment) {
            $this->addFlash('commentaire DEMANDE INEXISTANT', 'danger');
            return $this->redirect("?type=articles&action=show&id=" . $comment->getArticleId());
        }
        if ($user->getId()!==$comment->getUserId()){
            $this->addFlash('CE NEST PAS TON ARTICLE', 'danger');
            return $this->redirect();

        }
        $repo->delete($comment);
        $this->addFlash('commentaire supprimer', 'success');

        return $this->redirect("?type=articles&action=show&id=" . $comment->getArticleId());

    }
}