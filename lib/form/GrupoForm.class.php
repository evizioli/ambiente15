<?php

/**
 * Grupo form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class GrupoForm extends BaseGrupoForm
{
  public function configure()
  {
      $this->widgetSchema['credencial_grupo_list']->setOption('expanded',true);
      $this->widgetSchema['credencial_grupo_list']->setOption('order_by',array('Descripcion','asc'));
      $this->widgetSchema['usuario_grupo_list']->setOption('expanded',true);
      $this->widgetSchema['usuario_grupo_list']->setOption('order_by',array('Nombre','asc'));
      $this->widgetSchema['grupo_localidad_list']->setOption('expanded',true);
      $this->widgetSchema['grupo_localidad_list']->setOption('order_by',array('Nombre','asc'));
      $this->widgetSchema['grupo_tipo_list']->setOption('expanded',true);
      $this->widgetSchema['grupo_tipo_list']->setOption('order_by',array('Nombre','asc'));
  }
}
