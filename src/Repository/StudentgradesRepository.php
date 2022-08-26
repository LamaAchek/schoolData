<?php

namespace App\Repository;

use App\Entity\Studentgrades;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Studentgrades>
 *
 * @method Studentgrades|null find($id, $lockMode = null, $lockVersion = null)
 * @method Studentgrades|null findOneBy(array $criteria, array $orderBy = null)
 * @method Studentgrades[]    findAll()
 * @method Studentgrades[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentgradesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Studentgrades::class);
    }

    public function add(Studentgrades $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Studentgrades $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findbyName()
    {
        return $this->createQueryBuilder('s')
        ->getQuery()->getResult();
    }

    public function getSearchGrades($student = null ,$course = null , $classes = null ,$query=null){

        $qb = $this->createQueryBuilder('s')
                   ->orderBy('s.id', 'DESC');

        

        $qbstudent = $qb
        ->select('e', 'f')
        ->from('App\Entity\Studentgrades', 'e')
        ->leftJoin('e.studentid', 'f')
        ->where('f = :id')
        ->setParameter('id', $student)
        ->orderBy('e.id', 'DESC');        
          
           if($query && $query !== '') {

           }
                  
         return $qb->getQuery()->getResult();

    }
    public function getSearchGradesClasses($classes = null, $query = null){
        $qb = $this->createQueryBuilder('s' );
        $qb
        ->select('a', 'u')
        ->from('App\Entity\Studentgrades', 'a')
        ->leftJoin('a.classid', 'u')
        ->where('u = :id')
        ->setParameter('id', $classes)
        ->orderBy('a.id', 'DESC');

        if($query && $query !== '') {

        }
                  
         return $qb->getQuery()->getResult();
    }
    public function getSearchGradesCourse($course = null, $query = null){
        $qb = $this->createQueryBuilder('s' );
        $qb
        ->select('a', 'u')
        ->from('App\Entity\Studentgrades', 'a')
        ->leftJoin('a.courseid', 'u')
        ->where('u = :id')
        ->setParameter('id', $course)
        ->orderBy('a.id', 'DESC');

        if($query && $query !== '') {

        }
                  
         return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Studentgrades[] Returns an array of Studentgrades objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Studentgrades
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
