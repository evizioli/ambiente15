<?php
class myLoginValidator extends sfValidatorBase
{

	protected function doClean($values)
	{
		
		$u=UsuarioQuery::create()
			->filterByDeshabilitado(0)
			->filterByEmail($values['username'])->_or()->filterByNombre($values['username'])
			->findOne();
		
		if($u) {
			if($u->getClave()==md5($values['password']) ){
			
				return $values;
			}
		}
		throw new sfValidatorError($this, 'El usuario y/o contrase&ntilde;a son incorrectos' );
	}
}
