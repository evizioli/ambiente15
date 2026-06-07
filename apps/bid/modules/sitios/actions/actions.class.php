<?php

require_once dirname(__FILE__).'/../lib/sitiosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/sitiosGeneratorHelper.class.php';

/**
 * sitios actions.
 *
 * @package    ambiente
 * @subpackage sitios
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class sitiosActions extends autoSitiosActions
{
    
    public function executeGml(sfWebRequest $request)
    {
        $this->preExecute();
        $this->getResponse()->setContentType('application/geo+json; charset=utf-8');
        $this->setFilters(array('area_protegida'=>$request->getParameter('area_protegida')));
        
        $sql = "SELECT jsonb_build_object(
    'type',     'FeatureCollection',
    'features', jsonb_agg(features.feature)
) AS geojson
FROM (
  SELECT jsonb_build_object(
    'type',       'Feature',
    'id',         id, -- Optional unique ID
    'geometry',   ST_AsGeoJSON(ST_Transform(ST_SetSRID(the_geom, 3857), 4326))::jsonb, -- Works for ANY geometry type
    'properties', jsonb_build_object(
        'name', nombre,
        'area_protegida', area_protegida
    )
  ) AS feature
  FROM bid_sitio 
where area_protegida='".$request->getParameter('area_protegida')."'
) features;";
        
        $stmt = Propel::getConnection()->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // 3. Output the raw string directly (No json_encode needed here)
        echo $result['geojson'];
        return sfView::NONE;
    }
    
}
