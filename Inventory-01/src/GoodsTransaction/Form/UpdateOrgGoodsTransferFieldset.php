<?php
namespace GoodsTransaction\Form;

use GoodsTransaction\Model\GoodsTransaction;
use GoodsTransaction\Model\OrgGoodsTransfer;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class UpdateOrgGoodsTransferFieldset extends Fieldset implements InputFilterProviderInterface
{
	public function __construct()
     {
         // we want to ignore the name passed
        parent::__construct('updateorggoodstransfer');
		
		$this->setHydrator(new ClassMethods(false));
		$this->setObject(new OrgGoodsTransfer());
         
         $this->setAttributes(array(
                    'class' => 'form-horizontal form-label-left',
                ));

         $this->add(array(
             'name' => 'id',
             'attributes' => array(
             'type' => 'Hidden',
              ),   
         ));


         $this->add(array(
           'name' => 'organisation_from_id',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'required' => 'required',
             ),
         ));

         $this->add(array(
           'name' => 'employee_details_from_id',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'required' => 'required',
             ),
         ));

         $this->add(array(
           'name' => 'organisation_to_id',
            'type'=> 'Select',
             'options' => array(
                 'class'=>'control-label',
                 'disable_inarray_validator' => true,
                 'empty_option' => 'Select Organisation',
                 'value_options' => array(
                    ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'required' => 'required',
             ),
         ));

         $this->add(array(
           'name' => 'employee_details_to_id',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                 // 'required' => 'required',
             ),
         ));         

         $this->add(array(
           'name' => 'organisation_goods_id',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'required' => 'required',
             ),
         ));

         $this->add(array(
           'name' => 'transfer_date',
            'type'=> 'Date',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control ',
                  'readonly' => 'readonly',
             ),
         ));

        $this->add(array(
           'name' => 'approve_date',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control ',
                  'readonly' => 'readonly',
             ),
         )); 
         
         $this->add(array(
           'name' => 'transfer_status',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'required' => 'required',
             ),
         ));

         $this->add(array(
           'name' => 'transfer_quantity',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'required' => 'required',
             ),
         ));

         $this->add(array(
           'name' => 'transfer_remarks',
            'type'=> 'Textarea',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control ',
                  'rows' => '5',
                  'readonly' => 'readonly',
             ),
         ));

        $this->add(array(
           'name' => 'approve_remarks',
            'type'=> 'Textarea',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control ',
                  'rows' => '5',
             ),
         ));

         $this->add(array(
           'name' => 'item_name',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'readonly' => 'readonly',
             ),
         )); 

         $this->add(array(
           'name' => 'organisation_name',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'readonly' => 'readonly',
             ),
         ));

         $this->add(array(
           'name' => 'item_received_purchased_id',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'readonly' => 'readonly',
             ),
         ));

         $this->add(array(
           'name' => 'item_received_donation_id',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'readonly' => 'readonly',
             ),
         ));


         $this->add(array(
           'name' => 'item_specification',
            'type'=> 'Textarea',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'rows' => '5',
                  'readonly' => 'readonly',
             ),
         ));

          $this->add(array(
           'name' => 'item_received_type',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'readonly' => 'readonly',
             ),
         ));

           $this->add(array(
           'name' => 'item_purchasing_rate',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'readonly' => 'readonly',
             ),
         ));

           $this->add(array(
           'name' => 'item_received_transfered_id',
            'type'=> 'Text',
             'options' => array(
                 'class'=>'control-label',
                      'value_options' => array(
                 ),
             ),
             'attributes' => array(
                  'class' => 'form-control',
                  'readonly' => 'readonly',
             ),
         ));

           


        $this->add(array(
        'name' => 'submit',
        'type' => 'Submit',
        'attributes' => array(
                                    'class'=>'control-label',
          'value' => 'Save',
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