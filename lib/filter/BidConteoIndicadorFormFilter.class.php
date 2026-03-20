<?php

/**
 * BidConteoIndicador filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class BidConteoIndicadorFormFilter extends BaseBidConteoIndicadorFormFilter
{
  public function configure()
  {        
      $this->useFields(array(
            'fecha',
            'sitio_id',
            'especie_id'
        ));
        
        
        $this->widgetSchema['sitio_id']->setOption('order_by', array( 'Nombre', 'asc' ));
        $this->widgetSchema['sitio_id']->setOption('add_empty', true);
        $this->widgetSchema['sitio_id']->setAttribute('class', 's2');
        
        $this->widgetSchema['especie_id']->setOption('order_by', array( 'Nombre', 'asc' ));
        $this->widgetSchema['especie_id']->setOption('add_empty', true);
        $this->widgetSchema['especie_id']->setAttribute('class', 's2');
  }
}
