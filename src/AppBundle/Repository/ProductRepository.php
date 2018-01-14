<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function findBestNote()
    {
		$sql = 'SELECT AVG(note) FROM evaluation, product WHERE evaluation.product_id = product.id';
		/*$params = array(
		    'id' => 1,
		);*/

		return $this->getEntityManager()->getConnection()->executeQuery($sql)->fetchAll();
    }

    public function findBestProducts()
    {
    	// Meilleur produit > photo via api , nom, code_barre de product
    	//  + liaision via evaluation

        $sql = 'SELECT AVG(note) as avg_note, code_barre, evaluation.product_id FROM evaluation, product WHERE evaluation.product_id = product.id GROUP BY code_barre ORDER BY avg_note DESC LIMIT 0,8';

		return $this->getEntityManager()->getConnection()->executeQuery($sql)->fetchAll();
    }

}