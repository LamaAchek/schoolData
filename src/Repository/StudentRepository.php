<?php

namespace App\Repository;

use App\Entity\Student;
use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use App\Repository\CourseRepository;


/**
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    private $cs;
    public function __construct(ManagerRegistry $registry , CourseRepository $cs)
    {
        parent::__construct($registry, Student::class);
        $this->courseRepository = $cs;
    }

    public function add(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Student $entity, bool $flush = false): void
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

 
    public function getSearchStudentL( $studentF = null ,$studentL = null , $classes = null ,$query=null){

        $qb = $this->createQueryBuilder('s' )
                   ->orderBy('s.first_name', 'DESC');

        

        

        if($studentL && $studentL !== '') {

            $qb->andWhere('s.last_name LIKE :studentL')
                ->setParameter('studentL', '%' . $studentL . '%');
            
        }

        if($studentF && $studentF !== '') {

            $qb->andWhere('s.first_name LIKE :studentF')
                ->setParameter('studentF', '%' . $studentF . '%');
                
        
        }

        
          
        if($query && $query !== '') {

        }
                  
         return $qb->getQuery()->getResult();

    }
    public function getSearchStudentCourse($course = null, $query = null){
        $qb = $this->createQueryBuilder('s' );
        $qb
        ->select('a', 'u')
        ->from('App\Entity\Student', 'a')
        ->leftJoin('a.courseid', 'u')
        ->where('u = :id')
        ->setParameter('id', $course)
        ->orderBy('a.first_name', 'DESC');

        if($query && $query !== '') {

        }
                  
         return $qb->getQuery()->getResult();
    }

    public function getSearchStudentClasses($classes = null, $query = null){
        $qb = $this->createQueryBuilder('s' );
        $qb
        ->select('a', 'u')
        ->from('App\Entity\Student', 'a')
        ->leftJoin('a.classid', 'u')
        ->where('u = :id')
        ->setParameter('id', $classes)
        ->orderBy('a.first_name', 'DESC');

        if($query && $query !== '') {

        }
                  
         return $qb->getQuery()->getResult();
    }


    public function findFormPagination(?Course $course = null): Query
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.first_name', 'DESC');

        if ($course) {
            $qb->leftJoin('a.course', 'c')
                ->where($qb->expr()->eq('c.name', ':name'))
                ->setParameter('name', $course->getName());
        }

        return $qb->getQuery();
    }

    


//    /**
//     * @return Student[] Returns an array of Student objects
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

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
