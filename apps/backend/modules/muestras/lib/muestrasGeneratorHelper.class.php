<?php

/**
 * muestras module helper.
 *
 * @package    ambiente
 * @subpackage muestras
 * @author     Your name here
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class muestrasGeneratorHelper extends BaseMuestrasGeneratorHelper
{
    
    public function linkToEdit($object, $params)
    {
        $gm=array_keys( UsuarioGrupoQuery::create()->findByUsuarioId($object->getCreatedBy())->toArray('GrupoId'));
        $gu=array_keys( UsuarioGrupoQuery::create()->findByUsuarioId( sfContext::getInstance()->getUser()->getId())->toArray('GrupoId'));
//         echo $object->getMostrar();
//         echo '<hr>';
//         echo count(array_intersect($gm, $gu))>0;
        if( sfContext::getInstance()->getUser()->hasCredential('muestras_abm') && (($object->getMostrar()==0 &&  count(array_intersect($gm, $gu))>0) || sfContext::getInstance()->getUser()->hasCredential('muestra_ver_todas')) ){
            return '<li class="list-inline-item bs_admin_action_edit">'.link_to('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>', $this->getUrlForAction('edit'), $object, array('title'=>__($params['label'], array(), 'sf_admin'))).'</li>';
        }
    }
    
}
