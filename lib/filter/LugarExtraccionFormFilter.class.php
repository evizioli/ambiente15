<?php

/**
 * LugarExtraccion filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class LugarExtraccionFormFilter extends BaseLugarExtraccionFormFilter
{
  public function configure()
  {
      
      $this->useFields(array(
          'nombre',
          'localidad_id',
          'lugar_uso_list',
            'tipo_id'    
      ));
      $this->widgetSchema['localidad_id']->setAttribute('class', 's2');
      $this->widgetSchema['localidad_id']->setOption('order_by', array('Nombre','asc'));
      $this->widgetSchema['lugar_uso_list']->setOption('order_by', array('Nombre','asc'));
      $this->widgetSchema['tipo_id']->setOption('order_by', array('Nombre','asc'));
      
      
  }
}
