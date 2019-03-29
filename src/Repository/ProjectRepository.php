<?php


namespace App\Repository;







use App\Entity\Project;
use App\Model\Connection;

class ProjectRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * ProjectRepository constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {

    $this->connection = $connection;
    }

    /**
     * Retourne un projet si le slug a été trouvé en base de données
     * @param string $slug
     * @return Project|null
     */
    public function findBySlug(string $slug): ?Project
    {
        //Former la Requête SQL (requete préparé ":slug" deux points est un marqueur
        // de la requête prépaée qu'on va utiliser pour protéger sql
        $query = "SELECT * FROM project WHERE slug = :slug";

        //Demander le résultat de la requete avec la méthode queryPrepared : on délèque la requete à la Connection
        $resultat = $this->connection->queryPrepared(
            $query,
            [':slug' => $slug],
            Project::class,
            false
        );

        //Retourner le projet s'il a été trouvé
        return $resultat;
    }

    /**
     * @return array les projets trouvés
     */
    public function findAll(): array{

        $query = "SELECT * FROM project";
        return $this->connection->query(
            $query,
            Project::class
            );
    }

}