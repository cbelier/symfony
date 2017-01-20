<?php

namespace adminBundle\Repository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    //Autre méthode plus courte
    public function findComment(){
        //Le paramètre product est un alias
        $results = $this->createQueryBuilder('comment')//equivalent à un findAll()
        ->getQuery()
            ->getResult();
        return $results;
    }

    public function findCommentByProduct($id){
        $results = $this->createQueryBuilder('comment')   //c pour la table comment
            ->join('comment.product','prod') //on join la table product
            ->where('prod.id = :identifiant') // on appel la clé primaire de la table lié
            ->setParameters(['identifiant'=> $id]) //on récupère la clé du product pour lequel on veux les commentaires
            ->getQuery()
            ->getResult();
        return $results;
    }

    public function nbComment() {

        $query = $this->getEntityManager()
            ->createQuery('
                    	  SELECT COUNT(comment)
                          FROM adminBundle:Comment AS comment
                    ');

        return $query->getSingleScalarResult();
    }

    public function myFindProduction($nbProductPerPage, $offset, $id) {
        $results = $this
            ->createQueryBuilder('c')
            ->join('c.product','prod') //on join la table product
            ->where('prod.id = :identifiant') // on appel la clé primaire de la table lié
            ->setParameters(['identifiant'=> $id]) //on récupère la clé du product pour lequel on veux les commentaires
            ->setFirstResult($offset)
            ->setMaxResults($nbProductPerPage)
            ->getQuery()
            ->getResult();
        return $results;
    }



}