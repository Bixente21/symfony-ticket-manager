<?php

namespace App\Repository;

use App\Entity\Ticket;
use App\Entity\Categorie;
use App\Entity\Statut;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticket>
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    /**
     * Trouve tous les tickets ordonnés par date d'ouverture (plus récents en premier)
     */
    public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.categorie', 'c')
            ->leftJoin('t.statut', 's')
            ->leftJoin('t.responsable', 'r')
            ->addSelect('c', 's', 'r')
            ->orderBy('t.dateOuverture', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les tickets par statut
     */
    public function findByStatut(Statut $statut): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.categorie', 'c')
            ->leftJoin('t.responsable', 'r')
            ->addSelect('c', 'r')
            ->andWhere('t.statut = :statut')
            ->setParameter('statut', $statut)
            ->orderBy('t.dateOuverture', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les tickets par catégorie
     */
    public function findByCategorie(Categorie $categorie): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.statut', 's')
            ->leftJoin('t.responsable', 'r')
            ->addSelect('s', 'r')
            ->andWhere('t.categorie = :categorie')
            ->setParameter('categorie', $categorie)
            ->orderBy('t.dateOuverture', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les tickets assignés à un responsable
     */
    public function findByResponsable(User $responsable): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.categorie', 'c')
            ->leftJoin('t.statut', 's')
            ->addSelect('c', 's')
            ->andWhere('t.responsable = :responsable')
            ->setParameter('responsable', $responsable)
            ->orderBy('t.dateOuverture', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les tickets ouverts (non fermés)
     */
    public function findOpenTickets(): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.categorie', 'c')
            ->leftJoin('t.statut', 's')
            ->leftJoin('t.responsable', 'r')
            ->addSelect('c', 's', 'r')
            ->join('t.statut', 'statut')
            ->andWhere('statut.nom != :ferme')
            ->setParameter('ferme', 'Fermé')
            ->orderBy('t.dateOuverture', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Statistiques : compte les tickets par statut
     */
    public function countByStatut(): array
    {
        return $this->createQueryBuilder('t')
            ->select('s.nom as statut, COUNT(t.id) as nombre')
            ->join('t.statut', 's')
            ->groupBy('s.nom')
            ->getQuery()
            ->getResult();
    }

    /**
     * Statistiques : compte les tickets par catégorie
     */
    public function countByCategorie(): array
    {
        return $this->createQueryBuilder('t')
            ->select('c.nom as categorie, COUNT(t.id) as nombre')
            ->join('t.categorie', 'c')
            ->groupBy('c.nom')
            ->getQuery()
            ->getResult();
    }
}
