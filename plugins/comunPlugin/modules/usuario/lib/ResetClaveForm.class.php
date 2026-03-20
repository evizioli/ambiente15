<?php
class ResetClaveForm extends BaseForm {


	public function configure ()
	{
		parent::configure();
		$this->setWidgets( array(
    	'reset'=>new sfWidgetFormInputHidden(),
        'password' => new sfWidgetFormInputPassword(),
        'password_check' => new sfWidgetFormInputPassword()
		));

		$this->setValidators(
		array(
		'reset'=>new sfValidatorPropelChoice( array(
      		'model'=>'Usuario',
			'column'=>'reset'
      		),array(
      			'invalid'=>'Revise su cuenta de correo electr&oacute;nico para ver si ha recibido un mensaje para corroborar la solicitud de cambio de clave'
      		)),
      'password' => new sfValidatorString(
        array('required' => true, 'min_length' => 6),
        array('required'   => 'Debe especificar la nueva clave', 'min_length' => 'Debe escribir por lo menos 6 carácteres')

        ),
      'password_check' => new sfValidatorString(
        array('required' => true, 'min_length' => 6),
        array('required'   => 'Debe volver a escribir la nueva clave', 'min_length' => 'Debe escribir por lo menos 6 carácteres')
        )
        ));

        $this->widgetSchema->setLabels(array(
		  'password'   => 'Clave nueva',
    		'password_check'=>'Repetir clave nueva'
    		));

    		$this->validatorSchema->setPostValidator( new sfValidatorSchemaCompare('password','==', 'password_check', array(),array('invalid'=>'Debe escribir la misma clave en ambos casilleros')) );
    		$this->widgetSchema->setNameFormat('reset_password[%s]');
    		 

	}
}