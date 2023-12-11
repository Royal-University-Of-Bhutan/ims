<?php

namespace Planning\Form;

use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\Form\Form;


class BudgetOverlayForm extends Form
{
	public function __construct()
     {
        parent::__construct('add_visionmission');
         
         $this
             ->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter())
         ;
        
        $this->setAttributes(array(
            'class' => 'form-horizontal form-label-left',
        ));
         
        $this->add(array(
             'type' => 'Planning\Form\BudgetOverlayFieldset',
             'options' => array(
                 'use_as_base_fieldset' => true,
             ),
         ));
		 
        $this->add(array(
             'type' => 'Zend\Form\Element\Csrf',
             'name' => 'csrf',
             'options' => array(
                'csrf_options' => array(
                        'timeout' => 600
                )
             )
         ));

         $this->add(array(
             'name' => 'submit',
             'attributes' => array(
                 'type' => 'submit',
                 'value' => 'Send',
             ),
         ));
     }
}
