<?php

namespace EmployeeDetail\Form;

use EmployeeDetail\Model\EmployeeEducation;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class EmployeeEducationFieldset extends Fieldset implements InputFilterProviderInterface
{
	public function __construct()
     {
         // we want to ignore the name passed
        parent::__construct('employeeeducation');
		
		$this->setHydrator(new ClassMethods(false));
		$this->setObject(new EmployeeEducation());
         
         $this->setAttributes(array(
                    'class' => 'form-horizontal form-label-left',
                ));

         $this->add(array(
             'name' => 'id',
              'type' => 'Hidden'  
         ));
		 
		 $this->add(array(
			'name' => 'college_name',
			'type' => 'Text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
				),
		));
          
         $this->add(array(
			'name' => 'college_location',
			'type' => 'Text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
				),
		));
                
		$this->add(array(
			'name' => 'college_country',
			'type' => 'Text',
			'options' => array(
				'class' => 'control-label',
			),
			'attributes' =>array(
				'class' => 'form-control',
			),
			
		));
		
		$this->add(array(
			'name' => 'field_study',
			'type' => 'Text',
			'options' => array(
				'class' => 'control-label',
			),
			'attributes' =>array(
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'name' => 'subject_studied',
			'type' => 'Text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
				),
		));
	   
		$this->add(array(
			'name' => 'completion_year',
			'type' => 'date',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'name' => 'result_obtained',
			'type' => 'text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'name' => 'certificate_obtained',
			'type' => 'text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
			),
		));

		$this->add(array(
			'name' => 'remarks',
			'type' => 'text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'name' => 'employee_details_id',
			'type' => 'text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
			),
		));
            
	   $this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'class'=>'control-label',
				'value' => 'Submit',
				'id' => 'submitbutton',
				'class' => 'btn btn-success',
				),
			));
		
		$this->add(array(
			'name' => 'approve',
			'type' => 'Submit',
			'attributes' => array(
				'class'=>'control-label',
				'value' => 'Approve',
				'id' => 'approve',
				'class' => 'btn btn-success',
				),
			));
		
		$this->add(array(
			'name' => 'reject',
			'type' => 'Submit',
			'attributes' => array(
				'class'=>'control-label',
				'value' => 'Reject',
				'id' => 'reject',
				'class' => 'btn btn-danger',
				),
			));


     }
	 
	 /**
      * @return array
      */
     public function getInputFilterSpecification()
     {
         return array(
             'name' => array(
                 'required' => false,
             ),
         );
     }
}