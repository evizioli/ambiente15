<?php

require_once dirname(__FILE__).'/../lib/usuariosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/usuariosGeneratorHelper.class.php';

/**
 * usuarios actions.
 *
 * @package    ambiente
 * @subpackage usuarios
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class usuariosActions extends autoUsuariosActions
{
    
    public function executeListReset(sfWebRequest $request)
    {
        $u = $this->getRoute()->getObject();
        $u->resetAndEmail();
        $this->getUser()->setFlash('notice','Se envió un email al usuario '.$u->getNombre());
        $this->redirect('usuarios/index');
        
    }
}
