<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Laurent Breleur <lbreleur@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\PortfolioBundle\Repository;

use \Haven\Bundle\CoreBundle\Generic\StatusRepository;
use \Doctrine\ORM\QueryBuilder;
use Haven\Bundle\PortfolioBundle\Entity\Project;

/**
 * Description of ProjectRepository
 */
class ProjectRepository extends StatusRepository {

    private $query_builder;

    public function findAll() {
        $this->query_builder = $this->createQueryBuilder("e");
        return $this->getResult();
    }

    public function findAllOrderedByRank($direction = 'ASC') {
        $this->query_builder = $this->createQueryBuilder("e");
        $this->query_builder->orderBy('e.rank', $direction);
        return $this->getResult();
    }

    public function findAllPublished() {
        $this->filterByStatus(Project::STATUS_PUBLISHED);
        return $this->getResult();
    }

    public function findLastPublished($limit = null) {
        $this->filterByStatus(Project::STATUS_PUBLISHED);

        if (!is_null($limit))
            $this->query_builder->setMaxResults($limit);

        return $this->getResult();
    }

    private function filterByStatus($status, $qb = null) {
        $this->query_builder = ($qb) ? $qb : $this->createQueryBuilder("e");

        $this->query_builder->andWhere("e.status = :status");
        $this->query_builder->setParameter("status", $status);

        return $this;
    }

    public function getResult() {
        $query = $this->query_builder->getQuery();
        return $query->getResult();
    }

}

?>
