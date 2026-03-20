<?php

/**
 * BidG1I1 filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class BidG1I1FormFilter extends BaseBidG1I1FormFilter
{
  public function configure()
  {
      
      $this->useFields(array( 'fecha', 'sitio_id', 'ambiente'));
      $this->widgetSchema['ambiente']= new sfWidgetFormChoice(array(
          'choices'=>array(''=>'')+BidG1I1Peer::$ambientes
      ));
      $this->validatorSchema['ambiente']= new sfValidatorChoice(array(
          'choices'=>array_keys(BidG1I1Peer::$ambientes),
          'required'=>false
      ));
      $this->widgetSchema['sitio_id']->setAttribute('class', 's2');
      $this->widgetSchema['sitio_id']->setOption('order_by', array('Nombre','asc'));
      $this->widgetSchema['sitio_id']->setOption('criteria', BidSitioQuery::create()->filterByAreaProtegida(ProjectConfiguration::PIMCPA));
  }
}
