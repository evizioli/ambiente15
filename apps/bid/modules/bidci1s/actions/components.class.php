<?php 

class bidci1sComponents extends sfComponents
{
    public function executeIndicador()
    {
        
        $q=BidConteoIndicadorQuery::create()->ci1();
        if($this->desde){
            $q->filterByFecha($this->desde,Criteria::GREATER_EQUAL);
        }
        if($this->hasta){
            $q->filterByFecha($this->hasta,Criteria::LESS_EQUAL);
        }
        if($this->sitio_id){
            $q->filterBySitioId($this->sitio_id);
        }
        if($this->especie_id){
            $q->filterByEspecieId($this->especie_id);
        }
        
        $qc= clone $q;
        $this->resultado=$q->find();
        $this->total = $qc->count();
    }
}