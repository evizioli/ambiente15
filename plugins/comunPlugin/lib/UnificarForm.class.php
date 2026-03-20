<?php
class UnificarForm extends BaseForm
{
	public function setup()
	{
		$this->setWidgets(array(
			'ids' => new sfWidgetFormInputHidden(),
			'queda_id' => new sfWidgetFormSelectRadio(array(
					'choices'=>$this->getOption('estas',array()),
					'class'=>'paraabajo'
			))
		));
		
		$this->setValidators(array(
			'ids' => new sfValidatorRegex(array('pattern'=>'/^\d+(,\d+)+$/'	)),
			'queda_id'=>new sfValidatorChoice(array('choices'=>array_keys($this->getOption('estas',array()))),array(
					'required'=> 'Debe seleccionar uno de los nombres con el cual quedar&aacute;n unificados los datos'
					))
		));
		
		$this->widgetSchema->setNameFormat('unificar[%s]');
		
		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
		
		parent::setup();
	}
}