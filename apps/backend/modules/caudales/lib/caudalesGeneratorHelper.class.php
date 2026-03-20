<?php

/**
 * caudales module helper.
 *
 * @package    ambiente
 * @subpackage caudales
 * @author     Your name here
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class caudalesGeneratorHelper extends BaseCaudalesGeneratorHelper
{
    
    public function linkToNew($params)
    {
        return '<li class="list-inline-item bs_admin_action_new">'.link_to('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar registro', '@'.$this->getUrlForAction('new'),array('title'=>__($params['label'], array(), 'sf_admin'))).'</li>';
    }
    
}
