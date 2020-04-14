<?php


namespace App\Main\Models\Services;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class Pagination
 * Библиотечка для пагинации
 *
 * @package App\Main\Models\Services
 */
class Pagination
{
    /** @var int Количество записей на странице по умолчанию */
    protected const DEFAULT_LIMIT = 3;
    /** @var int Начальная текущая страница по умолчанию */
    protected const CURRENT_PAGE = 1;

    /**
     * Получение Doctrinee Paginator записей на странице
     *
     * @param Query $query
     * @param int $page
     * @param int $limit
     *
     * @return Paginator
     */
    public function paginate(Query $query, $page = self::CURRENT_PAGE, $limit = self::DEFAULT_LIMIT): Paginator
    {
        $paginator = new Paginator($query);
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }
}