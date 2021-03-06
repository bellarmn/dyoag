<?php

namespace AppBundle\Entity;

/**
 * DemandRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DemandRepository extends \Doctrine\ORM\EntityRepository {

    //les actions de dashboard
    public function getDashboardCountBrouillons($user) {
        return $this->createQueryBuilder('d')
                        ->select('COUNT(d)')
                        ->where('d.user  =:user')
                        ->andwhere('d.published  =:published')
                        ->andwhere('d.deleted  =:deleted')
                        ->andwhere('d.canceled  =:canceled')
                        ->andwhere('d.available  =:available')
                        ->setParameter('user', $user)
                        ->setParameter('published', false)
                        ->setParameter('available', true)
                        ->setParameter('deleted', false)
                        ->setParameter('canceled', false)
                        ->getQuery()
                        ->getSingleScalarResult();
    }

    public function getDashboardCountPulibes($user) {
        return $this->createQueryBuilder('d')
                        ->select('COUNT(d)')
                        ->where('d.user  =:user')
                        ->andwhere('d.published  =:published')
                        ->andwhere('d.deleted  =:deleted')
                        ->andwhere('d.canceled  =:canceled')
                        ->andwhere('d.available  =:available')
                        ->setParameter('user', $user)
                        ->setParameter('published', true)
                        ->setParameter('available', true)
                        ->setParameter('deleted', false)
                        ->setParameter('canceled', false)
                        ->getQuery()
                        ->getSingleScalarResult();
    }

    public function getDashboardCountResolus($user) {
        return $this->createQueryBuilder('d')
                        ->select('COUNT(d)')
                        ->where('d.user  =:user')
                        ->andwhere('d.published  =:published')
                        ->andwhere('d.deleted  =:deleted')
                        ->andwhere('d.canceled  =:canceled')
                        ->andwhere('d.available  =:available')
                        ->setParameter('user', $user)
                        ->setParameter('published', false)
                        ->setParameter('available', false)
                        ->setParameter('deleted', false)
                        ->setParameter('canceled', false)
                        ->getQuery()
                        ->getSingleScalarResult();
    }

    public function getDashboardCountExpires($user) {
        return $this->createQueryBuilder('d')
                        ->select('COUNT(d)')
                        ->where('d.user  =:user')
                        // ->andwhere('d.published  =:published')
                        ->andwhere('d.deleted  =:deleted')
                        ->andwhere('d.canceled  =:canceled')
                        ->andwhere('d.available  =:available')
                        ->andwhere('d.dateLimit  <= :datedujour')
                        ->setParameter('user', $user)
                        //  ->setParameter('published', false)
                        ->setParameter('available', true)
                        ->setParameter('deleted', false)
                        ->setParameter('canceled', false)
                        ->setParameter('datedujour', new \DateTime())
                        ->getQuery()
                        ->getSingleScalarResult();
    }

    public function getDashboardExpires($user) {
        return $this->createQueryBuilder('d')
                        ->where('d.user  =:user')
                        // ->andwhere('d.published  =:published')
                        ->andwhere('d.deleted  =:deleted')
                        ->andwhere('d.canceled  =:canceled')
                        ->andwhere('d.available  =:available')
                        ->andwhere('d.dateLimit  <= :datedujour')
                        ->setParameter('user', $user)
                        //  ->setParameter('published', false)
                        ->setParameter('available', true)
                        ->setParameter('deleted', false)
                        ->setParameter('canceled', false)
                        ->setParameter('datedujour', new \DateTime())
                        ->getQuery()->getResult();
    }

    public function getDashboardCountCorbeille($user) {
        return $this->createQueryBuilder('d')
                        ->select('COUNT(d)')
                        ->where('d.user  =:user')
                        ->andwhere('d.published  =:published')
                        ->andwhere('d.deleted  =:deleted')
                        ->andwhere('d.canceled  =:canceled')
                        ->andwhere('d.available  =:available')
                        ->setParameter('user', $user)
                        ->setParameter('published', false)
                        ->setParameter('available', true)
                        ->setParameter('deleted', false)
                        ->setParameter('canceled', true)
                        ->getQuery()
                        ->getSingleScalarResult();
    }

    /*
     * **
     */

    public function getCountDemand() {
        return $this->createQueryBuilder('d')
                        ->select('COUNT(d)')
                        ->getQuery()
                        ->getSingleScalarResult();
    }

    private function getDemandsQueryBuilder() {
        return $this->createQueryBuilder('d')
        ;
    }

    /**
     * Retourne les Demandes par catégory
     * @param type $category
     * @param type $limit
     * @param type $offset
     * @param type $sortedBy
     * @return type
     */
    public function getDemandsByCategory($category, $limit = null, $offset = null, $sortedBy = null) {

        $query = $this->getDemandsQueryBuilder()
                ->innerJoin('d.product', 'p')
                ->innerJoin('p.category', 'c')
                ->where("c.name LIKE :category")
                ->setParameter('category', '%' . $category . '%');

        return $this->getQueryResult($query, $limit, $offset, $sortedBy);
    }

    public function getDemandsByCategoryId($category, $limit = null, $offset = null, $sortedBy = null) {

        $query = $this->getDemandsQueryBuilder()
                ->innerJoin('d.product', 'p')
                ->innerJoin('p.category', 'c')
                ->where("c.id =:category")
                ->setParameter('category', $category);

        return $this->getQueryResult($query, $limit, $offset, $sortedBy);
    }

    private function getQueryResult($query, $limit, $offset, $sortedBy) {
        if ($limit && $offset) {
            $query->setMaxResults($limit)
                    ->setFirstResult($offset);
        }

        if (!$sortedBy) {
            $query->addOrderBy('d.createAt', 'DESC');
        } else {
            if ($sortedBy == 'product') {
                $query->innerJoin('d.product', 'p');
                $query->addOrderBy("p", 'ASC');
            } else {
                $query->addOrderBy("d.{$sortedBy}", 'DESC');
            }
        }
        $query->andwhere('d.published  =:published')
                ->setParameter('published', true);
        return $query->getQuery()
                        ->getResult();
    }

    public function getDemands($limit = null, $offset = null, $sortedBy = null) {

        $query = $this->getDemandsQueryBuilder();
        return $this->getQueryResult($query, $limit, $offset, $sortedBy);
    }

    /**
     * Retourne les offres par produit
     * @param type $product
     * @param type $limit
     * @param type $offset
     * @param type $sortedBy
     * @return type
     */
    public function getDemandsByProduct($product, $limit = null, $offset = null, $sortedBy = null) {

        $query = $this->getDemandsQueryBuilder()
                ->innerJoin('d.product', 'p')
                ->where("p.name LIKE :product")
                ->setParameter('product', '%' . $product . '%');

        return $this->getQueryResult($query, $limit, $offset, $sortedBy);
    }

    public function getDemandsByProductId($product, $limit = null, $offset = null, $sortedBy = null) {

        $query = $this->getDemandsQueryBuilder()
                ->innerJoin('d.product', 'p')
                ->where("p.id =:product")
                ->setParameter('product', $product);

        return $this->getQueryResult($query, $limit, $offset, $sortedBy);
    }
    public function getDemandsByCityProductId($cityId, $productId, $limit = null, $offset = null, $sortedBy = null) {
        $query = $this->getDemandsQueryBuilder()
                ->innerJoin('d.product', 'p')
                ->innerJoin('d.district', 'di')
                ->innerJoin('di.city', 'c')
                ->where("c.id =:cityId")
                ->andwhere("p.id =:productId")
                ->setParameter('cityId', $cityId)
                ->setParameter('productId', $productId);

        return $this->getQueryResult($query, $limit, $offset, $sortedBy);
    }
    public function getDemandsByCityId($cityId, $limit = null, $offset = null, $sortedBy = null) {
        $query = $this->getDemandsQueryBuilder()
                ->innerJoin('d.district', 'di')
                ->innerJoin('di.city', 'c')
                ->where("c.id =:id")
                ->setParameter('id', $cityId);

        return $this->getQueryResult($query, $limit, $offset, $sortedBy);
    }
    
    public function getDashboardCountMarket($user) {
        return $this->createQueryBuilder('d')
                        ->select('COUNT(d)')
                        ->where('d.user  =:user')
                        ->andwhere('d.deleted  =:deleted')
                        ->andwhere('d.canceled  =:canceled')
                        ->setParameter('user', $user)
                        ->setParameter('deleted', false)
                        ->setParameter('canceled', false)
                        ->getQuery()
                        ->getSingleScalarResult();
    }
    
}
