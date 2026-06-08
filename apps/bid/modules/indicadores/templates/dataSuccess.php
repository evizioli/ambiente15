<?php 
switch ($sitio->getAreaProtegida()){
    case ProjectConfiguration::ANPPV:
        include_component('bidg5i1s', 'indicador',array('sitio_id'=>$sf_params->get('sitio_id'),'desde'=>$desde, 'hasta'=>$hasta));
        include_component('bidci2s', 'indicador',array('sitio_id'=>$sf_params->get('sitio_id'),'desde'=>$desde, 'hasta'=>$hasta));
        break;
    case ProjectConfiguration::PIMCPA:
        include_component('bidg1i1s', 'indicador',array('sitio_id'=>$sf_params->get('sitio_id'),'desde'=>$desde, 'hasta'=>$hasta));
        include_component('bidci1s', 'indicador',array('sitio_id'=>$sf_params->get('sitio_id'),'desde'=>$desde, 'hasta'=>$hasta));
        

        break;
}