<?php

require_once dirname(__FILE__).'/../lib/esquemasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/esquemasGeneratorHelper.class.php';

/**
 * esquemas actions.
 *
 * @package    ambiente
 * @subpackage esquemas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class esquemasActions extends autoEsquemasActions
{
    public function executeIndex(sfWebRequest $request)
    {
//         parent::executeIndex($request);
        $this->pager=$this->recu();
        $this->sort=null;
    }
    
    public function recu($esquema_id=null)
    {
        $r=array();
        foreach (EsquemaQuery::create()->orderByOrden()->findByEsquemaId($esquema_id) as $nodo){
            $r[]=(object)array(
                'text'=>$nodo->getNombre(),
                'href'=> $this->getController()->genUrl('esquemas/edit?id='.$nodo->getId()),
                'nodes'=>$this->recu($nodo->getId()),
                'icon'=>'esquema-'.$nodo->getId(),
                'state'=>(object)array('expanded'=> true)
            );
        }
        return count($r)? $r : null;
    }
}
