<?php

require_once dirname(__FILE__).'/../lib/bidg3i1sGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bidg3i1sGeneratorHelper.class.php';

/**
 * bidg3i1s actions.
 *
 * @package    ambiente
 * @subpackage bidg3i1s
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class bidg3i1sActions extends autoBidg3i1sActions
{
    public function executeIndicador(sfWebRequest $request) {
       
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        if($request->isMethod('post')){
            if ($request->hasParameter('_reset'))
            {
                $this->setFilters($this->configuration->getFilterDefaults());
                
                $this->redirect('bidg3i1s/indicador');
            }
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
            
            $this->filters->bind($request->getParameter($this->filters->getName()));
            if ($this->filters->isValid())
            {
                $this->setFilters($this->filters->getValues());
                
                $this->redirect('bidg3i1s/indicador');
            }
            
        }
        $q="select bid_sitio.id,
            bid_sitio.nombre,
            date_part('year',  fecha) ye,
            sum(data.parejas) parejas,
            sum(data.hembras) hembras,
            sum(data.machos) machos,
            sum(data.km_relevados) km_relevados,
            st_asText(bid_sitio.the_geom) sitio
        from bid_g3_i1 as data
            inner join bid_sitio on data.sitio_id=bid_sitio.id
        where true %s
        group by bid_sitio.id,
            bid_sitio.nombre,
            ye,
            sitio
        order by bid_sitio.id, ye";
        
        $f=$this->getFilters();
        //         print_r($f);
        //         die();
        $w='';
        if($f['sitio_id']){
            $w.= " and data.sitio_id=".$f['sitio_id'];
        }
        if($f['fecha']){
            if($f['fecha']['from']){
                $w.= " and data.fecha>='".$f['fecha']['from']."'";
            }
            if($f['fecha']['to']){
                $w.= " and data.fecha<='".$f['fecha']['to']."'";
            }
        }
        
        $this->resultado = Propel::getConnection()->query(sprintf($q, $w)  )->fetchAll(PDO::FETCH_ASSOC);
        
        //         echo $this->resultado->rowCount();
        //         echo '<hr>';
        $this->configuration->features=array_column($this->resultado, 'sitio');
        
        $query = $this->filters->buildCriteria($this->getFilters())->innerJoinBidSitio()->useBidSitioQuery()->orderByNombre()->endUse()->orderByFecha();
        $this->res2 = $query->find();
        
        
    }
}
