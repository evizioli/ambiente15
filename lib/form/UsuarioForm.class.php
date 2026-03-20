<?php

/**
 * Usuario form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class UsuarioForm extends BaseUsuarioForm
{
  public function configure()
  {
      $this->useFields(array(
          'nombre',
          'email',
          'admin',
          'deshabilitado',
          'usuario_grupo_list',
          'credencial_usuario_list'
      ));
      $this->widgetSchema['credencial_usuario_list']->setOption('expanded',true);
      $this->widgetSchema['credencial_usuario_list']->setOption('order_by',array('Descripcion','asc'));
      $this->widgetSchema['usuario_grupo_list']->setOption('expanded',true);
      $this->widgetSchema['usuario_grupo_list']->setOption('order_by',array('Nombre','asc'));
      
      $this->widgetSchema->setHelp('credencial_usuario_list', 'Se aconseja vincular al usuario con grupos para la asignación de permisos. Agregue permisos específicos directamente al usuario solamente en casos especiales y/o cuando el permiso reuerido no esté asignado a un grupo');
 
      
  }
}
