<?php

namespace RepeatModules\Form;

use RepeatModules\Model\RepeatModules;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class RepeatModulesFieldset extends Fieldset implements InputFilterProviderInterface
{
	public function __construct()
     {
         // we want to ignore the name passed
        parent::__construct('repeatmodules');
		
		$this->setHydrator(new ClassMethods(false));
		$this->setObject(new RepeatModules());
         
         $this->setAttributes(array(
                    'class' => 'form-horizontal form-label-left',
                ));

        $this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		
		$this->add(array(
			'name' => 'student_id',
			'type' => 'Text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
				),
		));
		
		$this->add(array(
			'name' => 'academic_modules_allocation_id',
			'type' => 'Text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
				),
		));
		
		$this->add(array(
			'name' => 'previous_ca_marks',
			'type' => 'Text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
				),
		));
		
		$this->add(array(
			'name' => 'previous_semester_marks',
			'type' => 'text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
				),
		));
              
		$this->add(array(
			'name' => 'backlog_semester',
			'type' => 'Text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
				),
		));
		
		$this->add(array(
			'name' => 'payment_status',
			'type' => 'Text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
				),
		));
								
		$this->add(array(
			'name' => 'application_date',
			'type' => 'Text',
			'options' => array(
				'class' => 'control-label',
				),
			'attributes' =>array(
				'class' => 'form-control',
				'readonly' => true
				),
		));
		
		$this->add(array(
           'name' => 'agreement',
            'type'=> 'checkbox',
             'options' => array(
                'class'=>'control-label',
				'use_hidden_element' => true,
				'checked_value' => 'no',
				),
			'attributes' => array(
				'class' => 'flat',
				'value' => 'yes',
				'required' => true
			)
		));
		
		$this->add(array(
			'name' => 'status',
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