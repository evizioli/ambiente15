<?php
class sfValidatorEmailList extends sfValidatorString
{
	protected function configure($options = array(), $messages = array())
	{
		parent::configure($options,$messages);
		$this->addOption('separador', array('\s',',',';'));
		$this->addMessage('separador', 'Debe especificar una o más direcciones de correo electrónico válidas, separaradas por %separador%');


		$this->setMessage('invalid', '"%value%" No se reconoce como dirección de correo electrónito.');
	}
	
	protected function doClean($value)
	{
		$regex = '/['.join('', $this->getOption('separador')).']/';
		$a = preg_split($regex, $value);
		if($a===false) {
			$aux = $this->getOption('separator');
			$sep = array_pop($aux);
			if(count($aux)>0) $sep = array_pop($aux).' ó '.$sep;
			if(count($aux)>0) $sep = join(', ',$aux).', '.$sep;
			$sep= strtr($sep, '\s', 'espacio');
			throw new sfValidatorError($this, 'separador',array('separador'=>$sep));
		}
		
		$r=array();
		foreach ($a as $email){
			if(!(filter_var(trim($email), FILTER_VALIDATE_EMAIL) || empty($email))){
				$r[]=$e; 
			}
		}
				
		if(count($r)>0) {
			
			throw new sfValidatorError($this, 'invalid',array('value'=>join(' ó ',$r)));
		}
		return $value;	
	}
}