<?php

namespace GoodsRequisition\Form;

use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\Form\Form;

class GoodsRequisitionForwardUpdateForm extends Form
{
	public function __construct()
     {
         // we want to ignore the name passed
        parent::__construct('requisitionforwardupdate');
         
         $this
             ->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());

        $this->setAttributes(array(
             'class' => 'form-horizontal form-label-left',
        ));

         $this->add(array(
             'type' => 'GoodsRequisition\Form\GoodsRequisitionForwardUpdateFieldset',
             'options' => array(
                 'use_as_base_fieldset' => true,
             ),
         ));

       $this->add(array(
             'type' => 'Zend\Form\Element\Csrf',
             'name' => 'csrf',
         ));
     }
}