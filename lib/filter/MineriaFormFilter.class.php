<?php

/**
 * Mineria filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class MineriaFormFilter extends BaseMineriaFormFilter
{
  public function configure()
  {
      $this->useFields(array('nombre','categoria'));
      $this->widgetSchema['categoria']= new sfWidgetFormChoice(array(
          'choices'=>array(''=>'')+MineriaPeer::$categorias,
          'translate_choices'=>false,
      ));
      $this->validatorSchema['categoria']= new sfValidatorPass(array(
          'required'=>false
      ));
  }
}
