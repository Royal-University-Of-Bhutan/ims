<?php

namespace Reassessment\Mapper;

use Reassessment\Model\Reassessment;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\ResultSet\ResultSet;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ZendDbSqlMapper implements ReassessmentMapperInterface
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
	 * @var \Reassessment\Model\ReassessmentInterface
	*/
	protected $reassessmentPrototype;
	
	/**
	* @param AdapterInterface $dbAdapter
	*/
	
	public function __construct(
			AdapterInterface $dbAdapter,
			HydratorInterface $hydrator,
			Reassessment $reassessmentPrototype
		)
	{
		$this->dbAdapter = $dbAdapter;
		$this->hydrator = $hydrator;
		$this->reassessmentPrototype = $reassessmentPrototype;
	}
	
	
	/**
	* @return array/Reassessment()
	*/
	public function findAll($tableName, $applicant_id)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => $tableName)); 
		if($tableName=='reassessment_applicant')
			$select->where(array('id' =>$applicant_id));
		else
			$select->where(array('reassessment_applicant_id' =>$applicant_id));

		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		 return $resultSet->initialize($result);
	}
	
	/*
	* take username and returns employee details id
	*/
	
	public function getUserDetailsId($username)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'employee_details'));
		$select->where(array('emp_id' =>$username));
		$select->columns(array('id', 'organisation_id'));
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		return $resultSet->initialize($result);
	}
	
	/*
	* take username and returns student id
	*/
	
	public function getStudentDetailsId($username)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'student'));
		$select->where(array('student_id' =>$username));
		$select->columns(array('id', 'organisation_id'));
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		return $resultSet->initialize($result);
	}
	
	/*
	* Get organisation id based on the username
	*/
	
	public function getOrganisationId($username)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'employee_details'));
		$select->where(array('emp_id' =>$username));
		$select->columns(array('organisation_id'));
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		return $resultSet->initialize($result);
	}


	/*
	*take username and return the employee first name, middle name and last name
	*/
	public function getUserDetails($username, $usertype)
	{
		$name = NULL;
		
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		if($usertype == 1){
			$select->from(array('t1' => 'employee_details'));
			$select->where(array('emp_id' =>$username));
			$select->columns(array('first_name', 'middle_name', 'last_name'));
		}

		else if($usertype == 2){
			$select->from(array('t1' => 'student'));
			$select->where(array('student_id' =>$username));
			$select->columns(array('first_name', 'middle_name', 'last_name'));
		}		
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		
		foreach($resultSet as $set){
			$name = $set['first_name']." ".$set['middle_name']." ".$set['last_name'];
		}
		
		return $name;
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
	
	/*
	* Save Personal Details of Job Applicant
	*/
	
	public function savePersonalDetails(PersonalDetails $reassessmentObject)
	{
		$reassessmentData = $this->hydrator->extract($reassessmentObject);
		unset($reassessmentData['id']);
		unset($reassessmentData['reassessment_Applicant_Id']);

		if($reassessmentObject->getId()) {
			//ID present, so it is an update
			$action = new Update('reassessment_applicant');
			$action->set($reassessmentData);
			$action->where(array('id = ?' => $reassessmentObject->getId()));
		} else {
			//ID is not present, so its an insert
			$action = new Insert('reassessment_applicant');
			$action->values($reassessmentData);
		}
		
		$sql = new Sql($this->dbAdapter);
		$stmt = $sql->prepareStatementForSqlObject($action);
		$result = $stmt->execute();

		if($result instanceof ResultInterface) {
			if($newId = $result->getGeneratedValue()){
				//when a value has been generated, set it on the object
				echo $reassessmentObject->setId($newId);
			}
			return $reassessmentObject;
		}
		
		throw new \Exception("Database Error");
	}
	
	/*
	* Get the details of the student
	*/
	
	public function getStudentDetails($student_id, $type)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		if($type == 'self'){
			$select->from(array('t1' => 'student'))
				->columns(array('first_name','middle_name','last_name','student_id'))
				->join(array('t2' => 'programmes'), 
									't1.programmes_id = t2.id', array('programme_name'));
			$select->where(array('t1.id' =>$student_id));
		}else{
			$select->from(array('t1' => 'student_reassessment_module'))
				   ->join(array('t2' => 'student'),
				   		't2.id = t1.student_id', array('first_name','middle_name','last_name','student_id'))
				->join(array('t3' => 'programmes'), 
						't2.programmes_id = t3.id', array('programme_name'));
			$select->where(array('t1.id' =>$student_id));
		}
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		return $resultSet->initialize($result);
	}


	public function getReassessmentList($student_id)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'student_reassessment_module'))
				->join(array('t2' => 'academic_modules_allocation'), 
						't1.academic_modules_allocation_id = t2.id', array('module_title', 'module_code', 'module_type', 'academic_session', 'academic_year', 'semester', 'year'));
		$select->where(array('t1.student_id' =>$student_id));
		$select->order(array('t1.id DESC'));	
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		return $resultSet->initialize($result);
	}


	public function crossCheckModuleReassessmentApplication($academic_modules_allocation_id, $student_id)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'student_reassessment_module'));
		$select->where(array('t1.student_id' =>$student_id, 't1.academic_modules_allocation_id' => $academic_modules_allocation_id));	
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		return $resultSet->initialize($result);
	}


	public function listReassessmentApplicants($organisation_id)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'student_reassessment_module'))
			   ->join(array('t2' => 'student'),
					't2.id = t1.student_id', array('first_name', 'middle_name', 'last_name', 'student_id'))
			   ->join(array('t3' => 'academic_modules_allocation'), 
					't1.academic_modules_allocation_id = t3.id', array('module_title', 'module_code', 'module_type', 'academic_session', 'academic_year', 'semester', 'year'))
			   ->join(array('t4' => 'programmes'),
			   't4.id = t3.programmes_id', array('programme_name'));
		$select->where(array('t2.organisation_id' =>$organisation_id));	
		$select->order(array('t1.id DESC'));

		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		return $resultSet->initialize($result);
	}


	public function getReassessmentApplicationDetails($id)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'student_reassessment_module'))
			   ->join(array('t2' => 'academic_modules_allocation'), 
					't1.academic_modules_allocation_id = t2.id', array('module_title', 'module_code', 'module_type', 'academic_session', 'academic_year', 'semester', 'year'));
		$select->where(array('t1.id' =>$id));	

		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		return $resultSet->initialize($result);
	}


	public function getReassessmentAnnouncementPeriod($organisation_id)
	{ 
		$academic_event = 'Recheck/ Re-evaluation Duration';

		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'academic_calendar'))
			   ->join(array('t2' => 'academic_calendar_events'),
			   		't2.id = t1.academic_event', array('academic_event'));
		$select->where(array('t1.from_date <= ? ' => date('Y-m-d')));
		$select->where(array('t1.to_date >= ? ' => date('Y-m-d')));
		$select->where(array('t2.academic_event' => $academic_event));
		$select->where(array('t2.organisation_id'=> $organisation_id));
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		
		//here programme stores both programme id and organisaiton id
		$announcementperiod = array();
		foreach($resultSet as $set)
		{
			$announcementperiod['from_date'] = $set['from_date'];
			$announcementperiod['to_date'] = $set['to_date'];

		}
		return $announcementperiod;
	}


	public function saveReassessmentApplication(Reassessment $reassessmentObject)
	{
		$reassessmentData = $this->hydrator->extract($reassessmentObject);
		unset($reassessmentData['id']);
		//unset($recheckData['recheck_Applicant_Id']);

		$student_no = $this->getStudentNo($reassessmentData['student_Id']); 

		$student_marks = $this->getStudentConsolidedMarks($student_no, $reassessmentData['academic_Modules_Allocation_Id']);

		foreach($student_marks as $key=>$value){
			if($key == 'CA' || $key == 'CA (T)'){
				if($key){
					$CA = $value;
				}else{
					$CA = 0.0;
				}
			}else{
				if($key){
					$SE = $value;
				}else{
					$SE = 0.0;
				}
			}
		}

		/*$reassessmentData['previous_Semester_Marks'] = $CA;
		$reassessmentData['	previous_Ca_Marks'] = $SE;
		$reassessmentData['reassessment_Status'] = 'Pending'; */
		
		if($reassessmentObject->getId()) {
			//ID present, so it is an update
			$action = new Update('student_reassessment_module');
			$action->set($reassessmentData);
			$action->where(array('id = ?' => $reassessmentObject->getId()));
		} else {
			//ID is not present, so its an insert
			$action = new Insert('student_reassessment_module');
			$action->values(array(
				'previous_semester_marks' => $SE,
				'previous_ca_marks' => $CA,
				'reassessment_status' => 'Pending',
				'application_date' => $reassessmentData['application_Date'],
				'academic_modules_allocation_id' => $reassessmentData['academic_Modules_Allocation_Id'],
				'student_id' => $reassessmentData['student_Id']
			));
		}
		
		$sql = new Sql($this->dbAdapter);
		$stmt = $sql->prepareStatementForSqlObject($action);
		$result = $stmt->execute();

		if($result instanceof ResultInterface) {
			if($newId = $result->getGeneratedValue()){
				//when a value has been generated, set it on the object
				echo $reassessmentObject->setId($newId);
			}
			return $reassessmentObject;
		}
		
		throw new \Exception("Database Error");
	}


	public function updateReassessmentModuleStatus($data_to_insert, $organisation_id, $employee_details_id)
	{
		foreach($data_to_insert as $key => $value){ 
			if($value){
				$reassessmentData['payment_Status'] = 'Payment Updated';
				$reassessmentData['payment_Remarks'] = $value;
				$reassessmentData['payment_Status_Updated_By'] = $employee_details_id;			

				$action = new Update('student_reassessment_module');
				$action->set($reassessmentData);
				$action->where(array('id = ?' => $key));

				$sql = new Sql($this->dbAdapter);
				$stmt = $sql->prepareStatementForSqlObject($action);
				$result = $stmt->execute();
			}
			//return;
		}
	}


	public function updateApprovedReassessmentModuleStatus($data_to_insert, $organisation_id, $employee_details_id)
	{
		foreach($data_to_insert as $key => $value){  
			if($value){
				$reassessmentData['reassessment_Status'] = 'Reassessment Approved';
				$reassessmentData['reassessment_Remarks'] = $value;
				$reassessmentData['reassessment_Status_Updated_By'] = $employee_details_id;			

				$action = new Update('student_reassessment_module');
				$action->set($reassessmentData);
				$action->where(array('id = ?' => $key));

				$sql = new Sql($this->dbAdapter);
				$stmt = $sql->prepareStatementForSqlObject($action);
				$result = $stmt->execute();
			}
			//return;
		}
	}



	//Function to get CA and SE marks from consolidated and enter into reassessment table
	public function getStudentConsolidedMarks($student_no, $academic_modules_allocation_id)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'student_consolidated_marks'));
		$select->where(array('t1.student_id' =>$student_no));
        //$select->where(array('t1.academic_year' =>$academic_year));
		$select->where(array('t1.academic_modules_allocation_id' =>$academic_modules_allocation_id));
		//$select->where(array('t1.year' =>$student_year));
		$select->where(array('t1.level' => 'Regular'));
		$select->where(array('t1.result_status' => 'Declared'));
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		
		//here programme stores both programme id and organisaiton id
		$modules = array();
		foreach($resultSet as $set)
		{
			$modules[$set['student_id']][$set['assessment_type']] = $set['marks'];
		} 

		$assessment_marks = array();
		foreach($modules as $key=>$value){
			foreach($value as $key2=>$value2){
				$assessment_marks[$key2] = $value2;
			}
		}
		return $assessment_marks;
	}


	
	/*
	* Get the list of the academic modules for the current semester
	*
	* Takes student id to get the programme id and then the list of modules
	*/
	
	public function getAcademicModules($student_id)
	{
		$programme = $this->getProgrammeId($student_id);
		$student_No = $this->getStudentNo($student_id);
		$programme_id = $programme['programmes_id'];
		$organisation_id = $programme['organisation_id'];
		$semester_details = $this->getSemester($organisation_id);
		
		$semester = $semester_details['academic_event'];
		$academic_year = $semester_details['academic_year'];
		$student_semester_details = $this->getStudentYear($student_id); 
		$student_semester = $student_semester_details['semester_id']; 
		$student_year = $student_semester_details['year_id'];
		
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'academic_modules_allocation'))
				->columns(array('id','module_title','module_code'))
				->join(array('t2' => 'student_consolidated_marks'),
					't2.academic_modules_allocation_id = t1.id', array('level', 'result_status', 'status'));
		$select->where(array('t1.programmes_id' =>$programme_id));
        //$select->where(array('t1.academic_year' =>$academic_year));
		$select->where(array('t2.semester' =>$student_semester));
		$select->where(array('t1.year' =>$student_year));
		$select->where(array('t2.level' => 'Regular'));
		$select->where(array('t2.result_status' => 'Declared'));
		$select->where(array('t2.status' => 'Re-assessment'));
		$select->where(array('t2.student_id' => $student_No));
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		
		//here programme stores both programme id and organisaiton id
		$modules = array();
		foreach($resultSet as $set)
		{
			$modules[$set['id']] = $set['module_title']." (".$set['module_code'].")";
		}
		return $modules;
	}


	public function getTotalModuleList($student_id)
	{
		$programme = $this->getProgrammeId($student_id);
		$student_No = $this->getStudentNo($student_id);
		$programme_id = $programme['programmes_id'];
		$organisation_id = $programme['organisation_id'];
		$semester_details = $this->getSemester($organisation_id);
		
		$semester = $semester_details['academic_event'];
		$academic_year = $semester_details['academic_year'];
		$student_semester_details = $this->getStudentYear($student_id); 
		$student_semester = $student_semester_details['semester_id']; 
		$student_year = $student_semester_details['year_id'];
		
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'academic_modules_allocation'))
				->columns(array('id','module_title','module_code'))
				->join(array('t2' => 'student_consolidated_marks'),
					't2.academic_modules_allocation_id = t1.id', array('level', 'result_status', 'status'));
		$select->where(array('t1.programmes_id' =>$programme_id));
        //$select->where(array('t1.academic_year' =>$academic_year));
		$select->where(array('t2.semester' =>$student_semester));
		$select->where(array('t1.year' =>$student_year));
		$select->where(array('t2.level' => 'Regular'));
		$select->where(array('t2.result_status' => 'Declared'));
		$select->where(array('t2.student_id' => $student_No));
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		
		//here programme stores both programme id and organisaiton id
		$modules = array();
		foreach($resultSet as $set)
		{
			$modules[$set['id']] = $set['module_title']." (".$set['module_code'].")";
		} 
		return $modules;
	}


	public function getStudentNo($id)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'student'))
				->columns(array('student_id'));
		$select->where(array('t1.id' =>$id));
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		
		//here programme stores both programme id and organisaiton id
		$student_no = NULL;
		foreach($resultSet as $set)
		{
			$student_no = $set['student_id'];
		}
		return $student_no;
	}
	
	/*
	* Get the Programme Id of the student
	*/
	
	public function getProgrammeId($student_id)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'student'))
				->columns(array('programmes_id', 'organisation_id'));
		$select->where(array('t1.id' =>$student_id));
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		//here programme stores both programme id and organisaiton id
		$programme = array();
		foreach($resultSet as $set)
		{
			$programme['programmes_id'] = $set['programmes_id'];
			$programme['organisation_id'] = $set['organisation_id'];
		}
		return $programme;
	}
	
	/*
	 * Get the semester from the database
	 */
	
	public function getSemester($organisation_id)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select->from(array('t1' => 'academic_calendar'))
					->columns(array('academic_year'))
				->join(array('t2' => 'academic_calendar_events'), 
						't1.academic_event = t2.id', array('academic_event'));
		$select->where(array('from_date <= ? ' => date('Y-m-d')));
		$select->where(array('to_date >= ? ' => date('Y-m-d')));
		$select->where('t2.organisation_id = ' .$organisation_id);
                
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		
		$semester = NULL;
		
		foreach($resultSet as $set){
			if($set['academic_event'] == 'Autumn Semester Duration'){
				$semester['academic_event'] = 'Autumn';
				$semester['academic_year'] = $set['academic_year'];
			}
			else if($set['academic_event'] == 'Spring Semester Duration'){
				$semester['academic_event'] = 'Spring';
				$semester['academic_year'] = $set['academic_year'];
			}
		}
		return $semester;
	}
        
	/*
	 * Get the academic year based on the semester from the database
	 */
	
	public function getAcademicYear($semester_type)
	{
		$academic_year = NULL;
		
		if($semester_type == 'Autumn'){
			$academic_year = date('Y').'-'.(date('Y')+1);
		} else {
			$academic_year = (date('Y')-1).'-'.date('Y');
		}
		
		return $academic_year;
	}
	
	/*
	* Get the Year of the Student
	*/
	
	private function getStudentYear($student_id)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => 'student_semester_registration'))
				->columns(array('semester_id', 'year_id'))
				->join(array('t2' => 'student'), 
						't1.student_id = t2.id', array('student_id'));
		$select->where(array('t2.id' =>$student_id));
			
		$stmt = $sql->prepareStatementForSqlObject($select);
		$result = $stmt->execute();
		
		$resultSet = new ResultSet();
		$resultSet->initialize($result);
		//here programme stores both programme id and organisaiton id
		$student_year = array();
		foreach($resultSet as $set)
		{
			$student_year['semester_id'] = $set['semester_id'];
			$student_year['year_id'] = $set['year_id'];
		}
		return $student_year;
	}
	
	/**
	* @return array/Reassessment()
	* The following function is for listing data for select/dropdown form
	* For e.g. Need to fill the objectives field with Objectives from the database
	*/
	public function listSelectData($tableName, $columnName, $condition)
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();

		$select->from(array('t1' => $tableName));
		$select->columns(array('id',$columnName)); 
		if($condition != NULL)
		{
			$select->where(array('organisation_id = ?' => $condition));
		}

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
		//this if for Activities for AWPA Activities
		if($tableName == 'awpa_objectives_activity')
		{
			$selectData[0] = 'Others';
		}
		return $selectData;
			
	}
        
}