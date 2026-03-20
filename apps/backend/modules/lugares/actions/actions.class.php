<?php

require_once dirname(__FILE__).'/../lib/lugaresGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/lugaresGeneratorHelper.class.php';



require ProjectConfiguration::guessRootDir().'/plugins/comunPlugin/lib/vendor/autoload.php';



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * lugares actions.
 *
 * @package    ambiente
 * @subpackage lugares
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class lugaresActions extends autoLugaresActions
{

    
    public function executeListExportar(sfWebRequest $request)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Number','Asset','Date', 'I18N'));
        
        
        $estosNo=array(
            'id',
        );
        $estosCambiar=array(
            'tipo_id'=>'tipo_muestra',
            'localidad_id'=>'localidad',
            'the_geom'=>'localizacion',
        );
        
        $tm=LugarExtraccionPeer::getTableMap();
        
        
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $columnIndex=1;
        
        foreach ($tm->getColumns() as $co){
            $c=LugarExtraccionPeer::translateFieldName(strtoupper( $co->getName()), BasePeer::TYPE_RAW_COLNAME, BasePeer::TYPE_FIELDNAME);
            if(in_array($c, $estosNo) || substr($c, -4)=='_lim') continue;
            
            $t=__(sfInflector::humanize($c), array(), 'messages');
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex++, 1, $t);
        }
        $row=2;
        foreach ($this->buildQuery()->find() as $lugar){
            $columnIndex=1;
            foreach ($tm->getColumns() as $co){
                
                $c=LugarExtraccionPeer::translateFieldName(strtoupper( $co->getName()), BasePeer::TYPE_RAW_COLNAME, BasePeer::TYPE_FIELDNAME);
                if(in_array($c, $estosNo) || substr($c, -4)=='_lim') continue;
                
                switch ($c){
//                     case 'fecha':
//                         $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $row, Date::PHPToExcel(strtotime($lugar->getFecha())));
//                         $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex,$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
//                         break;
                    default:
                        
                        
                        
                        if(array_key_exists($c, $estosCambiar)) {
                            $c=$estosCambiar[$c];
                            $m='get'.sfInflector::camelize($c);
                        } else {
                            $m= 'get'.$co->getPhpName();
                            
                        }
                        $p=null;
//                         if(method_exists($this, $m.'Lim')){
//                             $p=$m;
//                             $m='conLim';
//                         }
                        $tmp =$lugar->$m($p);
                        if(!is_null($tmp)) {
                            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $row, $tmp);
                        }
                }
                $columnIndex++;
            }
            $row++;
        }
        
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="sitios.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
        
    }
    
    
    public function executeImportar() {
        
        $re= <<<EOD
/(N|W|O|S|E)\s+(\d+)\s?°\s?(\d+)\s?('{1}|’{1}|´{1})\s?(\d+\.?\,?\d*?)("|'{2}|’{2}|´{2})/mi
EOD;
        
        
        
        if (($gestor = fopen("/home/enrique/Escritorio/lugares de extracción conocidos.csv", "r")) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                
                print_r($datos);

                echo '<br>';
                preg_match_all($re,  $datos[1], $esto);
                
                if(LugarExtraccionQuery::create()->findOneByNombre($datos[0])) continue;
                
                
                if(count($esto[0])==2){
                    
                    
                    foreach (array_keys($esto[0]) as $i){
                        $v= (int)$esto[2][$i] +(int)$esto[3][$i]/60 +floatval($esto[5][$i])/3600;
                        switch(strtoupper($esto[1][$i]) ){
                            case 'S':
                                $lat=$v*-1;
                                break;
                            case 'N':
                                $lat=$v;
                                break;
                            case 'O':
                            case 'W':
                                $lon= $v*-1;
                                break;
                            case 'E':
                                $lon= $v;
                                break;
                        }
                    }
                    
                }
                
                
                $m = new LugarExtraccion();
                $m->setNombre($datos[0]);
                
                $statement = Propel::getConnection()->prepare( "select ST_Transform( st_geomfromtext('GEOMETRYCOLLECTION(POINT( $lon $lat ))',4326),'EPSG:4326','EPSG:3857' ) AS latlon" );
                $statement->execute ();
                $resultset = $statement->fetch ( PDO::FETCH_OBJ );
                $m->setTheGeom( $resultset->latlon);
                
                
                $m->save();
                
            }
            fclose($gestor);
        }
        die('listo');
    }
    
    
	public function executeAjax(sfWebRequest $request)
	{

		$res = LugarExtraccionQuery::create()->withColumn( 'ST_AsText(ST_Centroid(the_geom))', 'wkt')->findPk($request->getParameter('id'));
				
		$this->getResponse()->setContentType('application/json');
		
		return $this->renderText( json_encode(array(
				'res'=> $res? array_merge($res->toArray(), array('wkt'=>$res->getVirtualColumn('wkt')) ): false
				
		)));
	}
}

