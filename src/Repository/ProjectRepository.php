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
     * Retourne un projet si le slug a ététrouvé en base de données
     * @param string $slug
     * @return Project|null
     */
    public function findBySlug(string $slug): ?Project
    {
        //Former la Requête (préparé : slug marqueur de la reqête prépaée qu'on va utiliser pour protéger sql
        $query = "SELECT * FROM project WHERE slug = :slug";

        //Demander le résultat de la requete avec la méthode queryPrepared
        $resultat = $this->connection->queryPrepared(
            $query,
            [':slug' => $slug],
            Project::class,
            false
        );

        //Retourner le projet s'il a été trouvé
        return $resultat;
    }

}