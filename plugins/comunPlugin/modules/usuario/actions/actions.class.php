<?php

/**
 * usuario actions.
 *
 * @package    sspp_fact_telef
 * @subpackage usuario
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuarioActions extends sfActions
{
	public function executeCheck(sfWebRequest $request)
	{
		$this->form = new ResetClaveForm(array('reset'=>$request->getParameter('reset')));
		

		
		if ($this->getRequest()->isMethod('post')){
			
			$this->form->bind($request->getParameter('reset_password'));
			if ($this->form->isValid()){
				
				$u = UsuarioQuery::create()
					->filterByDeshabilitado(0)
					->findOneByReset($this->form->getValue('reset'));
					
					
				
				$v= $this->form->getValues();
				$u->setClave(md5($v['password']));
				$u->setReset(null);
				$u->save();
				return $this->redirect('principal/index');
			}
		}
	
	}
	
	public function executeReset(sfWebRequest $request)
	{
		$this->form =new OlvidoClaveForm();
		if ($this->getRequest()->isMethod('post'))
		{
			$captcha = array(
					'recaptcha_response_field'  => $request->getParameter('g-recaptcha-response'),
			);

			$this->form->bind(array_merge($request->getParameter('olvido_clave'), array('captcha' => $captcha)));
			
			if($this->form->isValid()){

				$email=$this->form->getValue('email');
				$u=UsuarioQuery::create()->filterByDeshabilitado(0)->findOneByEmail($email);
				
				
				if($u) {
						
					$p=md5( Dummy::random(50) );
						
					$u->setReset($p);
					$u->save();
					
					
					$t=
					"Acceda al siguiente vínculo para proporcionar la nueva clave del usuario %s".$u."%s para utilizar el sistema:\n\n".
					$this->getController()->genUrl('usuario/check?reset='.$p, true);
					
					$m = $this->getMailer()->compose(
							ProjectConfiguration::EMAIL,
							$u->getEmail(),
							ProjectConfiguration::NOMBRE_ENTIDAD.' - Solicitud para restablecer clave de acceso',
							sprintf($t,'','')
						);
					//$m->setReplyTo(ProjectConfiguration::MAILER);
					$m->addPart( nl2br(sprintf($t,'<b>','</b>')), 'text/html' );
						
						
					try {
						$this->getMailer()->send($m);
    					$this->getUser()->setFlash('notice', 'Se ha enviado un correo electrónico con las instrucciones para obtener la nueva clave de acceso.');
    					$this->redirect('usuario/reset');		
						
					} catch ( sfValidatorError $e) {
					
					
					}
									
				} else {
					$this->getUser()->setFlash('notice', 'Se ha enviado un correo electrónico con las instrucciones para obtener la nueva clave de acceso.');
					$this->redirect('usuario/reset');
						
				}
			}
			$this->getUser()->setFlash('error','Error');
		}
	}


	public function executeLogin(sfWebRequest $request)
	{
		$this->redirectIf($this->getUser()->isAuthenticated(),'@homepage');
		$this->oForm = new loginForm(array('referrer' => $request->getUri()));
	}


	public function executeDoLogin(sfWebRequest $request)
	{
		$this->redirectIf($this->getUser()->isAuthenticated(),'@homepage');
		$this->oForm = new loginForm();
		$this->oForm->bind($request->getParameter('login'));
		if ($this->oForm->isValid())
		{
			$values=$this->oForm->getValues();
			$u=UsuarioQuery::create()
				->filterByDeshabilitado(0)
				->filterByEmail($values['username'])
					->_or()
				->filterByNombre($values['username'])
				->findOne();
			$this->getUser()->iniciarSesion($u);
			$this->redirect($values['referrer'] );
		}
		$this->setTemplate('login');
	}
	

	public function executeCambio_clave(sfWebRequest $request)
	{
		$oForm = new CambioClaveForm(array(),array('id_usuario'=>$this->getUser()->getId()));

		if ($this->getRequest()->isMethod('post'))
		{
			$oForm->bind($request->getParameter('cambio_clave'));
			if ($oForm->isValid())
			{
				$aValues = $oForm->getValues();
				$this->getUser()->setClave($aValues['password']);
				$this->redirect('principal/index');
			}
	
		}
		$this->oForm = $oForm; // form to view
	}

	public function executeLogout()
	{
		// Erase auth data
		$this->getUser()->clearCredentials();
		$this->getUser()->getAttributeHolder()->clear();
		$this->getUser()->setAuthenticated(false);
		$this->redirect('@homepage');
	}

}
