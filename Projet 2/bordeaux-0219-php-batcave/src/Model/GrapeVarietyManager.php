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
class GrapeVarietyManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'grape_variety';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectGrapeByWineId(int $wineId): array
    {
        $statement = $this->pdo->prepare("SELECT grape_variety.id, type FROM wine JOIN compound ON wine.id = compound.wine_id 
JOIN $this->table ON $this->table.id = compound.variety_id WHERE wine.id = :type;");
        $statement->bindValue('type', $wineId, \PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetchAll();
    }
}
