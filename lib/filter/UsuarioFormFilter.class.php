<?php

/**
 * Usuario filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class UsuarioFormFilter extends BaseUsuarioFormFilter
{
  public function configure()
  {
      $this->widgetSchema['credencial_usuario_list']->setOption('order_by',array('Descripcion','asc'));
      $this->widgetSchema['usuario_grupo_list']->setOption('order_by',array('Nombre','asc'));
      
  }
}
