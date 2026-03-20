<?php

/**
 * Tratamiento filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class TratamientoFormFilter extends BaseTratamientoFormFilter
{
  public function configure()
  {
      $this->widgetSchema['tipo']= new sfWidgetFormChoice(array(
          'choices'=>array(''=>'')+TratamientoPeer::$tipos
      ));
      $this->validatorSchema['tipo']= new sfValidatorChoice(array(
          'choices'=>array_keys(TratamientoPeer::$tipos),
          'required'=>false
      ));
  }
}
