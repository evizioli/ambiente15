<?php
class CuitValidator extends sfValidatorInteger
{
	protected function configure($options = array(), $messages = array())
	{

		$this->setMessage('invalid', '"%value%" no es un C.U.I.T. o C.U.I.L. v&aacute;lido');
	}

	protected function doClean($strCuit)
	{

		if( Dummy::es_cuit($strCuit) ) return $strCuit;
		throw new sfValidatorError($this, 'invalid', array('value' => $strCuit));
	  

	}
}
