<?php
switch ($sf_params->get('area')){
    case ProjectConfiguration::ANPPV:
        break;
    case ProjectConfiguration::PIMCPA:
        echo '  <h4>Pulpo Colorado Patagónico (Enteroctopus megalocyathus)<br/><small class="text-muted">Indicador: Status reproductivo en el intermareal rocoso</small></h4>';

        include_component('bidg1i1s', 'indicador',array('sitio_id'=>$sf_params->get('sitio_id'),'desde'=>$desde, 'hasta'=>$hasta));
        break;
}