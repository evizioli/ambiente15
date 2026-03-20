<?php

/**
 * BidSitio filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class BidSitioFormFilter extends BaseBidSitioFormFilter
{
  public function configure()
  {
      $this->widgetSchema['area_protegida']= new sfWidgetFormChoice(array(
          'choices'=>array(''=>'')+ProjectConfiguration::$areas
      ));
      $this->validatorSchema['area_protegida']= new sfValidatorChoice(array(
          'choices'=>array_keys(ProjectConfiguration::$areas)
      ));
  }
}
