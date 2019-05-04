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
class AgricultureManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'agriculture';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAgricultureById(array $agriculture): int
    {
        $statement = $this->pdo->prepare("SELECT type FROM wine JOIN cultivate ON wine.id = cultivate.wine_id 
JOIN $this->table ON $this->table.id = cultivate.agriculture_id WHERE wine.id = :type;");
        $statement->bindValue('type', $agriculture['type'], \PDO::PARAM_STR);

        $statement->execute();
    }
}
