<?php

/**
 * BidG5I1 filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class BidG5I1FormFilter extends BaseBidG5I1FormFilter
{
  public function configure()
  {
      
      $this->useFields(array( 'fecha', 'sitio_id'));
      $this->widgetSchema['sitio_id']->setOption('order_by', array('Nombre','asc'));
      $this->widgetSchema['sitio_id']->setAttribute('class', 's2');
      $this->widgetSchema['sitio_id']->setOption('criteria', BidSitioQuery::create()->filterByAreaProtegida(ProjectConfiguration::ANPPV));
      
  }
}
