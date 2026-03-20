<?php
class OlvidoClaveForm extends BaseForm {

	public function configure ()
	{
		parent::configure();
		
		
// 		define ( 'RECAPTCHA_PUBLIC_KEY', '6LfqSw8aAAAAAMRwmyriVXRTKQyIf_5n5gpM_VHN' );
// 		define ( 'RECAPTCHA_PRIVATE_KEY', '6LfqSw8aAAAAAJkMx0klADXgaPEZqz3HiH7PnavS' );
		define ( 'RECAPTCHA_PUBLIC_KEY', '6Lc1hzsaAAAAADTOASimU2uboClpHH2F4vc5LTNS' );   //riego
		define ( 'RECAPTCHA_PRIVATE_KEY', '6Lc1hzsaAAAAAHF862hov69W1Cso03-NLmnr9UIx' );   //riego
		
		
		
		$this->setWidgets( array(
	    	'email'=>new sfWidgetFormInputText(),
		    'captcha' => sfContext::getInstance()->getConfiguration()->getEnvironment()=='dev' ? new sfWidgetFormInputText() : new sfWidgetFormReCaptcha(array( 'public_key' => RECAPTCHA_PUBLIC_KEY  ))
		));

		$this->setValidators(
		array(
		'email'=>new sfValidatorEmail(array('required'=>true), array(
				'required'=>'Debe proveer una dirección de correo electrónico válida',
				'invalid'=>'Debe proveer una dirección de correo electrónico válida'
			)),
		    'captcha' =>sfContext::getInstance()->getConfiguration()->getEnvironment()=='dev' ? new sfValidatorPass(array('required'=>false)): new sfValidatorReCaptcha(array(
							'private_key' => RECAPTCHA_PRIVATE_KEY
						),array(
							'captcha'=> 'Debe seleccionar los casilleros correctos',
							'server_problem'=> 'Error de conexi&oacute;n, no es posible validar el texto ingresado'
					))
        ));

        $this->widgetSchema->setLabels(array(
		  'email'   => 'email',
    		'captcha'=>'Verificación humana'
    		));
   		$this->widgetSchema->setNameFormat('olvido_clave[%s]');
    		 

	}
}