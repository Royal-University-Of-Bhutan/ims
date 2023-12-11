<?php

namespace EmpTraining\Model;

class LongTermApplication
{
	protected $id;
	protected $audit_clearance;
	protected $security_clearance;
	protected $medical_certificate;
	protected $course_content_schedule;
	protected $acceptance_letter;
	protected $award_letter;
	protected $understanding_letter;
	protected $departure_intimidation_form;
	protected $predeparture_briefing_form;
	protected $understanding_secondment;
	protected $professional_development_report;
	protected $employee_details_id;
	protected $training_details_id;
	 	 
	public function getId()
	{
		return $this->id;
	}
	 
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function getAudit_Clearance()
	{
		return $this->audit_clearance;
	}
	
	public function setAudit_Clearance($audit_clearance)
	{
		$this->audit_clearance = $audit_clearance;
	}
	
	public function getSecurity_Clearance()
	{
		return $this->security_clearance;
	}
	
	public function setSecurity_Clearance($security_clearance)
	{
		$this->security_clearance = $security_clearance;
	}
	
	public function getMedical_Certificate()
	{
		return $this->medical_certificate;
	}
	
	public function setMedical_Certificate($medical_certificate)
	{
		$this->medical_certificate = $medical_certificate;
	}
	
	public function getCourse_Content_Schedule()
	{
		return $this->course_content_schedule;
	}
	
	public function setCourse_Content_Schedule($course_content_schedule)
	{
		$this->course_content_schedule = $course_content_schedule;
	}
	
	public function getAcceptance_Letter()
	{
		return $this->acceptance_letter;
	}
	
	public function setAcceptance_Letter($acceptance_letter)
	{
		$this->acceptance_letter = $acceptance_letter;
	}
	
	public function getAward_Letter()
	{
		return $this->award_letter;
	}
	
	public function setAward_Letter($award_letter)
	{
		$this->award_letter = $award_letter;
	}
	
	public function getUnderstanding_Letter()
	{
		return $this->understanding_letter;
	}
	
	public function setUnderstanding_Letter($understanding_letter)
	{
		$this->understanding_letter = $understanding_letter;
	}
	
	public function getDeparture_Intimidation_Form()
	{
		return $this->departure_intimidation_form;
	}
	
	public function setDeparture_Intimidation_Form($departure_intimidation_form)
	{
		$this->departure_intimidation_form = $departure_intimidation_form;
	}
	
	public function getProfessional_Development_Report()
	{
		return $this->professional_development_report;
	}
	
	public function setProfessional_Development_Report($professional_development_report)
	{
		$this->professional_development_report = $professional_development_report;
	}
	
	public function getPredeparture_Briefing_Form()
	{
		return $this->predeparture_briefing_form;
	}
	
	public function setPredeparture_Briefing_Form($predeparture_briefing_form)
	{
		$this->predeparture_briefing_form = $predeparture_briefing_form;
	}
	
	public function getUnderstanding_Secondment()
	{
		return $this->understanding_letter;
	}
	
	public function setUnderstanding_Secondment($understanding_letter)
	{
		$this->understanding_letter = $understanding_letter;
	}
	
	public function getEmployee_Details_Id()
	{
		return $this->employee_details_id;
	}
	
	public function setEmployee_Details_Id($employee_details_id)
	{
		$this->employee_details_id = $employee_details_id;
	}
	
	public function getTraining_Details_Id()
	{
		return $this->training_details_id;
	}
	
	public function setTraining_Details_Id($training_details_id)
	{
		$this->training_details_id = $training_details_id;
	}
}