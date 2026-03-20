<?php

require_once dirname(__FILE__).'/../lib/parquesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/parquesGeneratorHelper.class.php';

/**
 * parques actions.
 *
 * @package    ambiente
 * @subpackage parques
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class parquesActions extends autoParquesActions
{
    
    public function executeKml(sfWebRequest $request)
    {
        $connection = Propel::getConnection();
        $q="
            insert into parque_eolico(nombre,descripcion,the_geom)
            values ( '%s', '%s', ST_Transform(St_GeomFromText( 'geometrycollection(point(%s %s))' ,4362),'EPSG:4326','EPSG:3857') )
        ";
        
        $f='/home/enrique/Descargas/mapa parques eolicos/doc.kml';
        $kml = simplexml_load_file($f);
        foreach($kml->Document->Folder as $folder){
            if($folder->name=='AEROGENERADORES'){
                
                foreach ($folder->Placemark as $ps){
                    $d=$ps->description->__toString();
                    $d=str_ireplace('<br>', "\n", $d);
                    
                    if(is_null($ps->Point->coordinates)){
                        print_r($ps);
                        die();
                    }
                    
                    list($lon,$lat,$elev)=explode(',',$ps->Point->coordinates->__toString());
                    
                    $connection->exec(sprintf($q,$ps->name, $d, $lon, $lat));
                    
                }
            }
        }
        die('ok');
    }
    
}
