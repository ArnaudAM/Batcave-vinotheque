<?php


/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\PersonManager;

class AdminLoginController extends AbstractController
{
    /**
     * Display login page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        if (isset($_SESSION['login'])) {
            header('Location: /Home/index');
            exit;
        }
        $errors = [];
        if (isset($_POST['submit'])) {
            $personManager = new PersonManager();
            $userExist = $personManager->selectLogin($_POST['login']);
            if (!isset($userExist[0]['login'])) {
                $errors['login'] = "L'identifiant renseigné ne correspond à aucun utilisateur, veuillez-vous inscrire";
            }
            if (!isset($userExist[0]['password']) || $userExist[0]['password'] != ($_POST['password'])) {
                $errors['password'] = 'Mot de passe incorrect';
            }
            if (count($errors) == 0) {
                $_SESSION['id'] = $userExist[0]['id'];
                $_SESSION['login'] = $userExist[0]['login'];
                header('Location: /AdminWine/index');
                exit;
            }
        }
        return $this->twig->render('AdminLogin/index.html.twig', ['post' => $_POST, 'errors' => $errors]);
    }


    public function logout(): void
    {
        session_unset();
        session_destroy();
        header('location: /AdminLogin/index');
    }
}
