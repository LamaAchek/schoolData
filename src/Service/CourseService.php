<?php

namespace App\Service;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CourseService
{
    public function __construct(
        private RequestStack $requestStack,
        private CourseRepository $CourseRepo,
        private PaginatorInterface $paginator
    ) {

    }

    public function getPaginatedCourses(?Course $course = null): PaginationInterface
    {
        $request = $this->requestStack->getMainRequest();
        $coursesQuery = $this->CourseRepo->findFormPagination($course);
        $page = $request->query->getInt('page', 1);
        $limit = 10;

        return $this->paginator->paginate($coursesQuery, $page, $limit);
    }
}