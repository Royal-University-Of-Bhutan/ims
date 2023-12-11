<?php

namespace Alumni\Form;

//use AlumniMember\Model\AlumniMember;
use Alumni\Model\AlumniEvent;
use Zend\Form\Fieldset;
//use Zend\Form\AlumniNewRegistrationFieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;


class CreateAlumniEventFieldset extends Fieldset implements InputFilterProviderInterface
{
	public function __construct()
     {
         // we want to ignore the name passed
        parent::__construct('alumnievent');
		
		$this->setHydrator(new ClassMethods(false));
		$this->setObject(new AlumniEvent());
         
         $this->setAttributes(array(
                    'class' => 'form-horizontal form-label-left',
                ));

         $this->add(array(
             'name' => 'id',
              'type' => 'Hidden'  
         ));
        
       $this->add(array(
           'name' => 'batch',
            'type'=> 'Select',
             'options' => array(
                 'class'=>'control-label',
                 'disable_inarray_validator' => true,
                 'empty_option' => 'Select Batch (Graduation Year)',
                 'value_options' => array(
                    'All' => 'All',
                    )
             ),
             'attributes' => array(
                  'class' => 'form-control ',
                  'required' => true,
             ),
         ));

  
           $this->add(array(
           'name' => 'event_name',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
             ),
             'attributes' => array(
                  'class' => 'form-control ',
                  'required' => true,
             ),
         ));
     
         $this->add(array(
           'name' => 'from_date',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
             ),
             'attributes' => array(
                  'class' => 'form-control fa fa-calendar-o',
                  'id' => 'single_cal3',
                  'required' => true,
             ),
         ));
           
          $this->add(array(
           'name' => 'to_date',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
             ),
             'attributes' => array(
                  'class' => 'form-control fa fa-calendar-o',
                  'id' => 'single_cal4',
                  'required' => true,
             ),
         ));
		 $this->add(array(
           'name' => 'organisation_id',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
             ),
             'attributes' => array(
                  'class' => 'form-control ',
             ),
         ));
           
        $this->add(array(
           'name' => 'content',
            'type'=> 'TextArea',
             'options' => array(
                 'class'=>'control-label',
             ),
             'attributes' => array(
                  'class' => 'form-control ',
           'rows' => '4',
             ),
         ));

        $this->add(array(
           'name' => 'alumni_programmes_id',
            'type'=> 'Select',
             'options' => array(
                 'class'=>'control-label',
                 'disable_inarray_validator' => true,
                 'empty_option' => 'Select Programme',
                 'value_options' => array(
                    )
             ),
             'attributes' => array(
                  'class' => 'form-control ',
                  'required' => true,
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
