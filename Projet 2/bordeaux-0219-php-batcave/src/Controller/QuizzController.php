<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\AgricultureManager;
use App\Model\RegionManager;
use App\Model\ColorManager;
use App\Model\AromeManager;
use App\Model\FoodManager;
use App\Model\WineManager;

/**
 * Class regionController
 *
 */
class QuizzController extends AbstractController
{

    /**
     * Display region listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $suggestions = [];
        if (!empty($_POST)) {
            $wineManager = new WineManager();
            $suggestions  =  $wineManager->selectAllByType($_POST);
        }

        $regionManager = new RegionManager();
        $regions = $regionManager->selectAll();

        $colorManager = new ColorManager();
        $colors = $colorManager->selectAll();

        $agricultureManager = new AgricultureManager();
        $agricultureTypes = $agricultureManager->selectAll();

        $aromeManager = new AromeManager();
        $aromes = $aromeManager->selectAll();

        $foodManager = new FoodManager();
        $foods = $foodManager->selectAll();

        return $this->twig->render('Quizz/index.html.twig', [
            'regions' => $regions,
            'colors' => $colors,
            'agricultureTypes' => $agricultureTypes,
            'aromes' => $aromes,
            'foods' => $foods,
            'suggestions' => $suggestions
            ]);
    }


    /**
     * Display region informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $regionManager = new regionManager();
        $region = $regionManager->selectOneById($id);

        return $this->twig->render('region/show.html.twig', ['region' => $region]);
    }


    /**
     * Display region edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $regionManager = new regionManager();
        $region = $regionManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $region['title'] = $_POST['title'];
            $regionManager->update($region);
        }

        return $this->twig->render('region/edit.html.twig', ['region' => $region]);
    }


    /**
     * Display region creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $regionManager = new regionManager();
            $region = [
                'title' => $_POST['title'],
            ];
            $id = $regionManager->insert($region);
            header('Location:/region/show/' . $id);
        }

        return $this->twig->render('region/add.html.twig');
    }


    /**
     * Handle region deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $regionManager = new regionManager();
        $regionManager->delete($id);
        header('Location:/region/index');
    }
}
