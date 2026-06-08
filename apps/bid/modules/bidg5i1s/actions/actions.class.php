<?php

require_once dirname(__FILE__).'/../lib/bidg5i1sGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bidg5i1sGeneratorHelper.class.php';

/**
 * bidg5i1s actions.
 *
 * @package    ambiente
 * @subpackage bidg5i1s
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class bidg5i1sActions extends autoBidg5i1sActions
{
    public function executeIndicador(sfWebRequest $request) {
        
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        if($request->isMethod('post')){
            if ($request->hasParameter('_reset'))
            {
                $this->setFilters($this->configuration->getFilterDefaults());
                
                $this->redirect('bidg5i1s/indicador');
            }
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
            
            $this->filters->bind($request->getParameter($this->filters->getName()));
            if ($this->filters->isValid())
            {
                $this->setFilters($this->filters->getValues());
                
                $this->redirect('bidg5i1s/indicador');
            }
            
        }
        
        $query = $this->buildQuery();
        $query->select(array('ye','crias'))->withColumn("date_part('year', fecha )",'ye')->groupBy('ye')->orderBy('ye')->withColumn('sum(crias_destetadas)','crias');
        $this->resultado= $query->find();
    }
}
