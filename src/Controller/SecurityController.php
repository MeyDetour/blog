<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Core\Controller\Controller;

use Core\Session\Session;

class SecurityController extends Controller
{
    public function register()
    {
        $username = null;
        $password = null;
        if (!empty($_POST['username'])) {
            $username = $_POST['username'];
        }
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
        }
        if ($password && $username) {
            $repo = new UserRepository();
            $user = $repo->findByUsername($username);
            if ($user) {
                $this->addFlash("Utilisateur deja existant !", "danger");
                return $this->redirect("?type=security&action=register");
            }
            $user = new User();
            $user->setPassword($password);
            $user->setUsername($username);
            $repo->save($user);

            $this->addFlash('Utilisateur Crée !', 'success');
            return $this->redirect("?type=security&action=signIn");

        }

        return $this->render('user/signup', ['pageTitle' => "Sign up!"]);
    }

    public function signIn()
    {
        $username = null;
        $password = null;
        if (!empty($_POST['username'])) {
            $username = $_POST['username'];
        }
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
        }
        if ($password && $username) {
            $repo = new UserRepository();
            $user = $repo->findByUsername($username);
            if (!$user) {
                $this->addFlash("Utilisateur introuvable !", "danger");
                return $this->redirect("?type=security&action=signIn");
            }

            if (!$user->logIn($password)) {

                $this->addFlash('MDP INCORRECT', 'danger');
                return $this->redirect("?type=security&action=signIn");
            }
            $this->addFlash('Vous etes connecté', 'danger');
            return $this->redirect("?type=articles&action=index");

        }
        return $this->render('user/signin', ['pageTitle' => "Sign in!"]);

    }

    public function signOut()
    {
        Session::remove("user");
        $this->addFlash('Vous etes déconnecté', 'success');
        $this->redirect("?type=security&action=signIn");
    }
}