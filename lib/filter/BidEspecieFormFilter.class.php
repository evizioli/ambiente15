<?php

/**
 * BidEspecie filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class BidEspecieFormFilter extends BaseBidEspecieFormFilter
{
  public function configure()
  {
      $this->useFields(array(
          'nombre'
      ));
      
      $this->widgetSchema['indicador']= new sfWidgetFormChoice(array(
          'choices'=>array(''=>'')+BidConteoIndicadorPeer::$indicadores
      ));
      $this->validatorSchema['indicador']= new sfValidatorChoice(array(
          'choices'=>array_keys( BidConteoIndicadorPeer::$indicadores),
          'required'=>false
      ));
  }
  protected function addIndicadorColumnCriteria(BidEspecieQuery $c, $field, $value)
  {
      $c->useBidEspecieRelevanciaQuery()->filterByIndicador($value)->endUse();
  }
}
