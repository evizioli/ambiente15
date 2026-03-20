<?php

/**
 * Kml filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class KmlFormFilter extends BaseKmlFormFilter
{
  public function configure()
  {
      $this->useFields(array('nombre', 'esquema_id'));
//       $this->widgetSchema['tipo']= new sfWidgetFormChoice(array('choices'=>array(''=>'')+KmlPeer::$tipos));
//       $this->validatorSchema['tipo']= new sfValidatorChoice(array('choices'=>array_keys(KmlPeer::$tipos),'required'=>false));
  
      
      $this->widgetSchema['esquema_id']->setOption('order_by', array('Nombre','asc'));
      $this->widgetSchema['esquema_id']->setAttribute('class', 's2');
      
  
  }
}
