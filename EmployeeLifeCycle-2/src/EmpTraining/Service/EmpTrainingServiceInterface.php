<?php

namespace EmpTraining\Service;

use EmpTraining\Model\TrainingDetails;
use EmpTraining\Model\workshopDetails;
use EmpTraining\Model\TrainingNomination;
use EmpTraining\Model\ShortTermApplication;
use EmpTraining\Model\LongTermApplication;
use EmpTraining\Model\TrainingReport;
use EmpTraining\Model\StudyReport;
use EmpTraining\Model\StudyExtension;
use EmpTraining\Model\HrLongTermApplication;

//need to add more models

interface EmpTrainingServiceInterface
{
	/**
	* @param int/String $id
	* @return array Employee Details
	* @throws \InvalidArgumentException
	*/
	
	public function findEmpDetails($id);
	
	/*
	 * Get the Organisation Id
	 */
	 
	public function getOrganisationId($username);
	
	/*
	* take username and returns employee details id
	*/
	
	public function getUserDetailsId($username);
	
	/*
	* take username and returns Name and any other detail required
	*/
	
	public function getUserDetails($username, $tableName);
	  
	public function getUserImage($username, $usertype);
	
	/**
	 * Should return a set of all proposals that we can iterate over. 
	 *
	 * @return array|EmpTrainingInterface[]
	*/
	
	public function listAll($tableName);
	
	/*
	* List all training details
	*/
	
	public function listTrainingDetails($table_name, $organisation_id);
	
	/**
	 * Should return a set of all proposals that we can iterate over. 
	 *
	 * @return array|HRD Plan Model[]
	*/
	
	public function listHrdPlan($type, $organisation_id);


	public function listAdhocTrainingList($type, $organisation_id);

	public function getAdhocTrainingDetails($type, $id);
	
	public function getAdhocTrainingNomination($id, $type);
	
	public function deleteAdhocTraining($id, $type);
	
	/**
	 * Should return hrd plan 
	 *
	 * @return array|HRD Plan Model[]
	*/
	
	public function findPlanDetail($id);
	 
	 /**
	 * @param EmpTrainingInterface $trainingObject
	 *
	 * @param EmpTrainingInterface $trainingObject
	 * @return EmpTrainingInterface
	 * @throws \Exception
	 */
	 
	 public function save(TrainingDetails $trainingObject, $category, $type);
	 
	 /**
	 * @param EmpTrainingInterface $trainingObject
	 *
	 * @param EmpTrainingInterface $trainingObject
	 * @return EmpTrainingInterface
	 * @throws \Exception
	 */
	 
	 public function saveShortTermTraining(WorkshopDetails $trainingObject);
	 
	 /*
	 * Save Training Nominations
	 */
	
	 public function saveTrainingNomination(TrainingNomination $trainingObject);
	 
	 /*
	 * Save Long Term application form submitted by staff for training
	 */
	 
	 public function saveLongTermApplication(LongTermApplication $trainingObject);

	 public function updateEditedLongTermApplication(LongTermApplication $trainingObject);

	 public function updateEditedShortTermApplication(ShortTermApplication $trainingObject);

	 public function updateLongTermApplication(HrLongTermApplication $trainingObject);
	 
	 /*
	 * Save Short Term application form submitted by staff for training
	 */
	 
	 public function saveShortTermApplication(ShortTermApplication $trainingObject);
         
         /*
	 * Save Short Term application form submitted by HR Officer
	 */
	 
	 public function updateShortTermApplication(ShortTermApplication $trainingObject, $data_to_check);
	 
	 /*
	 * Save Short Term Training Report
	 */
	 
	 public function saveTrainingReport(TrainingReport $trainingObject);
         
         /*
	 * Save Long Term Training/Study Report
	 */
	 
	 public function saveStudyReport(StudyReport $trainingObject);
         
         /*
	 * Save Study Extension Request
	 */
	 
	 public function saveStudyExtensionRequest(StudyExtension $trainingObject);
	 
	 /*
	 * List Employees to be nominated
	 */
	
	 public function getEmployeeList($empName, $empId, $department, $organisation_id);
	 
	 /*
	 * Get the list of trainings that an employee is nominated for
	 * should only see training list that he/she has been nominated for
	 */
	 
	 public function getNominatedTrainingList($tableName, $employee_details_id);

	 public function getAppliedTrainingDetails($id, $training_type, $employee_details_id);

	 public function getAppliedTrainingList($type, $employee_details_id);
	 
	 /*
	 * Get the list of nominations for a training or workshop
	 * takes the training id as its argument
	 */
	 
	 public function getTrainingNominations($id, $training_type, $training_status);

	 public function crossCheckTrainingReport($id, $training_type);
	 
	 /*
	 * Get the list of employees that have gone for training
	 */
	 
	 public function getTrainingList($table_name, $organisation_id);

	 public function getTraineeList($id, $tableName, $organisation_id);

	 public function getUpdatedStudyReportList($id, $tableName);
	 
	 /*
	 * Get the details for the training for a given ID
	 * Used when displaying the documents submitted for training
	 */
	 
	 public function getTrainingDetails($id, $training_type, $status);
	 
	 /*
	 * Get the details for the training report for a given ID
	 */
	 
	 public function getTrainingReportDetails($id, $training_type);

	 public function getNomineeDetail($employee_details_id);

	 public function getAuthorityEmail($organisation_id);

	 public function getTrainingNominationDetails($training_details_id, $type, $id);
	 
	 /*
	 * Cross Check whether Employee has already applied
	 */
	 
	 public function crossCheckTrainingApplication($employee_id, $training_id, $training_type);

	 public function getLongTermApplicantDetails($id);
	 
	 public function getTrainingNominationId($training_id, $category, $employee_details_id);
	 
	 /*
	 * Get the location of the file name 
	 */
	 
	 public function getFileName($training_id, $column_name, $training_type);
	 
	 /**
	 * Should return a set of all objectives that we can iterate over. 
	 * 
	 * The purpose of the function is the objectives for the dropdown select list
	 *
	 * @return array|EmpTrainingInterface[]
	*/
	
	 public function listSelectData($tableName, $columnName);
		
		
}