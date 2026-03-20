<?php

require_once dirname(__FILE__).'/../lib/mineriasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/mineriasGeneratorHelper.class.php';

/**
 * minerias actions.
 *
 * @package    ambiente
 * @subpackage minerias
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class mineriasActions extends autoMineriasActions
{
    
    public function executeKml(sfWebRequest $request)
    {
        $a=array(
            '1era Categoría_Exploración_Vencidos'=>1,
            '1era Categoría_Explotación_Vigentes'=>2,
            '1era Categoría_Explotación_Vencidos'=>3,
            '2da Categoría_Explotación_Vigentes'=>4,
            '2da Categoría_Explotación_Vencidos'=>5,
            
            '3era Categoría_Aridos_Vigentes'=>6,
            '3era Categoría_Aridos_Vencidos'=>7,
            '3era Categoría Pórfidos_Vigentes'=>8,
            '3era Categoría Pórfidos_Vencidos'=>9,
            '3era Categoría_Calizas_Vigentes'=>10,
            '3era Categoría_Calizas_Vencidos'=>11,
            '3era Categoría Bancos_en_Río'=>12
        );
        
        $connection = Propel::getConnection();
        $q="
            insert into mineria(nombre,categoria, descripcion,the_geom)
            values ( '%s', %s, '%s', ST_Transform(St_GeomFromText( 'geometrycollection(point(%s %s))' ,4362),'EPSG:4326','EPSG:3857') )
        ";
        
//         $f='/home/enrique/Descargas/gmaps/primseg/doc.kml';
        $f='/home/enrique/Descargas/gmaps/tercera/doc.kml';
        $kml = simplexml_load_file($f);
        foreach($kml->Document->Folder as $folder){
//             echo $folder->name.'<br>';
                
                foreach ($folder->Placemark as $ps){
                    
                    list($lon,$lat,$elev)=explode(',',$ps->Point->coordinates->__toString());
                    $d=$ps->description->__toString();
                    $d=str_ireplace("'", "''", $d);
                    $d=str_ireplace('<br>', "\n", $d);
                    
                    
                    $connection->exec(sprintf($q,$ps->name, $a[$folder->name->__toString()], $d, $lon, $lat));
                    
                }
        }
        die('OK');
    }
    
}
