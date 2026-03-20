<?php
class loginForm extends BaseForm {

  public function setup ()
  {
    $this->setWidgets(
      array('username' => new sfWidgetFormInput(array(), array('id' => 'username', 'autofocus'=>'autofocus'  )),
            'password' => new sfWidgetFormInputPassword(array(), array('id' => 'password' )),
            'referrer' => new sfWidgetFormInputHidden(array(), array('id' => 'referrer')),
    ));

    $this->setValidators(
      array('username' => new sfValidatorString(
        array('min_length' => 3, 'max_length' => 50, 'required'   => true),
        array('min_length' => 'El nombre de usuario es demasiado corto',
              'max_length' => 'El nombre de usuario es demasiado largo',
              'required'   => 'Debe especificar el usuario'
        
      )),

      'password' => new sfValidatorString(
        array('required' => true),
        array('required'   => 'Debe especificar una contrase&ntilde;a')
      ),
      'referrer' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setLabels(array(
		  'username'    => 'Usuario',
		  'password'   => 'Clave',
		));

	$this->validatorSchema->setPostValidator( new myLoginValidator());
    $this->widgetSchema->setNameFormat('login[%s]');
     
    
  }
}