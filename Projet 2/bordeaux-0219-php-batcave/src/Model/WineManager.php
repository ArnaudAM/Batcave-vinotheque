<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-04-16
 * Time: 16:33
 */

namespace App\Model;

class WineManager extends AbstractManager
{
    const TABLE = 'wine';


    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    public function selectByType(string $type, string $filter)
    {

        if ($type === 'type') {
            $sql = 'SELECT w.id, type, name, region, color  FROM ' . $this->table . '  w 
        JOIN compound c ON c.wine_id=w.id 
        JOIN grape_variety gv ON gv.id=c.variety_id WHERE ' . urldecode($type) . ' = ' . '\'' . urldecode($filter) . '\'';
        } else {
            $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . urldecode($type) . ' = ' . '\'' . urldecode($filter) . '\'';
        }

        $statment = $this->pdo->prepare($sql);
        $statment->execute();
        return $statment->fetchAll();
    }

    public function selectAllByType(array $types)
    {
        $sql = 'SELECT DISTINCT w.id, w.name, color FROM wine w
            LEFT JOIN cultivate c ON w.id=c.wine_id
            LEFT JOIN smell s ON w.id=s.wine_id
            LEFT JOIN matched m ON w.id=m.wine_id
            WHERE ';

        $suiteRequete = '';
        foreach ($types as $type => $values) {
            $suiteRequete .= ' AND (';
            foreach ($values as $value) {
                $suiteRequete .= urldecode($type) . ' = ' . '\'' . urldecode($value) . '\'' . ' OR ';
            }
            $suiteRequete = trim($suiteRequete, 'OR ');
            $suiteRequete .= ')';
        }
        $suiteRequete = trim($suiteRequete, 'AND');
        $sql .= $suiteRequete;
        $statment = $this->pdo->prepare($sql);
        $statment->execute();

        return $statment->fetchAll();
    }


    public function insert(array $wine): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (name, domain, region, vintage, color, alcohol_level, long_keeping, history) VALUES (:name, :domain, :region, :vintage, :color, :alcohol_level, :long_keeping, :history)");
        $statement->bindValue(':name', $wine['name'], \PDO::PARAM_STR);
        $statement->bindValue(':domain', $wine['domain'], \PDO::PARAM_STR);
        $statement->bindValue(':region', $wine['region'], \PDO::PARAM_STR);
        $statement->bindValue(':vintage', $wine['vintage'], \PDO::PARAM_STR);
        $statement->bindValue(':color', $wine['color'], \PDO::PARAM_STR);
        $statement->bindValue(':alcohol_level', $wine['alcohol_level'], \PDO::PARAM_STR);
        $statement->bindValue(':long_keeping', $wine['long_keeping'], \PDO::PARAM_STR);
        $statement->bindValue(':history', $wine['history'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    /**
     * @param array $wine
     * @return bool
     */

    public function update(array $wine): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET name = :name, domain = :domain, region = :region, vintage = :vintage, color = :color, alcohol_level = :alcohol_level, long_keeping = :long_keeping, history = :history WHERE id=:id");
        $statement->bindValue('id', $wine['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $wine['name'], \PDO::PARAM_STR);
        $statement->bindValue('domain', $wine['domain'], \PDO::PARAM_STR);
        $statement->bindValue('region', $wine['region'], \PDO::PARAM_STR);
        $statement->bindValue('vintage', $wine['vintage'], \PDO::PARAM_STR);
        $statement->bindValue('color', $wine['color'], \PDO::PARAM_STR);
        $statement->bindValue('alcohol_level', $wine['alcohol_level'], \PDO::PARAM_INT);
        $statement->bindValue('long_keeping', $wine['long_keeping'], \PDO::PARAM_INT);
        $statement->bindValue('history', $wine['history'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
