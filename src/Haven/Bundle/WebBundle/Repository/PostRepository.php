<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\WebBundle\Repository;

use \Haven\Bundle\CoreBundle\Generic\StatusRepository;
use Haven\Bundle\WebBundle\Entity\Post;
use Haven\Bundle\WebBundle\Entity\PostTranslation;

/**
 * Haven\Bundle\WebBundle\Entity\PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends StatusRepository {

    private $query_builder;

    public function __construct($em, \Doctrine\ORM\Mapping\ClassMetadata $class) {
        parent::__construct($em, $class);
        $this->query_builder = $this->createQueryBuilder("e")
                ->leftJoin("e.translations", "t")
                ->leftJoin("t.trans_lang", "tl");
    }

    public function findAll() {
        return $this->getResult();
    }

    public function findAllOrderedByRank($direction = 'ASC') {
        $this->query_builder->orderBy('e.rank', $direction);
        return $this->getResult();
    }

    public function findAllPublished() {
        $this->filterByStatus(Post::STATUS_PUBLISHED);
        return $this->getResult();
    }

    public function findAllFromRank($new_rank, $old_rank, $id) {

        $this->query_builder->where('(e.rank BETWEEN :new_rank AND :old_rank OR e.rank BETWEEN :old_rank AND :new_rank) AND e.id != :id');
        $this->query_builder->setParameters(array("new_rank" => $new_rank, "old_rank" => $old_rank, "id" => $id));
        $this->query_builder->orderBy('e.rank', 'ASC');

        return $this->getResult();
    }

    public function findLastPublished($limit = null) {
        $this->filterByStatus(Post::STATUS_PUBLISHED);

        if (!is_null($limit))
            $this->query_builder->setMaxResults($limit);

        return $this->getResult();
    }

    public function findByLocalizedSlug($slug, $language) {
        $this->filterByLang($language);
        $this->filterBySlug($slug);
        $this->filterTranslationByStatus(PostTranslation::STATUS_PUBLISHED);

        return $this->query_builder->getQuery()->getOneOrNullResult();
    }

    public function findRandomPublished($limit = 1) {
        $max = $this->_em->createQuery('SELECT MAX(e.id) FROM HavenWebBundle:Post e WHERE e.status = :status')
                ->setParameter('status', Post::STATUS_PUBLISHED)
                ->getSingleScalarResult();

        $this->filterByStatus(Post::STATUS_PUBLISHED);
        $this->query_builder
                ->andWhere("e.id >= :id")
                ->orderBy("e.id", "ASC")
                ->setParameter('id', $rand = mt_rand(0, $max))
                ->setMaxResults($limit);

        return $this->getResult();
    }

    public function search($filters) {

        foreach ($filters as $filter => $value) {
            $filter = array_map(function($word) {
                        return ucfirst($word);
                    }, explode('_', $filter));

            $this->{"filterBy" . implode('', $filter)}($value, false);
        }

        $query = $this->query_builder->getQuery();

        return $query->getResult();
    }

    public function filterByTitle($title, $strict = true) {

        if ($strict) {
            $query_restriction = "t.title = :title";
        } else {
            $query_restriction = "t.title like :title";
            $title = "%" . $title . "%";
        }

        $this->query_builder->andWhere($query_restriction);
        $this->query_builder->setParameter("title", $title);

        return $this;
    }

    private function filterByStatus($status) {

        $this->query_builder->andWhere("e.status = :status");
        $this->query_builder->setParameter("status", $status);

        return $this;
    }

    private function filterTranslationByStatus($status) {

        $this->query_builder->andWhere("t.status = :status");
        $this->query_builder->setParameter("status", $status);

        return $this;
    }

    private function filterBySlug($slug) {

        $this->query_builder->andWhere("t.slug = :slug");
        $this->query_builder->setParameter("slug", $slug);

        return $this;
    }

    private function filterByLang($lang) {

        $this->query_builder
//                ->leftJoin("t.trans_lang", "tl")
                ->andWhere("tl.symbol= :language")
                ->setParameter("language", $lang)
        ;
        return $this;
    }

    public function getResult() {
        $query = $this->query_builder->getQuery();
        return $query->getResult();
    }

    /**
     * Return a query for last crated post.
     * 
     * @param boolean $return_qb
     * @param \Doctrine\ORM\QueryBuilder $query_builder
     * @return type
     */
    public function findLastCreatedOnline($qt = null) {
//        $query_builder = $this->createQueryBuilder("e");
        $this->query_builder->orderBy("e.created_at", "ASC")
                ->setMaxResults($qt);
        $this->filterOnlines();
        $this->filterTranslationByStatus(PostTranslation::STATUS_PUBLISHED);


        return $this->query_builder->getQuery()->getResult();
    }

}

?>
