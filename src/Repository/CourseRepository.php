<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;


/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function add(Course $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Course $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findbyName()
    {
        return $this->createQueryBuilder('c')
        ->getQuery()->getResult();
    }

    public function getSearchCourses($courseTitle = null , $query=null){

        $qb = $this->createQueryBuilder('c')
                   ->orderBy('c.name', 'DESC');

           if($courseTitle && $courseTitle !== '') {

             $qb->andWhere('c.name LIKE :courseTitle')
                   ->setParameter('courseTitle', '%' . $courseTitle . '%');
           }
           
           if($query && $query !== '') {

           }
                  
         return $qb->getQuery()->getResult();

    }

    public function findFormPagination(?Course $course = null): Query
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.name', 'DESC');

        return $qb->getQuery();
    }



//    /**
//     * @return Classes[] Returns an array of Classes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Classes
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
