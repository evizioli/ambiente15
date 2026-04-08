<?php

require_once dirname(__FILE__).'/../lib/bidg6i1sGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bidg6i1sGeneratorHelper.class.php';

/**
 * bidg6i1s actions.
 *
 * @package    ambiente
 * @subpackage bidg6i1s
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class bidg6i1sActions extends autoBidg6i1sActions
{
    public function executeIndicador(sfWebRequest $request) {
        
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        if($request->isMethod('post')){
            if ($request->hasParameter('_reset'))
            {
                $this->setFilters($this->configuration->getFilterDefaults());
                
                $this->redirect('bidg6i1s/indicador');
            }
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
            
            $this->filters->bind($request->getParameter($this->filters->getName()));
            if ($this->filters->isValid())
            {
                $this->setFilters($this->filters->getValues());
                
                $this->redirect('bidg6i1s/indicador');
            }
            
        }
        
        $query = $this->buildQuery();
//         $q2=clone $query; 
        
        $query
        ->select(array(
            'sitio',
            'ye',
            'mad',
            'msa',
            'h',
            'j',
            'c',
            'hj'
            
        ))
        ->useBidSitioQuery()
            ->withColumn('nombre','sitio')
            ->groupByNombre()
            ->orderByNombre()
        ->endUse()
        ->withColumn("date_part('year', fecha )",'ye')
        ->withColumn('sum(machos_adultos)','mad')
        ->withColumn('sum(machos_sub_adultos)','msa')
        ->withColumn('sum(hembras_adultas)','h')
        ->withColumn('sum(juveniles)','j')
        ->withColumn('sum(crias)','c')
        ->withColumn('sum(hembras_juveniles)','hj')
        ->groupBy('ye')
        ->orderBy('ye')
        ;

        $this->resultado= $query->find();
    }
    
}
