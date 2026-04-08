<?php

require_once dirname(__FILE__).'/../lib/bidg9i1sGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bidg9i1sGeneratorHelper.class.php';

/**
 * bidg9i1s actions.
 *
 * @package    ambiente
 * @subpackage bidg9i1s
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class bidg9i1sActions extends autoBidg9i1sActions
{
    public function executeIndicador(sfWebRequest $request) {
        
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        if($request->isMethod('post')){
            if ($request->hasParameter('_reset'))
            {
                $this->setFilters($this->configuration->getFilterDefaults());
                
                $this->redirect('bidg9i1s/indicador');
            }
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
            
            $this->filters->bind($request->getParameter($this->filters->getName()));
            if ($this->filters->isValid())
            {
                $this->setFilters($this->filters->getValues());
                
                $this->redirect('bidg9i1s/indicador');
            }
            
        }
        
        $query = $this->buildQuery();
        $query
        ->select(array(
            'sitio',
            'ye',
            'act'
        ))
        ->useBidSitioQuery()
            ->withColumn('nombre','sitio')
            ->groupByNombre()
            ->orderByNombre()
        ->endUse()
        ->withColumn("date_part('year', fecha )",'ye')
        ->withColumn('sum(puestas)*100/sum(refugios)','act')
        ->groupBy('ye')
        ->orderBy('ye');
        
        $this->resultado= $query->find();
    }
    
}
