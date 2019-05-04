<?php


namespace App\Controller;

use App\Model\AgricultureManager;
use App\Model\ColorManager;
use App\Model\FoodManager;
use App\Model\GrapeVarietyManager;
use App\Model\RegionManager;
use App\Model\WineManager;

class AdminWineController extends AbstractController
{
    /**
     * Display item listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        if (!isset($_SESSION['login'])) {
            header('Location:/AdminLogin/index');
            exit();
        }


            $wineManager = new WineManager();
            $wines = $wineManager->selectAll();


            return $this->twig->render('AdminWine/index.html.twig', ['wines' => $wines]);
    }

    /**
     * Display item informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        if (!isset($_SESSION['login'])) {
            header('Location:/AdminLogin/index');
            exit();
        }
        $wineManager = new WineManager();
        $wine = $wineManager->selectOneById($id);

        return $this->twig->render('Location:/Wine/detail/', ['wine' => $wine]);
    }
    /**
     * Display item edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {

        //echo '<pre>' . print_r($_POST, true) . '</pre>'; die;


        if (!isset($_SESSION['login'])) {
            header('Location:/AdminLogin/index');
            exit();
        }
        $wineManager = new WineManager();
        $wine = $wineManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $wineManager = new WineManager();
            $wineManager->update($_POST);
            header('Location:/Wine/detail/' . $id);
        }

        $regionManager = new RegionManager();
        $regions = $regionManager->selectAll();

        $colorManager = new ColorManager();
        $colors = $colorManager->selectAll();

        //$grapeVarietyManager = new GrapeVarietyManager();
        //$varieties = $grapeVarietyManager->selectAll();


        //$compounds = $grapeVarietyManager->selectGrapeByWineId($id);

        return $this->twig->render('AdminWine/edit.html.twig', ['wine' => $wine, 'regions' => $regions, 'colors' => $colors, 'formAction' => '/AdminWine/edit/'.$id]);
    }


    /**
     * Display item creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        if (!isset($_SESSION['login'])) {
            header('Location:/AdminLogin/index');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $wineManager = new WineManager();
            $wine = [
                'name' => $_POST['name'],
                'domain' => $_POST['domain'],
                'region' => $_POST['region'],
                'vintage' => $_POST['vintage'],
                'color' => $_POST['color'],
                'alcohol_level' => $_POST['alcohol_level'],
                'long_keeping' => $_POST['long_keeping'],
                'history' => $_POST['history'],
            ];

            $id = $wineManager->insert($wine);

            $fichier = $id . '.' . pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            $dossier = APP_UPLOADED_PICTURES . '/wines/';
            $extensions = array('.png', '.gif', '.jpg', '.jpeg');
            $extension = strrchr($_FILES['picture']['name'], '.');

            if (!in_array($extension, $extensions)) {
                $erreur = 'Vous devez uploader un fichier de type png, gif, jpg ou jpeg...';
            }

            if (!isset($erreur)) {
                move_uploaded_file($_FILES['picture']['tmp_name'], $dossier . $fichier);
            } else {
                    echo $erreur;
            }
            header('Location:/Wine/detail/' . $id);
            exit();
        }

        $colorManager = new ColorManager();
        $colors = $colorManager->selectAll();

        $regionManager = new RegionManager();
        $regions = $regionManager->selectAll();

        return $this->twig->render('AdminWine/add.html.twig', ['regions' => $regions, 'colors' => $colors, 'formAction' => '/AdminWine/add']);
    }


    /**
     * Handle item deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $wineManager = new WineManager();
        $wineManager->delete($id);
        header('Location:/AdminWine/index');
    }
    public function detail(int $id)
    {
        $wineManager = new WineManager();
        $wine = $wineManager->selectOneById($id);

        $agricultureManager = new AgricultureManager();
        $agriculture = $agricultureManager->selectOneById($id);

        $foodManager = new FoodManager();
        $food = $foodManager->selectFoodByWineId($id);

        $grapeVarietyManager = new GrapeVarietyManager();
        $grapes = $grapeVarietyManager->selectGrapeByWineId($id);

        return $this->twig->render('Wine/detail.html.twig', [
            'wine'=>$wine,
            'agriculture'=>$agriculture,
            'food'=>$food,
            'grapes'=>$grapes
        ]);
    }
}
