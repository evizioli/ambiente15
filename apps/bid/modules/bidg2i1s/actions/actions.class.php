<?php

require_once dirname(__FILE__).'/../lib/bidg2i1sGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bidg2i1sGeneratorHelper.class.php';

/**
 * bidg2i1s actions.
 *
 * @package    ambiente
 * @subpackage bidg2i1s
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class bidg2i1sActions extends autoBidg2i1sActions
{
    public function executeIndex(sfWebRequest $request) {
        
        parent::executeIndex($request);
        $q=$this->buildQuery();
        $this->configuration->features= $q->select(array('p'))->withColumn('st_asText(ubicacion)','p')->find()->toArray();
    
    }
    public function executeIndicador(sfWebRequest $request) {
        /*
        
        
        ;
        
        select sitio_id, ubicacion, max(numero_adultos)mad from bid_g2_i1 group by sitio_id, ubicacion;

         */
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        if($request->isMethod('post')){
            if ($request->hasParameter('_reset'))
            {
                $this->setFilters($this->configuration->getFilterDefaults());
                
                $this->redirect('bidg2i1s/indicador');
            }
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
            
            $this->filters->bind($request->getParameter($this->filters->getName()));
            if ($this->filters->isValid())
            {
                $this->setFilters($this->filters->getValues());
                
                $this->redirect('bidg2i1s/indicador');
            }
            
        }
        $q="select bid_sitio.id,
            bid_sitio.nombre,
            ST_Area(ST_Transform(ST_SetSRID(bid_sitio.the_geom, 3857), 4326)::geography)/10000 hectareas,
            sum(bid_g2_i1.numero_adultos) adultos,
            date_part('year',  fecha) ye,
            st_asText(bid_sitio.the_geom) sitio
        from bid_g2_i1
            inner join bid_sitio on bid_g2_i1.sitio_id=bid_sitio.id
        where true %s
        group by bid_sitio.id,
            bid_sitio.nombre,
            hectareas,
            ye,
            sitio
        order by bid_sitio.id, ye";
        
        $f=$this->getFilters();
//         print_r($f);
//         die();
        $w='';
        if($f['sitio_id']){
            $w.= " and bid_g2_i1.sitio_id=".$f['sitio_id'];
        }
        if($f['fecha']){
            if($f['fecha']['from']){
                $w.= " and bid_g2_i1.fecha>='".$f['fecha']['from']."'";    
            }
            if($f['fecha']['to']){
                $w.= " and bid_g2_i1.fecha<='".$f['fecha']['to']."'";    
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
