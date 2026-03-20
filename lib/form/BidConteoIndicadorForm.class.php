<?php

/**
 * BidConteoIndicador form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class BidConteoIndicadorForm extends BaseBidConteoIndicadorForm
{
  public function configure()
  { 
        $this->widgetSchema['sitio_id']->setOption('order_by', array( 'Nombre', 'asc' ));
        $this->widgetSchema['sitio_id']->setOption('add_empty', true);
        $this->widgetSchema['sitio_id']->setAttribute('class', 's2');
      
        $this->widgetSchema['especie_id']->setOption('order_by', array( 'Nombre', 'asc' ));
        $this->widgetSchema['especie_id']->setOption('add_empty', true);
        $this->widgetSchema['especie_id']->setAttribute('class', 's2');
      
        unset($this['indicador']);
  }
}
