<?php


namespace App\Controller;

/**
 * Class WineDetailController
 * @package App\Controller
 */
class AboutUsController extends AbstractController
{


    /**
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        return $this->twig->render('AboutUs/index.html.twig');
    }
}
