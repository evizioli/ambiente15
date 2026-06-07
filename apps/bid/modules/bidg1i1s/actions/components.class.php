<?php 

class bidg1i1sComponents extends sfComponents
{
    public function executeIndicador()
    {
        
        $q=BidG1I1Query::create();
        if($this->desde){
            $q->filterByFecha($this->desde,Criteria::GREATER_EQUAL);
        }
        if($this->hasta){
            $q->filterByFecha($this->hasta,Criteria::LESS_EQUAL);
        }
        if($this->sitio_id){
            $q->filterBySitioId($this->sitio_id);
        }
        if($this->ambiente){
            $q->filterByAmbiente($this->ambiente);
        }
        $qq=clone $q;
        $this->actividad_pesquera= $qq->indicadorActividadPesquera();
        $qq=clone $q;
        $this->hembras_desove_intermareal= $qq->indicadorHembrasDesoveIntermareal();
        $qq=clone $q;
        $this->grupos= $qq->indicadorGrupos()->find();
        $this->total=$q->count();
    }
}