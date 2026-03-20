<?php
class CambioClaveForm extends BaseForm {


  public function configure ()
  {
  	parent::configure();
    $this->setWidgets( array(
    	'password_vieja' => new sfWidgetFormInputPassword(),
        'password' => new sfWidgetFormInputPassword(),
        'password_check' => new sfWidgetFormInputPassword()
    ));

    $this->setValidators(
      array('password_vieja' => new sfValidatorString(
        array('required' => true, 'min_length' => 6),
        array('required'   => 'Debe especificar la clave actual', 'min_length' => 'Debe escribir por lo menos 6 carácteres')
      ),

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
		  'password_vieja'    => 'Clave actual',
		  'password'   => 'Clave nueva',
    		'password_check'=>'Repetir clave nueva'
		));

	$this->validatorSchema->setPostValidator( new CambioClaveValidator(array('id_usuario'=>$this->getOption('id_usuario'))));
    $this->widgetSchema->setNameFormat('cambio_clave[%s]');
     
    
  }
}