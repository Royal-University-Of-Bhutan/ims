<?php

namespace StudentContribution\Form;

use StudentContribution\Model\StudentContributionCategory;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class StudentContributionCategoryFieldset extends Fieldset implements InputFilterProviderInterface
{

	public function __construct()
     {
         // we want to ignore the name passed
        parent::__construct('contribution');
		
		$this->setHydrator(new ClassMethods(false));
		$this->setObject(new StudentContributionCategory());
         
         $this->setAttributes(array(
                    'class' => 'form-horizontal form-label-left',
          ));

         $this->add(array(
             'name' => 'id',
              'type' => 'Hidden'  
         ));
		 
		 $this->add(array(
             'name' => 'organisation_id',
              'type' => 'Hidden'  
         ));
          
		 $this->add(array(
           'name' => 'contribution_type',
            'type'=> 'text',
             'options' => array(
                 'class'=>'control-label',
             ),
             'attributes' => array(
                  'class' => 'form-control ',
				  'required' => true
             ),
         ));
		 
		 $this->add(array(
           'name' => 'remarks',
            'type'=> 'textarea',
             'options' => array(
                 'class'=>'control-label',
             ),
             'attributes' => array(
                  'class' => 'form-control ',
             ),
         ));
		 
		 $this->add(array(
			'name' => 'submit',
			 'type' => 'Submit',
				'attributes' => array(
					'value' => 'Submit',
					'id' => 'submitbutton',
                        'class' => 'btn btn-success',
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