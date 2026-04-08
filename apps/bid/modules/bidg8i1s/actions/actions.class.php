<?php

require_once dirname(__FILE__).'/../lib/bidg8i1sGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bidg8i1sGeneratorHelper.class.php';

/**
 * bidg8i1s actions.
 *
 * @package    ambiente
 * @subpackage bidg8i1s
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class bidg8i1sActions extends autoBidg8i1sActions
{
    public function executeIndicador(sfWebRequest $request) {
        
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        if($request->isMethod('post')){
            if ($request->hasParameter('_reset'))
            {
                $this->setFilters($this->configuration->getFilterDefaults());
                
                $this->redirect('bidg8i1s/indicador');
            }
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
            
            $this->filters->bind($request->getParameter($this->filters->getName()));
            if ($this->filters->isValid())
            {
                $this->setFilters($this->filters->getValues());
                
                $this->redirect('bidg8i1s/indicador');
            }
            
        }
        
        $query = $this->buildQuery();
        $query
        ->select(array(
            'sitio',
            'ye',
            'pares',
            'crias_huerfanas'
        ))
        ->useBidSitioQuery()
            ->withColumn('nombre','sitio')
            ->groupByNombre()
            ->orderByNombre()
        ->endUse()
        ->withColumn("date_part('year', fecha )",'ye')
        ->withColumn('sum(pares)','pares')
        ->withColumn('sum(crias_huerfanas)','crias_huerfanas')
        ->groupBy('ye')
        ->orderBy('ye');
        
        $this->resultado= $query->find();
    }
    
}
