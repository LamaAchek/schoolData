<?php

namespace App\Service;

use App\Entity\Course;
use App\Repository\StudentRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class StudentService
{
    public function __construct(
        private RequestStack $requestStack,
        private StudentRepository $studentRepo,
        private PaginatorInterface $paginator
    ) {

    }

    public function getPaginatedStudents(?Course $course = null): PaginationInterface
    {
        $request = $this->requestStack->getMainRequest();
        $studentsQuery = $this->studentRepo->findFormPagination($course);
        $page = $request->query->getInt('page', 1);
        $limit = 10;

        return $this->paginator->paginate($studentsQuery, $page, $limit);
    }
}