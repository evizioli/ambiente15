<?php

/**
 * Tolerancia filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class ToleranciaFormFilter extends BaseToleranciaFormFilter
{
  public function configure()
  {
      $this->useFields(array(
          'fecha',
          'tipo',
          'uso_id',
          'normativa'
      ));
      
      $this->widgetSchema['tipo']= new sfWidgetFormChoice(array(
          'choices' => array(''=>'')+ToleranciaPeer::tipos()
      ));
      $this->validatorSchema['tipo']= new sfValidatorChoice(array(
          'choices' => array_keys(ToleranciaPeer::$campos),
          'required'=>false
      ));
      
      $this->widgetSchema['uso_id']->setOption('order_by', array('Nombre','asc'));
      
      
  }
}
