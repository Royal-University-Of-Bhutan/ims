<?php

namespace GoodsDepreciation\Service;

use GoodsDepreciation\Model\GoodsDepreciation;
use GoodsDepreciation\Model\FixedAsset;

interface GoodsDepreciationServiceInterface
{   

    /*
	* Getting the id for username
	*/
	
	public function getUserDetailsId($username);
	
	/*
	* Get organisation id based on the username
	*/
	
	public function getOrganisationId($username);

	public function getUserDetails($username, $tableName);
	  
	public function getUserImage($username, $usertype);

    /**
	 * Should return a set of all Fixed Assets that we can iterate over. 
	 *
	 * @return array|GoodsDepreciationInterface[]
	*/

    public function findAllFixedAssets();
    
        
	/**
	 * Should return a single Fixed Asset
	 *
	 * @param int $id Identifier of the Fixed Asset that should be returned
	 * @return GoodsDepreciationInterface
	 */
        
    public function findFixedAssetDetails($id); 


    public function saveDepreciationValue(FixedAsset $goodsDepreciationObject);


    /**
	 * Should return a set of all Fixed Assets that we can iterate over. 
	 *
	 * @return array|GoodsDepreciationInterface[]
	*/

    public function findAllDepreciationValue();
    



}