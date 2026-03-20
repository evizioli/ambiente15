<?php
class CambioClaveValidator extends sfValidatorBase
{

  protected function configure($options = array(), $messages = array())
  {

    $this->addRequiredOption('id_usuario');
  }
	
	
	protected function doClean($values)
	{
		extract($values);
		
		$u=UsuarioQuery::create()->findPk($this->getOption('id_usuario'));
		
		if(!$u) throw new sfValidatorError($this, 'Existe un problema con la cuenta del usuario. Comuníquese con el administrador del sistema' );
		if( $u->getClave()!=md5($password_vieja) ) throw new sfValidatorError($this, 'La clave actual no es la especificada' );
		if($password_check!=$password) 	throw new sfValidatorError($this, 'Debe escribir la nueva clave repetida en la segunda y tercera casillas' );
		
		return $values;
		
	}
}
