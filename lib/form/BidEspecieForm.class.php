<?php

/**
 * BidEspecie form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class BidEspecieForm extends BaseBidEspecieForm
{
  public function configure()
  {
      
      $this->widgetSchema['indicador']= new sfWidgetFormChoice(array(
          'choices'=> BidConteoIndicadorPeer::$indicadores,
          'multiple'=>true,
          'expanded'=>true
      ));
      $this->validatorSchema['indicador']= new sfValidatorChoice(array(
          'choices'=>array_keys( BidConteoIndicadorPeer::$indicadores),
          'multiple'=>true,
          'required'=>false
      ));
  }
  
  protected function updateIndicadorColumn($v)
  {
      BidEspecieRelevanciaQuery::create()->filterByBidEspecie($this->getObject())->filterByIndicador($v, criteria::NOT_IN)->delete();
      foreach ($v as $ind){
          if( BidEspecieRelevanciaQuery::create()->filterByBidEspecie($this->getObject())->filterByIndicador($ind)->count()==0 ) {
              $a=new BidEspecieRelevancia();
              $a->setIndicador($ind);
              $this->getObject()->addBidEspecieRelevancia($a);
          }
      }
  }
}
