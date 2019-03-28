<?php
namespace App\Model;

/**
 * Class Connection
 * Permet d'établir une connexion avec la base de données ...
 * ... et de lancer des requêtes SQL
 */
class Connection
{
    /**
     * @var \PDO
     */
    private $pdo;
    public function __construct(
        string $databaseName,
        string $databaseUser,
        string $databasePass
    ) {
        // Infos nécessaires
        $dsn = 'mysql:host=localhost;dbname='.$databaseName;
        $this->connect($dsn, $databaseUser, $databasePass);
    }
    /**
     * Etablit une connexion avec la base de données
     * @param string $dsn
     * @param string $user
     * @param string $pass
     */
    private function connect(string $dsn, string $user, string $pass): void
    {
        try {
            $this->pdo = new \PDO($dsn, $user, $pass, [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET names utf8"
            ]);
        } catch (\PDOException $e) {
            echo "Erreur lors de la connexion : " . $e->getMessage() . "<br/>";
            die();
        }
    }
    /**
     * Execute un requête SQL
     * @param string $query - Requête SQL
     * @param string|null $className - Eventuelle classe dans laquelle sera stocké le résultat
     * @return array
     */
    public function query(string $query, string $className = null)
    {
        $pdoStatement = $this->pdo->query($query);
        if (is_null($className)) {
            $resultat = $pdoStatement->fetchAll();
        } else {
            $resultat = $pdoStatement->fetchAll(\PDO::FETCH_CLASS, $className);
        }
        return $resultat;
    }
    public function findById(string $tableName, int $id): array
    {
        // Préparation
        $query = "SELECT * FROM ".$tableName." WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        // Execution
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * Exécute une requêteSQL préparée
     * @param string $query - requête SQL préparée
     * @param array $params - les parametres de la requete
     * @param string|null $className - l'eventuelle classe ou seront stockés les resultats
     * @param bool|null $fetchAll - si passé à false utilisation de fetch, si true utilisation de fetchAll
     */
    public function queryPrepared(string $query, array $params, ?string $className = null, ?bool $fetchAll = true)
    {
        //on prépare la requete
        $statement = $this->pdo->prepare($query);
        //on ajoute les paramètres à la requête
        foreach ($params as $key => $value){
            $statement->bindParam($key, $value);
        }

        //on execute la requete
        $statement->execute();

        //on gère fetchMode (est-ce qu'on stocke les résultats dans une classe?)
        if(!is_null($className)){
            $statement->setFetchMode(\PDO::FETCH_CLASS, $className);
            //\PDO c'est la même chose que $this->pdo
        }
        //on retourne les resultats (fetchAll? fetch?)
        if($fetchAll){
            $resultat = $statement->fetchAll();
        } else {
            $resultat = $statement->fetch();
        }

        return $resultat;
    }


}