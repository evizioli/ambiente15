<?php

/**
 * Tolerancia form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class ToleranciaForm extends BaseToleranciaForm
{
  public function configure()
  {
      $this->useFields(array(
          
          'fecha',
          'tipo',
          'maximo',
          'uso_id',
          'normativa'
      ));
      
      $this->widgetSchema['tipo']= new sfWidgetFormChoice(array(
          'choices' => array(''=>'')+ToleranciaPeer::tipos()
      ));
      $this->validatorSchema['tipo']= new sfValidatorChoice(array(
          'choices' => array_keys(ToleranciaPeer::$campos),
      ));

      $this->widgetSchema['uso_id']->setOption('add_empty', '(Seleccionar...)');
      $this->widgetSchema['uso_id']->setOption('order_by', array('Nombre','asc'));
      
      
  }
}
