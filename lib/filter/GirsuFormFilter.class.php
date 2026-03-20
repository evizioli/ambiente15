<?php

/**
 * Girsu filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class GirsuFormFilter extends BaseGirsuFormFilter
{
  public function configure()
  {
      $this->widgetSchema['tipo']= new sfWidgetFormChoice(array(
          'choices'=>array(''=>'')+GirsuPeer::$tipos
      ));
      $this->validatorSchema['tipo']= new sfValidatorChoice(array(
          'choices'=>array_keys(GirsuPeer::$tipos),
          'required'=>false
      ));
  }
}
