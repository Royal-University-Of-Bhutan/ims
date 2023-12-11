<?php

namespace OrgSettings\Mapper;

use OrgSettings\Model\Organisation;
use OrgSettings\Model\OrganisationDocuments;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\ResultSet\ResultSet;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ZendDbSqlMapper implements OrgSettingsMapperInterface
{
	/**
	* @var \Zend\Db\Adapter\AdapterInterface
	*
	*/
	
	protected $dbAdapter;
	
	/*
	 * @var \Zend\Stdlib\Hydrator\HydratorInterface
	*/
	protected $hydrator;
	
	/*
	 * @var \EmpWorkForceProposal\Model\EmpWorkForceProposalInterface
	*/
	protected $settingsPrototype;
	
	/**
	* @param AdapterInterface $dbAdapter
	*/
	
	public function __construct(
			AdapterInterface $dbAdapter,
			HydratorInterface $hydrator,
			Organisation $settingsPrototype
		)
	{
		$this->dbAdapter = $dbAdapter;
		$this->hydrator = $hydrator;
		$this->settingsPrototype = $settingsPrototype;
	}
	
	/*
	* take username and returns Name and any other detail required
	*/
	
	public function getUserDetails($username, $usertype)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		if($usertype == 1){
			$select->from(array('t1' => 'employee_details'));
			$select->where(array('t1.emp_id' => $username));
			$select->columns(array('first_name', 'middle_name', 'last_name', 'organisation_id', 'departments_id', 'departments_units_id'));
		}

		else if($usertype == 2){
			$select->from(array('t1' => 'student'));
			$select->where(array('student_id' => $username));
			$select->columns(array('first_name', 'middle_name', 'last_name', 'organisation_id'));
		}		
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		return $resultSet->initialize($result);
	}

	public function getUserImage($username, $usertype)
	{
		$img_location = NULL;
		
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		if($usertype == 1){
			$select->from(array('t1' => 'employee_details'));
			$select->where(array('t1.emp_id' => $username));
			$select->columns(array('profile_picture', 'first_name', 'middle_name', 'last_name'));
		}

		if($usertype == 2){
			$select->from(array('t1' => 'student'));
			$select->where(array('t1.student_id' => $username));
			$select->columns(array('profile_picture', 'first_name', 'middle_name', 'last_name'));
		}		
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		
		foreach($resultSet as $set){
			$img_location = $set['profile_picture'];
		}
		
		return $img_location;
	}
	
	/**
	* @param int/String $id
	* @return EmpWorkForceProposal
	* @throws \InvalidArgumentException
	*/
	
	public function find($id, $tableName)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();
		if($tableName == 'department_units'){
			$select->from(array('t1' => $tableName))
                    ->join(array('t2' => 'departments'), 
                            't1.departments_id = t2.id', array('organisation_id', 'department_name'))
                    ->join(array('t3' => 'organisation'),
                			't3.id = t2.organisation_id', array('organisation_name', 'organisation_dzongkha_name'))
					->where(array('t1.id = ? ' => $id));
		} 
		else if($tableName == 'departments'){
			$select->from(array('t1' => $tableName))
				   ->join(array('t2' => 'organisation'),
						't2.id = t1.organisation_id', array('organisation_name', 'organisation_dzongkha_name'))
				   ->where(array('t1.id = ? ' => $id));
		}
		else {
			$select->from(array('t1' => $tableName))
				   ->where(array('t1.id = ? ' => $id));
		}

		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();

		if($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()){
				return $this->hydrator->hydrate($result->current(), $this->settingsPrototype);
		}

		throw new \InvalidArgumentException("Given ID: ($id) not found");
	}
	
	/**
	* @return array/EmpWorkForceProposal()
	*/
	public function findAll($tableName)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();
		if($tableName == 'department_units'){
			$select->from(array('t1' => $tableName))
                    ->join(array('t2' => 'departments'), 
                            't1.departments_id = t2.id', array('organisation_id', 'department_name'))
                    ->join(array('t3' => 'organisation'),
                			't3.id = t2.organisation_id', array('organisation_name', 'organisation_dzongkha_name'));
		} 
		else if($tableName == 'departments'){
			$select->from(array('t1' => $tableName))
				   ->join(array('t2' => 'organisation'),
						't2.id = t1.organisation_id', array('organisation_name', 'organisation_dzongkha_name')); 
		}
		else {
			$select->from(array('t1' => $tableName)); 
		}
		
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();

		if ($result instanceof ResultInterface && $result->isQueryResult()) {

			$resultSet = new ResultSet();
			$resultSet->initialize($result);

			$resultSet = new HydratingResultSet($this->hydrator, $this->settingsPrototype);
			return $resultSet->initialize($result); 
		}

		return array();
	}
        
	/**
	 * 
	 * @param type $id
	 * 
	 * to find the HRD Proposal for a given $id
	 */
	public function findDetails($id) 
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select->from(array('t1' => 'travel_authorization'))
                    ->join(array('t2' => 'travel_details'), 
                            't1.id = t2.travel_authorization_id')
                    ->where('t1.employee_details_id = ' .$id);
		
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		$resultSet = new ResultSet();
        return $resultSet->initialize($result);

	}
		
	/**
	 * 
	 * @param type $EmpWorkForceProposalInterface
	 * 
	 * to save work force proposals
	 */
	
	public function saveDetails(Organisation $settingsObject)
	{
		$settingsData = $this->hydrator->extract($settingsObject);
		unset($settingsData['id']);
		
		if($settingsData['organisation_Name'] == NULL){
			unset($settingsData['organisation_Name']);
		} else {
			$table_name = 'organisation';
		}
			
		if($settingsData['address'] == NULL)
			unset($settingsData['address']);
			
		if($settingsData['department_Name'] == NULL){
			unset($settingsData['department_Name']);
		} else {
			$table_name = 'departments';
			$settingsData['organisation_Id'] = $settingsData['organisation_Id'];
			unset($settingsData['organisation_Code']);
			unset($settingsData['abbr']);
			unset($settingsData['organisation_Dzongkha_Name']);
		}
			
		if($settingsData['organisation_Id'] == NULL)
			unset($settingsData['organisation_Id']);
			
		if($settingsData['unit_Name'] == NULL){
			unset($settingsData['unit_Name']);
		} else {
			$table_name = 'department_units';
			$settingsData['departments_Id'] = $settingsData['departments_Id'];
			unset($settingsData['organisation_Id']);
			unset($settingsData['organisation_Code']);
			unset($settingsData['abbr']);
			unset($settingsData['organisation_Dzongkha_Name']);	
			
		}
			
		if($settingsData['departments_Id'] == NULL)
			unset($settingsData['departments_Id']);
		
		if($settingsObject->getId()) {
			//ID present, so it is an update
			$action = new Update($table_name);
			$action->set($settingsData);
			$action->where(array('id = ?' => $settingsObject->getId()));
		} else {
			//ID is not present, so its an insert
			$action = new Insert($table_name);
			$action->values($settingsData);
		}
		
		$sql = new Sql($this->dbAdapter);
		$stmt = $sql->prepareStatementForSqlObject($action);
		$result = $stmt->execute();
		
		if($result instanceof ResultInterface) {
			if($newId = $result->getGeneratedValue()){
				//when a value has been generated, set it on the object
				$settingsObject->setId($newId);
			}
			return $settingsObject;
		}
		
		throw new \Exception("Database Error");
	}

	public function insertOrganisationDocument(OrganisationDocuments $settingsObject, $organisation_id)
	{
		$settingsData = $this->hydrator->extract($settingsObject);
		unset($settingsData['id']);

		$organisation_file = $settingsData['documents'];
		$settingsData['documents'] = $organisation_file['tmp_name'];
		// To check whether image has been uploaded before or not
		$uploaded_image_id = $this->getUploadedImageId($settingsData['document_Type'], $settingsData['organisation_Id']);

		if($uploaded_image_id){
			$action = new Update('organisation_document');
			$action->set(array('documents' => $settingsData['documents']));
			$action->where(array('id = ?' => $uploaded_image_id));
		}else{
			$action = new Insert('organisation_document');
			$action->values($settingsData);
		}
		
		$sql = new Sql($this->dbAdapter);
		$stmt = $sql->prepareStatementForSqlObject($action);
		$result = $stmt->execute();
	}


	public function getUploadedImageId($document_type, $organisation_id)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'organisation_document'));
		$select->where(array('t1.document_type' => $document_type, 't1.organisation_id' => $organisation_id));

		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);

		$image_id = NULL;
		foreach($resultSet as $set){
			$image_id = $set['id'];
		}
		return $image_id;
	}
	
	/**
	* @return array/EmployeeLeave()
	*/
	public function listOrganisationEmployee($date)
	{
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select();

            $select->from(array('t1' => 'travel_authorization'));
			$select->where(array('travel_auth_date >= ? ' => $date));
			$select->columns(array('employee_details_id'));
			$select->group('employee_details_id');

            $stmt = $sql->prepareStatementForSqlObject($select);
            $result = $stmt->execute();
			
			$resultSet = new ResultSet();
			return $resultSet->initialize($result);

	}
	
	/**
	* Find details of employees that have applied for leave
	*
	*/
	
	public function findEmployeeDetails($empIds)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select('employee_details');
		$select->where(array('id ' => $empIds));
		$select->columns(array('id','first_name','middle_name','last_name','emp_id'));

		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		
		//Need to make the resultSet as an array
		// e.g. 1=> Objective 1, 2 => Objective etc.
			
		$employeeData = array();
		foreach($resultSet as $set)
		{
			$employeeData[$set['id']] = $set['first_name'] . ' '. $set['middle_name'] .' '. $set['last_name'];
			$employeeData['emp_id' . $set['id']] = $set['emp_id'];
		}
		return $employeeData;
	}


	public function getUploadeOrganisationDocument($tableName, $document_type, $organisation_id)
	{	
		$sql = new Sql($this->dbAdapter);

		if($tableName == 'organisation_document'){
			$img_location = NULL;

			$select = $sql->select();

			$select->from(array('t1' => $tableName))
		       ->where(array('t1.document_type' => $document_type, 't1.organisation_id' => $organisation_id));

			$stmt = $sql->prepareStatementForSqlObject($select);
			$result = $stmt->execute();
			
			$resultSet = new ResultSet();
			$resultSet->initialize($result);
			
			foreach($resultSet as $set){
				$img_location = $set['documents'];
			}
			return $img_location;
		} 
		else if($tableName == 'organisation'){ 
			$select = $sql->select();

			$select->from(array('t1' => $tableName))
		       ->where(array('t1.id' => $organisation_id));

			$stmt = $sql->prepareStatementForSqlObject($select);
			$result = $stmt->execute();
			
			$resultSet = new ResultSet();
			return $resultSet->initialize($result);
		}
	}

	
	/**
	* The following function is for listing data for select/dropdown form
	* For e.g. Need to fill the objectives field with Objectives from the database
	*/
	public function listSelectData($tableName, $columnName)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => $tableName));
		$select->columns(array('id',$columnName)); 

		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		
		//Need to make the resultSet as an array
		// e.g. 1=> Objective 1, 2 => Objective etc.
		
		$selectData = array();
		foreach($resultSet as $set)
		{
			$selectData[$set['id']] = $set[$columnName];
		}
		return $selectData;
			
	}
        
        
}