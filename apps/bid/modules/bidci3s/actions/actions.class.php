<?php

require_once dirname(__FILE__).'/../lib/bidci3sGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bidci3sGeneratorHelper.class.php';

/**
 * bidci3s actions.
 *
 * @package    ambiente
 * @subpackage bidci3s
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class bidci3sActions extends autoBidci3sActions
{
    
    public function executeIndicador(sfWebRequest $request)
    {
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        if($request->isMethod('post')){
            if ($request->hasParameter('_reset'))
            {
                $this->setFilters($this->configuration->getFilterDefaults());
                
                $this->redirect('bidci3s/indicador');
            }
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
            
            $this->filters->bind($request->getParameter($this->filters->getName()));
            if ($this->filters->isValid())
            {
                $this->setFilters($this->filters->getValues());
                
                $this->redirect('bidci3s/indicador');
            }
            
        }
        $query = $this->buildQuery();
        $query
        ->select(array(
            'especie',
            'especie_id',
            'pa'
        ))
        ->withColumn("case when sum(case when bid_conteo_indicador.indicador=".BidConteoIndicadorPeer::MAMIFEROS_CARNIVOROS." then cantidad else 0 end)>0 then 'P' else 'A' end",'pa')
        ->useBidEspecieQuery()
            ->useBidEspecieRelevanciaQuery()
                ->filterByIndicador(BidConteoIndicadorPeer::MAMIFEROS_CARNIVOROS)
            ->endUse()
            ->orderByNombre()
            ->groupByNombre()
            ->groupById()
            ->withColumn('bid_especie.id','especie_id')
            ->withColumn('bid_especie.nombre','especie')
        ->endUse()
        ->rightJoinBidEspecie()
        ->remove(BidConteoIndicadorPeer::INDICADOR)
        ;
        $this->resultado=$query->find();
        
        
        $query = $this->buildQuery();
        $query
        ->select(array(
            'especie',
            'especie_id',
            'em',
            'c'
        ))
        ->withColumn("sum(case when bid_conteo_indicador.indicador=".BidConteoIndicadorPeer::MAMIFEROS_CARNIVOROS." then cantidad else 0 end)",'c')
        ->withColumn('(max(fecha)-min(fecha)+1)*count(distinct bid_conteo_indicador.sitio_id)','em')
        ->useBidEspecieQuery()
            ->useBidEspecieRelevanciaQuery()
                ->filterByIndicador(BidConteoIndicadorPeer::MAMIFEROS_CARNIVOROS)
            ->endUse()
            ->orderByNombre()
            ->groupByNombre()
            ->groupById()
            ->withColumn('bid_especie.id','especie_id')
            ->withColumn('bid_especie.nombre','especie')
        ->endUse()
        ->rightJoinBidEspecie()
        ->remove(BidConteoIndicadorPeer::INDICADOR)
        ;
        $this->resultado3=$query->find();
        
        

    }
    
}
