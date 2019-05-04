<?php


namespace App\Model;

class PersonManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'persons';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectLogin($login): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE login =:login");
        $statement->bindValue(':login', $login, \PDO::PARAM_STR);

        $statement->execute();
        return $statement->fetchAll();
    }


    public function insert($user)
    {
        $statement = $this->pdo->prepare("INSERT INTO $this->table (login, password) 
        VALUE (:login,:password)");
        $statement->bindValue(':login', $user['login'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $user['password'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
