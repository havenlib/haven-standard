<?php

namespace Haven\Bundle\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use \Doctrine\DBAL\Query\QueryBuilder;
use Haven\Bundle\CoreBundle\Entity\Language;

/**
 * Haven\Bundle\CoreBundle\Repository\LanguageRepository
 */
class LanguageRepository extends EntityRepository {

    private $query_builder;

    public function getQueryBuilder() {
        return $this->query_builder;
    }

    public function setQueryBuilder(\Doctrine\ORM\QueryBuilder $query_builder) {
        $this->query_builder = $query_builder;
    }

    public function findAll() {
        $this->query_builder = $this->createQueryBuilder("e");
        
        return $this->getResult();
    }

    public function findAllPublished() {
        $this->query_builder = $this->filterByStatus(Language::STATUS_PUBLISHED)->getQueryBuilder();
        
        return $this->getResult();
    }

    public function findAllPublishedOrderedByRank($order = 'ASC') {
        $this->query_builder = $this->filterByStatus(Language::STATUS_PUBLISHED)
                ->orderByRank($order)
                ->getQueryBuilder();

        return $this->getResult();
    }

    public function filterByStatus($status) {
        if (is_null($this->query_builder))
            $this->query_builder = $this->createQueryBuilder("e");

        $this->query_builder->andWhere("e.status = :status");
        $this->query_builder->setParameter("status", $status);

        return $this;
    }

    public function orderByRank($order = 'ASC') {
        if (is_null($this->query_builder))
            $this->query_builder = $this->createQueryBuilder("e");

        $this->query_builder->orderBy("e.rank", $order);

        return $this;
    }

    public function getResult() {
        $query = $this->query_builder->getQuery();
        return $query->getResult();
    }
}