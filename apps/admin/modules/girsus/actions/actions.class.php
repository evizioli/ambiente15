<?php

require_once dirname(__FILE__).'/../lib/girsusGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/girsusGeneratorHelper.class.php';

/**
 * girsus actions.
 *
 * @package    ambiente
 * @subpackage girsus
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class girsusActions extends autoGirsusActions
{
    
    public function executeKml(sfWebRequest $request)
    {
        $connection = Propel::getConnection();
        $q="
            insert into girsu(tipo,nombre,descripcion,the_geom)
            values ( %d, '%s', '%s', ST_Transform(St_GeomFromText( 'geometrycollection(point(%s %s))' ,4362),'EPSG:4326','EPSG:3857') )
        ";

        $f='/home/enrique/Descargas/MAPA GIRSU.kml';
        $kml = simplexml_load_file($f);
        foreach($kml->Document->Folder as $folder){

            if($folder->name=='comarcas_wgs84'){
                    echo $folder->name;
                    echo '<hr>';
                    foreach ($folder->Placemark as $ps){
                        print_r($ps);
                        die();
                        list($lon,$lat,$elev)=explode(',',$ps->Point->coordinates->__toString());
                
                        $connection->exec(sprintf($q,$t,$ps->name, $ps->descrption, $lon, $lat));
         
                    }
            }
        }
        die('ok');
    }
    
    
}
