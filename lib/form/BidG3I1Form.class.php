<?php

/**
 * BidG3I1 form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class BidG3I1Form extends BaseBidG3I1Form
{
  public function configure()
  { 
      $this->widgetSchema['sitio_id']->setOption('order_by', array( 'Nombre', 'asc' ));
        $this->widgetSchema['sitio_id']->setOption('add_empty', true);
        $this->widgetSchema['sitio_id']->setAttribute('class', 's2');
        $this->widgetSchema['sitio_id']->setOption('criteria', BidSitioQuery::create()->filterByAreaProtegida(ProjectConfiguration::PIMCPA));
        
  }
}
