<?php
class ConsultaAlgasFormFilter extends ConsultaGraficoTiempoFormFilter
{
    public function configure()
    {
        parent::configure();
        
        $hay= LugarExtraccionQuery::create()->soloConAlgas()->count()>0;
        
        $this->widgetSchema['lugar_de_extraccion_id']->setOption('add_empty',$hay?'Seleccionar un lugar':'No hay lugares disponibles');
        $this->widgetSchema['lugar_de_extraccion_id']->setOption('query_methods',array('soloConAlgas', 'innerJoinWithLocalidad','orderByLocalidad','orderByNombre'));
        
        
        
    }
    
}