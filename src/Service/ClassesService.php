<?php

namespace App\Service;

use App\Entity\Classes;
use App\Repository\ClassesRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ClassesService
{
    public function __construct(
        private RequestStack $requestStack,
        private ClassesRepository $ClassesRepo,
        private PaginatorInterface $paginator
    ) {

    }

    public function getPaginatedClasses(?Classes $classes = null): PaginationInterface
    {
        $request = $this->requestStack->getMainRequest();
        $classesQuery = $this->ClassesRepo->findFormPagination($classes);
        $page = $request->query->getInt('page', 1);
        $limit = 10;

        return $this->paginator->paginate($classesQuery, $page, $limit);
    }
}