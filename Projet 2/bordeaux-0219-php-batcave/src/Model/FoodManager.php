<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class FoodManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'food';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectFoodByWineId(int $wineId): array
    {
        $statement = $this->pdo->prepare("SELECT type FROM $this->table JOIN wine ON $this->table.id=wine.id WHERE wine.id = :id");
        $statement->bindValue('id', $wineId, \PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetchAll();
    }
}
