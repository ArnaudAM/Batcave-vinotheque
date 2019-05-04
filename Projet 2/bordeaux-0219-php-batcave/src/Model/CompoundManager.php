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
class CompoundManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'compound';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    public function deleteVariety(int $id): bool
    {
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE wine_id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        return $statement->execute();
    }

    public function insertVariety(int $id): bool
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table (variety_id, wine_id) VALUES (:variety_id, :wine_id)");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);

        return $statement->execute();
    }
}
