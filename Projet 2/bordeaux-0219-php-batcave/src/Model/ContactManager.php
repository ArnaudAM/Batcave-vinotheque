<?php
/**
 * Database connection
 *
 *
 *
 * @author adapted from Benjamin Besse
 *
 * @link   http://fr3.php.net/manual/fr/book.pdo.php classe PDO
 */

namespace App\Model;

class ContactManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'contact';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }


    /**
     * @param array $infos
     * @return int
     */
    public function insert(array $infos): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO $this->table (lastname, firstname, email, tel, subject, message) 
        VALUES (:lastname, :firstname, :email, :tel, :subject, :message)");
        $statement->bindValue(':lastname', $infos['lastname'], \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $infos['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $infos['email'], \PDO::PARAM_STR);
        $statement->bindValue(':tel', $infos['tel'], \PDO::PARAM_STR);
        $statement->bindValue(':subject', $infos['subject'], \PDO::PARAM_STR);
        $statement->bindValue(':message', $infos['message'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
