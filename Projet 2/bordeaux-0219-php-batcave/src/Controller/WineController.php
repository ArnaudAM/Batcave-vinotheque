<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-04-24
 * Time: 10:36
 */

namespace App\Controller;

use App\Model\AgricultureManager;
use App\Model\WineManager;
use App\Model\FoodManager;
use App\Model\RegionManager;
use App\Model\ColorManager;
use App\Model\GrapeVarietyManager;

class WineController extends AbstractController
{

    /**
     * Display item listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
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

    public function list(string $type = null, string $filter = null)
    {

        $regionManager = new RegionManager();
        $regions = $regionManager->selectAll();

        $colorManager = new ColorManager();
        $colors = $colorManager->selectAll();

        $grapeVarietyManager = new GrapeVarietyManager();
        $grapesVariety = $grapeVarietyManager->selectAll();

        if (!empty($type) && !empty($filter)) {
            $typeWineManager = new WineManager();
            $wines = $typeWineManager->selectByType($type, $filter);
        } else {
            $wineManager = new WineManager();
            $wines = $wineManager->selectAll();
        }


        return $this->twig->render('Wine/list.html.twig', [
            'wines' => $wines,
            'regions' => $regions,
            'colors' => $colors,
            'grapes' => $grapesVariety
            ]);
    }
}
