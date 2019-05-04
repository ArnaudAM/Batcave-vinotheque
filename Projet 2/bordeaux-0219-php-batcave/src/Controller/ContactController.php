<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ContactManager;

class ContactController extends AbstractController
{

    /**
     * Display contact page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Contact/index.html.twig');
    }

    /**
     * Display contact page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function success()
    {
        return $this->twig->render('Contact/success.html.twig');
    }

    /**
     * Display contact page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function send()
    {
        //verif form
        if (!empty($_POST)) {
            $errors = [];

            if (empty($_POST['lastname'])) {
                $errors['lastname'] = "Votre nom doit être rempli";
            }

            if (empty($_POST['firstname'])) {
                $errors['firstname'] = "Votre prénom doit être rempli.";
            }

            if (empty($_POST['email'])) {
                $errors['email'] = "Votre email doit être rempli";
            } else {
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors['email1'] = "Vous devez remplir un email fonctionnel";
                }
            }

            if (empty($_POST['tel'])) {
                $errors['tel'] = "Votre numéro de téléphone doit être renseigné.";
            } else {
                $justNums = preg_replace("/[^0-9]/", '', $_POST['tel']);
                if (!preg_match("`^0[0-9]([-. ]?\d{2}){4}[-. ]?$`", $justNums)) {
                    $errors['tel'] = "Votre numéro de téléphone doit être valide.";
                }
            }

            if (empty($_POST['message'])) {
                $errors['message'] = "Vous devez inscrire un message d'au moins 50 caractères.";
            }

            // verification
            if (count($errors) == 0) {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $contactManager = new ContactManager();
                    $contactManager->insert($_POST);
                }
                header("location: /Contact/success");
                exit();
            } else {
                return $this->twig->render('Contact/index.html.twig', [ 'errors' => $errors ]);
            }
        }
    }
}
