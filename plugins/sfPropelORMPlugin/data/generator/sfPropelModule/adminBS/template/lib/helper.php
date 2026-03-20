[?php

/**
 * <?php echo $this->getModuleName() ?> module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 */
abstract class Base<?php echo ucfirst($this->getModuleName()) ?>GeneratorHelper extends sfModelGeneratorHelper
{
  public function getUrlForAction($action)
  {
    return 'list' == $action ? '<?php echo $this->params['route_prefix'] ?>' : '<?php echo $this->params['route_prefix'] ?>_'.$action;
  }

  public function linkToMoveUp($object, $params)
  {
    if ($object->isFirst())
    {
      return '<li class="list-inline-item bs_admin_action_moveup disabled"><span>'.__($params['label'], array(), 'sf_admin').'</span></li>';
}

    if (empty($params['action']))
    {
      $params['action'] = 'moveUp';
    }

    return '<li class="list-inline-item bs_admin_action_moveup">'.link_to(__($params['label'], array(), 'sf_admin'), '<?php echo $this->params['route_prefix'] ?>/'.$params['action'].'?<?php echo $this->getPrimaryKeyUrlParams('$object', true); ?>).'</li>';
  }

  public function linkToMoveDown($object, $params)
  {
    if ($object->isLast())
    {
      return '<li class="list-inline-item bs_admin_action_movedown disabled"><span>'.__($params['label'], array(), 'sf_admin').'</span></li>';
    }

    if (empty($params['action']))
    {
      $params['action'] = 'moveDown';
    }

    return '<li class="list-inline-item bs_admin_action_movedown">'.link_to(__($params['label'], array(), 'sf_admin'), '<?php echo $this->params['route_prefix'] ?>/'.$params['action'].'?<?php echo $this->getPrimaryKeyUrlParams('$object', true); ?>).'</li>';
  }
  
  public function linkToNew($params)
  {
    return '<li class="list-inline-item bs_admin_action_new">'.link_to('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', '@'.$this->getUrlForAction('new'),array('title'=>__($params['label'], array(), 'sf_admin'))).'</li>';
  }

  public function linkToEdit($object, $params)
  {
    return '<li class="list-inline-item bs_admin_action_edit">'.link_to('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>', $this->getUrlForAction('edit'), $object, array('title'=>__($params['label'], array(), 'sf_admin'))).'</li>';
  }

  public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }

    return '<li class="list-inline-item bs_admin_action_delete">'.link_to( '<span class="glyphicon glyphicon-erase" aria-hidden="true"></span> '.__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('delete'), $object, array('method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'])).'</li>';
  }

  public function linkToList($params)
  {
    return '<li class="list-inline-item bs_admin_action_list">'.link_to( '<span class="glyphicon glyphicon-list" aria-hidden="true"></span> '.__($params['label'], array(), 'sf_admin'), '@'.$this->getUrlForAction('list')).'</li>';
  }

  public function linkToSave($object, $params)
  {
    return '<li class="list-inline-item bs_admin_action_save"><input class="btn btn-primary" type="submit" value="'.__($params['label'], array(), 'sf_admin').'" /></li>';
  }

  public function linkToSaveAndAdd($object, $params)
  {
    if (!$object->isNew())
    {
      return '';
    }

    return '<li class="list-inline-item bs_admin_action_save_and_add"><input class="btn btn-success"  type="submit" value="'.__($params['label'], array(), 'sf_admin').'" name="_save_and_add" /></li>';
  }
  
}
