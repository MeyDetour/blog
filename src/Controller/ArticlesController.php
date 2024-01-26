<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Core\Controller\Controller;
use Core\Http\Response;
use Core\Session\Session;

class ArticlesController extends Controller
{
    public function index(): Response
    {
        $repo = new ArticleRepository();
        return $this->render('articles/index',
            ['pageTitle' => "tous les articles",
                "articles" => $repo->findAll()]);
    }

    public function create(): Response
    {
        if (!Session::userConnected()) {
            $this->addFlash('Connectez-vous pour créer un article', 'danger');
            return $this->redirect('?type=security&action=signIn');
        }
        $titre = null;
        $content = null;
        $userId = null;

        if (!empty($_POST['titre'])) {
            $titre = $_POST['titre'];
        }
        if (!empty($_POST['content'])) {
            $content = $_POST['content'];
        }
        if (isset($_POST['userId']) && ctype_digit($_POST['userId'])) {
            $userId = $_POST['userId'];
        }
        if ($titre && $content && $userId) {


            $article = new Article();
            $article->setTitre($titre);
            $article->setContent($content);
            $article->setUserId($userId);
            $repo = new ArticleRepository();
            $article = $repo->save($article);

            if (!$article) {
                return $this->redirect();
            }
            $this->addFlash("Création de l'article", "success");
            return $this->render('articles/show', [
                'pagetitle' => $article->getTitre(),
                "article" => $article
            ]);
        }

        return $this->render('articles/create', ['pageTitle' => 'creez !']);
    }

    public function update(): Response
    {
        $id = null;
        $titre = null;
        $content = null;
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('CONNECTE TOI POUR SUPPRIMER', 'danger');
            return $this->redirect();

        }

        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            $id = $_GET['id'];
        }
        if (!$id) {
            return $this->redirect();
        }

        if (!empty($_POST['titre'])) {
            $titre = $_POST['titre'];
        }
        if (!empty($_POST['content'])) {
            $content = $_POST['content'];
        }
        $repo = new ArticleRepository();
        $article = $repo->find($id);
        if (!$article) {
            $this->addFlash('ARTICLE DEMANDE INEXISTANT', 'danger');
            return $this->redirect();
        }
        if ($user->getId() !== $article->getUserId()) {
            $this->addFlash('CE NEST PAS TON ARTICLE', 'danger');
            return $this->redirect();

        }
        echo $titre,$content;
        if ($titre && $content ){
            $article->setTitre($titre);
            $article->setContet($content);
            $repo->update($article);
            return $this->redirect("?type=articles&action=show&id=".$article->getId());
        }

       return $this->render('articles/update',['pageTitle'=>'modifier','article'=>$article]);
    }

    public function show()
    {
        $id = null;
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            $id = $_GET['id'];
        }
        if (!$id) {
            return $this->redirect();
        }
        $repo = new ArticleRepository();
        $article = $repo->find($id);
        if (!$article) {
            $this->addFlash('ARTICLE DEMANDE INEXISTANT', 'danger');
            return $this->redirect();
        }

        return $this->render('articles/show', [
            'pagetitle' => $article->getTitre(),
            "article" => $article
        ]);
    }

    public function delete(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('CONNECTE TOI POUR SUPPRIMER', 'danger');
            return $this->redirect();

        }
        $id = null;
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            $id = $_GET['id'];
        }
        if (!$id) {
            return $this->redirect();
        }

        $repo = new ArticleRepository();
        $article = $repo->find($id);
        if (!$article) {
            $this->addFlash('ARTICLE DEMANDE INEXISTANT', 'danger');
            return $this->redirect();
        }
        if ($user->getId() !== $article->getUserId()) {
            $this->addFlash('CE NEST PAS TON ARTICLE', 'danger');
            return $this->redirect();

        }
        $repo->delete($article);
        return $this->redirect();
    }
}