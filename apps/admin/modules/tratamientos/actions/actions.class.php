<?php

require_once dirname(__FILE__).'/../lib/tratamientosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/tratamientosGeneratorHelper.class.php';

/**
 * tratamientos actions.
 *
 * @package    ambiente
 * @subpackage tratamientos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class tratamientosActions extends autoTratamientosActions
{
    
    public function executeKml(sfWebRequest $request)
    {
        $connection = Propel::getConnection();
        $q="
            insert into tratamiento(tipo,nombre,descripcion,the_geom)
            values ( %d, '%s', '%s', ST_Transform(St_GeomFromText( 'geometrycollection(point(%s %s))' ,4362),'EPSG:4326','EPSG:3857') )
        ";
        
        $f='/home/enrique/Descargas/mapa de ptlc 2021/doc.kml';
        $kml = simplexml_load_file($f);
        $t=1;
        foreach($kml->Document->Folder as $folder){
                foreach ($folder->Placemark as $ps){
                    $d=$ps->description->__toString();
                    list($lon,$lat)=explode(',',$ps->Point->coordinates->__toString());
                                
                    $connection->exec(sprintf($q,$t,$ps->name, $d, $lon, $lat));
                    
                }
                $t++;
        }
        die('ok');
    }
    
}
