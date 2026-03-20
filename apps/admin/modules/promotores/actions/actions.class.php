<?php

require_once dirname(__FILE__).'/../lib/promotoresGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/promotoresGeneratorHelper.class.php';

/**
 * promotores actions.
 *
 * @package    ambiente
 * @subpackage promotores
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class promotoresActions extends autoPromotoresActions
{
    
    public function executeKml(sfWebRequest $request)
    {
        $connection = Propel::getConnection();
        $q="select ST_Transform(St_GeomFromText( 'geometrycollection(point(%s %s))' ,4326),'EPSG:4326','EPSG:3857')";
        $b= new sfWebBrowser();
        $f='/home/enrique/Descargas/Promotores Ambientales.kml';
        $kml = simplexml_load_file($f);
        foreach($kml->Document->Folder as $folder){
            
            if($folder->name=='Capa sin nombre'){
                foreach ($folder->Placemark as $ps){
                    echo $ps->name;
                    $prom = new PromotorAmbiental();
                    $prom->setNombre($ps->name);
                    list($foto,$desc)=explode('<br><br>', $ps->description->__toString());
                    $prom->setDescripcion($desc);
                    if(preg_match('/src="(.+)" height/', $foto, $output_array)){
                        $b->get($output_array[1]);
                        $h=$b->getResponseHeaders();
                        $prom->setNombreOriginal($ps->name);
                        $prom->setMime($h['Content-Type']);
                        $prom->setFoto( $b->getResponseText() );
                    }
                    list($lon,$lat)=explode(',',$ps->Point->coordinates->__toString());
                    $st=$connection->query(sprintf($q,$lon, $lat));
                    $r=$st->fetch(PDO::FETCH_NUM);
                    $prom->setTheGeom($r[0]);
                    $prom->save();
                    echo '<br>';
                    
                }
            }
        }
        die('ok');
    }
    
    
    public function executeFoto(sfWebRequest $r) {
        $doc = PromotorAmbientalQuery::create()->findPk($r->getParameter('id'));
        if($doc) {
            sfConfig::set('sf_web_debug', false);
            
            
            $this->setLayout(false);
            
            $this->getResponse()->setHttpHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0' );
            $this->getResponse()->setHttpHeader('Pragma', 'public' );
            $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename="'.$doc->getNombreOriginal().'"' );
            $this->getResponse()->setHttpHeader('Expires', '0' );
            
            
            $this->getResponse()->setContentType($doc->getMime().'; charset=utf-8');
            
            
            return $this->renderText( stream_get_contents($doc->getFoto()));
            
        }
    }
    
    
}
