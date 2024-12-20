<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * @param array $criteria
     * @return Recipe[]
     */
    public function findByCriteria(array $criteria): array
    {
        $qb = $this->createQueryBuilder('r');

        if (!empty($criteria['title'])) {
            $qb->andWhere('r.title LIKE :title')
               ->setParameter('title', '%' . $criteria['title'] . '%');
        }

        if (!empty($criteria['maxDuration'])) {
            $qb->andWhere('r.duration <= :maxDuration')
               ->setParameter('maxDuration', $criteria['maxDuration']);
        }

        if (!empty($criteria['difficulty'])) {
            $qb->andWhere('r.difficulty = :difficulty')
               ->setParameter('difficulty', $criteria['difficulty']);
        }

        if (!empty($criteria['ingredients'])) {
            $qb->join('r.ingredients', 'i')
               ->andWhere($qb->expr()->in('i.name', ':ingredients'))
               ->setParameter('ingredients', $criteria['ingredients']);
        }

        if (!empty($criteria['excludedIngredients'])) {
            $excludedIngredientsQuery = $this->getEntityManager()->createQueryBuilder()
                ->select('e.id')
                ->from('App\Entity\Ingredient', 'e')
                ->where('e.name IN (:excludedIngredients)')
                ->getDQL();
        
            $qb->andWhere($qb->expr()->notIn(
                'r.id',
                $this->getEntityManager()->createQueryBuilder()
                    ->select('re.id')
                    ->from('App\Entity\Recipe', 're')
                    ->join('re.ingredients', 'ri')
                    ->where("ri.id IN ($excludedIngredientsQuery)")
                    ->getDQL()
            ))
            ->setParameter('excludedIngredients', $criteria['excludedIngredients']);
        }        

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Recipe[] Returns an array of Recipe objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Recipe
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
