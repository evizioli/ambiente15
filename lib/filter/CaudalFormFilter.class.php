<?php

/**
 * Caudal filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class CaudalFormFilter extends BaseCaudalFormFilter
{
  public function configure()
  {
      $this->useFields(array('fecha'));
      
  }
  protected function doBuildCriteria(array $values)
  {
      $criteria=parent::doBuildCriteria($values);
      if($criteria->hasWhereClause()) return $criteria;
      $criteria->filterById(0);
      return $criteria;
  }
}
