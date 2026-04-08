<?php

require_once dirname(__FILE__).'/../lib/bidci2sGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bidci2sGeneratorHelper.class.php';

/**
 * bidci2s actions.
 *
 * @package    ambiente
 * @subpackage bidci2s
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class bidci2sActions extends autoBidci2sActions
{
    
    public function executeIndicador(sfWebRequest $request)
    {
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        if($request->isMethod('post')){
            if ($request->hasParameter('_reset'))
            {
                $this->setFilters($this->configuration->getFilterDefaults());
                
                $this->redirect('bidci2s/indicador');
            }
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
            
            $this->filters->bind($request->getParameter($this->filters->getName()));
            if ($this->filters->isValid())
            {
                $this->setFilters($this->filters->getValues());
                
                $this->redirect('bidci2s/indicador');
            }
            
        }
        $query = $this->buildQuery();
        $query 
        ->select(array(
            'q','m','y',
            'especie',
            'especie_id',
            'cantidad'
        ))
        ->withColumn('especie_id','especie_id')
        ->withColumn('sum(cantidad)','cantidad')
        ->withColumn("date_part( 'year', fecha)",'y')
        ->withColumn("date_part( 'month', fecha)",'m')
        ->withColumn("case when date_part( 'day', fecha)<16 then 1  else 2 end",'q')
        ->useBidEspecieQuery()
        ->orderByNombre()
        ->groupByNombre()->withColumn('bid_especie.nombre','especie')
        ->endUse()
        ->groupByEspecieId()
        ->groupBy('y')
        ->groupBy('m')
        ->groupBy('q')
        ->orderBy('y')
        ->orderBy('m')
        ->orderBy('q')
        ;
        
        
        $qc= clone $query;
        $this->resultado=$query->find();
        $this->total = $qc->count();
    }
    
}
