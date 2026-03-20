<?php

/**
 * Grupo filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class GrupoFormFilter extends BaseGrupoFormFilter
{
  public function configure()
  {
      $this->widgetSchema['credencial_grupo_list']->setOption('order_by',array('Descripcion','asc'));
      $this->widgetSchema['usuario_grupo_list']->setOption('order_by',array('Nombre','asc'));
      $this->widgetSchema['grupo_localidad_list']->setOption('order_by',array('Nombre','asc'));
      
  }
}
