<?php

/**
 * common actions.
 *
 * @package    ambiente
 * @subpackage common
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class commonActions extends sfActions
{
 
    protected function agregar($super, $zip, $capa, $nombre, $coleccion, $descripcion=false)
    {
        
        $s=$this->doc->addChild('Style');
        $s->addAttribute('id',$capa);
        $is=$s->addChild('IconStyle');
        $i=$is->addChild('Icon');
        
        $href=$this->source.'frontend-'.$capa.'.png';
        $i->addChild('href', 'files/'.basename($href));
        $zip->addFile($href, 'files/' . basename($href));
        
        $ff=$super->addChild ( 'Folder' );
        $ff->addChild ( 'name' , $nombre);
        
        foreach ($coleccion as $o){
            $pm=$ff->addChild('Placemark');
            $pm->addChild('styleUrl','#'.$capa);
            $pm->addChild('name',nl2br( htmlspecialchars(  $o->getNombre() )));
            if($descripcion) $pm->addChild('description',nl2br( htmlspecialchars(  $o->getDescripcion() )));
            $p=$pm->addChild('Point');
            
            $ll=Dummy::getLatLon( $o->getTheGeom());
            $p->addChild('coordinates',$ll['lat'].','.$ll['lon'].',0');
        }
        
    }

    protected function agregarGrupo( $nombre_carpeta, $grupo, $tipos,$icons,$q)
    {
        
        $sm=$this->doc->addChild ( 'StyleMap' );
        $sm->addAttribute('id','sm'.$grupo);
        
        $f=$this->doc->addChild ( 'Folder' );
        $f->addChild ( 'name' , $nombre_carpeta);
        
        foreach ($tipos as $tipo=>$nombre){
            $s=$this->doc->addChild('Style');
            $s->addAttribute('id',$grupo.'_'.$icons[$tipo]);
            $is=$s->addChild('IconStyle');
            $i=$is->addChild('Icon');
            $href=file_get_contents($this->source.'frontend-'.$grupo.'_'.$icons[$tipo].'.png');
            $i->addChild('href', 'data:image/png;base64,'.base64_encode($href));
            
            $pair= $sm->addChild('Pair');
            $pair->addChild('key','normal');
            $pair->addChild('styleUrl','#'.$grupo.'_'.$icons[$tipo]);
            
            $ff=$f->addChild('Folder');
            $ff->addChild('name',$nombre);
            
            foreach ($q->findByTipo($tipo) as $o){
                $pm=$ff->addChild('Placemark');
                $pm->addChild('styleUrl','#sm'.$grupo);
                $pm->addChild('name',$o->getNombre());
                $pm->addChild('description',nl2br( htmlspecialchars( '<![CDATA['.$o->getDescripcion().']]>')));
                $p=$pm->addChild('Point');
                
                $ll=Dummy::getLatLon( $o->getTheGeom());
                $p->addChild('coordinates',$ll['lat'].','.$ll['lon'].',0');
            }
        }
    }

    protected function agregarKml( $super, $tipo, $zip)
    {
        $s=$this->doc->addChild('Style');
        $s->addAttribute('id','kml_'.$tipo);
        $is=$s->addChild('IconStyle');
        $i=$is->addChild('Icon');
        
        $href=$this->source.'frontend-kml'.$tipo.'.png';
        $i->addChild('href', 'files/'.basename($href));
        $zip->addFile($href, 'files/' . basename($href));
        
        
        $ff=$super->addChild ( 'Folder' );
        $ff->addChild ( 'name' , KmlPeer::$tipos[$tipo]);
        
        foreach (KmlQuery::create()->findByTipo($tipo) as $o){
            $pm=$ff->addChild('Placemark');
            $pm->addChild('styleUrl','#kml_'.$tipo);
            $pm->addChild('name',nl2br( htmlspecialchars(  $o->getNombre() )));
            $pm->addChild('description',nl2br( htmlspecialchars(  $o->getDescripcion() )));
            $p=$pm->addChild('Point');
            
            $ll=Dummy::getLatLon( $o->getTheGeom());
            $p->addChild('coordinates',$ll['lat'].','.$ll['lon'].',0');
        }
    }
    
    
    protected function agregarKmlStyle( $styleUrl, $super, $capa, $zip)
    {
        $ff=$super->addChild ( 'Folder' );
        $ff->addChild ( 'name' , KmlPeer::$tipos[$capa]);
        
//         foreach (KmlQuery::create()->findByTipo($tipo) as $o){
        $rs=Propel::getConnection()->query('select nombre, descripcion, st_askml(st_multi(st_force2d(st_setsrid(the_geom,3857)))) algo from kml'.$capa) ;
        while ($r=$rs->fetch(pdo::FETCH_ASSOC)) {
            $pm=$ff->addChild('Placemark');
            $pm->addChild('styleUrl', $styleUrl);
            $pm->addChild('name',nl2br( htmlspecialchars(  $r['nombre'] )));
            if($r['descripcion'] ) $pm->addChild('description',nl2br( htmlspecialchars(  $r['descripcion'] )));
            $from=simplexml_load_string($r['algo']);
            $this->sxml_append($pm, $from);
        }
    }
    
    protected function agregarGrupo2($super, $nombre_carpeta, $grupo, $icons, $q, $zip)
    {
        
        foreach ($icons as $iid=>$in){
            
            $s=$this->doc->addChild('Style');
            $s->addAttribute('id',$grupo.'_'.$iid);
            $is=$s->addChild('IconStyle');
            $i=$is->addChild('Icon');
            
            $href=$this->source.'frontend-'.$grupo.'-'.$iid.'.png';
            $i->addChild('href', 'files/'.basename($href));
            $zip->addFile($href, 'files/' . basename($href));
            
        }
        
        $ff=$super->addChild ( 'Folder' );
        $ff->addChild ( 'name' , $nombre_carpeta);
        
        foreach ($q as $o){
            $pm=$ff->addChild('Placemark');
            $pm->addChild('styleUrl','#'.$grupo.'_'.($o->getEstado()?'2':'1'));
            $pm->addChild('name',nl2br( htmlspecialchars(  $o->getNombre() )));
            $pm->addChild('description',nl2br( htmlspecialchars(  $o->getDescripcion() )));
            $p=$pm->addChild('Point');
            
            $ll=Dummy::getLatLon( $o->getTheGeom());
            $p->addChild('coordinates',$ll['lat'].','.$ll['lon'].',0');
        }
    }
        
    
    public function executeImportarComarcas(sfWebRequest $request)
    {
        $connection = Propel::getConnection();
        $q="
            insert into kml(nombre,descripcion,the_geom, esquema_id)
            values ( '%s', '%s', ST_Transform(St_GeomFromText( 'geometrycollection(point(%s %s))' ,4362),'EPSG:4326','EPSG:3857') )
        ";
        
        $f='/home/enrique/Descargas/mapa parques eolicos/doc.kml';
        $kml = simplexml_load_file($f);
        foreach($kml->Document->Folder as $folder){
            if($folder->name=='Comarcas'){
                
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
    
    public function executeKml(sfWebRequest $request)
    {
        $kmlOutput = file_get_contents(ProjectConfiguration::guessRootDir().'/data/'.$request->getParameter('nombre').'.kml');
        $this->getResponse()->setHttpHeader('Content-type','application/vnd.google-earth.kml+xml');
        return $this->renderText( $kmlOutput );
    }
    
    protected function sxml_append(SimpleXMLElement $to, SimpleXMLElement $from) {
        $toDom = dom_import_simplexml($to);
        $fromDom = dom_import_simplexml($from);
        $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
    }
    
    public function executeDescargarKmz(sfWebRequest $request)
    {
        $zip = new ZipArchive();
        $fn=sfProjectConfiguration::guessRootDir().'/cache/spia.kmz';
        $zip->open($fn, ZIPARCHIVE::CREATE);
        $zip->addEmptyDir('files');
        
        $this->source = sfConfig::get('sf_web_dir').'/images/';
        
        $kmlOutput = new SimpleXMLElement ( '<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom"/>' );
        $this->doc=$kmlOutput->addChild ( 'Document' );
        $this->doc->addChild ( 'name' , 'M.A.yC.D.S.');
 
        
        $super=$this->doc->addChild ( 'Folder' );
        $super->addChild ( 'name' , 'División Política');
        
        
        
        ///////// comarcas
        
        $s=$this->doc->addChild ( 'Style' );
        $s->addAttribute('id','stComarcas');
        $ps=$s->addChild ( 'PolyStyle' );
        $ps->addChild ( 'fill', 0 );
        $ls=$s->addChild ( 'LineStyle' );
        $ls->addChild ( 'color', 'ff050505');
        $ls->addChild ( 'width', 3 );
        
//         $f=$this->doc->addChild ( 'Folder' );
        $f=$super->addChild ( 'Folder' );
        $f->addChild ( 'name' , 'Comarcas');
        $kml = simplexml_load_file( sfProjectConfiguration::guessRootDir().'/data/comarcas.kml' );
        foreach($kml->Document as $que){
            foreach($que as $type=>$folder){
                if($folder->name=='Comarcas' && $type=='Folder'){
                    foreach ($folder->Placemark as  $ps){
                        $nombre= $ps->ExtendedData->SchemaData->SimpleData[0];
                        $pm=$f->addChild('Placemark');
                        $pm->addChild('styleUrl','#stComarcas');
                        $pm->addChild('name',$nombre);
                        $pm->addChild('description',nl2br( htmlspecialchars( $nombre)));
                        $this->sxml_append($pm, $ps->MultiGeometry);
                    }
                }
            }
        }
        
        
        $estos=array(
            KmlPeer::TIPO_EJIDOS_URBANOS=>'780078',
            KmlPeer::TIPO_DEPARTAMENTOS=>'78ff00',
        );
        foreach($estos as $kml=>$color){
            
            $s=$this->doc->addChild ( 'Style' );
            $s->addAttribute('id','st'.$kml);
            $ps=$s->addChild ( 'PolyStyle' );
            $ps->addChild ( 'color', '66'.$color );
            $ps->addChild ( 'fill', 1 );
            $ps->addChild ( 'outline', 1 );
            $ls=$s->addChild ( 'LineStyle' );
            $ls->addChild ( 'color', 'ff'.$color );
            $ls->addChild ( 'width', 2 );
            
            $f=$super->addChild ( 'Folder' );
            $f->addChild ( 'name' , KmlPeer::$tipos[$kml]);
            
            $rs=Propel::getConnection()->query('select nombre, descripcion, st_askml(st_multi(st_force2d(st_setsrid(the_geom,3857)))) algo from kml where tipo='.$kml) ;
            while ($r=$rs->fetch(pdo::FETCH_ASSOC)) {
                $pm=$f->addChild('Placemark');
                $pm->addChild('styleUrl','#st'.$kml);
                $pm->addChild('name',$r['nombre']);
                $pm->addChild('description',nl2br( htmlspecialchars(  $r['descripcion']?$r['descripcion']:$r['nombre'])));
                $from=simplexml_load_string($r['algo']);
                $this->sxml_append($pm, $from);
            }
        }
        
        
        
        $super=$this->doc->addChild ( 'Folder' );
        $super->addChild ( 'name' , 'Agua');
        
        //////////////////  lugares de tomas de muestras
        $this->agregar($super,$zip, 'le','Sitios de toma de mustras de agua',LugarExtraccionQuery::create()->find());
        
        
        $estos=array(
            KmlPeer::TIPO_CUENCAS=>'0078ff',
            KmlPeer::TIPO_SUBCUENCAS=>'00c800',
            KmlPeer::TIPO_CUERPOS_DE_AGUA=>'ffc8c8',
        );
        foreach($estos as $kml=>$color){
            
            $s=$this->doc->addChild ( 'Style' );
            $s->addAttribute('id','st'.$kml);
            $ps=$s->addChild ( 'PolyStyle' );
            $ps->addChild ( 'color', '66'.$color );
            $ps->addChild ( 'fill', 1 );
            $ps->addChild ( 'outline', 1 );
            $ls=$s->addChild ( 'LineStyle' );
            $ls->addChild ( 'color', 'ff'.$color );
            $ls->addChild ( 'width', 2 );
            
            $f=$super->addChild ( 'Folder' );
            $f->addChild ( 'name' , KmlPeer::$tipos[$kml]);
            
            $rs=Propel::getConnection()->query('select nombre, descripcion, st_askml(st_multi(st_force2d(st_setsrid(the_geom,3857)))) algo from kml where tipo='.$kml) ;
            while ($r=$rs->fetch(pdo::FETCH_ASSOC)) {
                $pm=$f->addChild('Placemark');
                $pm->addChild('styleUrl','#st'.$kml);
                $pm->addChild('name',$r['nombre']);
                $pm->addChild('description',nl2br( htmlspecialchars(  $r['descripcion']?$r['descripcion']:$r['nombre'])));
                $from=simplexml_load_string($r['algo']);
                $this->sxml_append($pm, $from);
            }
        }
        
        //////////////////  canales
        $sm=$this->doc->addChild ( 'StyleMap' );
        $sm->addAttribute('id','smCanales');
        
        $s=$this->doc->addChild('Style');
        $s->addAttribute('id','canales_P');
        $ls=$s->addChild('LineStyle');
        $ls->addChild('color', '#FF0000FF');        
        $ls->addChild('width', '3');   
        $pair= $sm->addChild('Pair');
        $pair->addChild('key','normal');
        $pair->addChild('styleUrl','#canales_P');
        
        $s=$this->doc->addChild('Style');
        $s->addAttribute('id','canales_S');
        $ls=$s->addChild('LineStyle');
        $ls->addChild('color', '#FF0000CC');        
        $ls->addChild('width', '2');        
        $pair= $sm->addChild('Pair');
        $pair->addChild('key','normal');
        $pair->addChild('styleUrl','#canales_S');
        
        $s=$this->doc->addChild('Style');
        $s->addAttribute('id','canales_T');
        $ls=$s->addChild('LineStyle');
        $ls->addChild('color', '#FF0000AA');        
        $ls->addChild('width', '1');        
        $pair= $sm->addChild('Pair');
        $pair->addChild('key','normal');
        $pair->addChild('styleUrl','#canales_T');
        
        $s=$this->doc->addChild('Style');
        $s->addAttribute('id','canales_C');
        $ls=$s->addChild('LineStyle');
        $ls->addChild('color', '#FFFF0000');        
        $ls->addChild('width', '0.5');        
        $pair= $sm->addChild('Pair');
        $pair->addChild('key','normal');
        $pair->addChild('styleUrl','#canales_C');
        
        $s=$this->doc->addChild('Style');
        $s->addAttribute('id','canales_Corfo');
        $ls=$s->addChild('LineStyle');
        $ls->addChild('color', '#FFF00000');        
        $ls->addChild('width', '2');        
        $pair= $sm->addChild('Pair');
        $pair->addChild('key','normal');
        $pair->addChild('styleUrl','#canales_Corfo');
        
        $f=$super->addChild ( 'Folder' );
        $f->addChild ( 'name' , 'Canales de riego V.I.R.Ch.');
        
        $rs=Propel::getConnection()->query("select nombre, layer, st_askml(st_multi(st_force2d(st_setsrid(the_geom,22183)))) algo from canal where layer!='Rio Chubut'") ;
        while ($r=$rs->fetch(pdo::FETCH_ASSOC)) {
            $pm=$f->addChild('Placemark');
            switch ($r['layer']){
                case 'Canal P N':
                case 'Canal P S':
                    $pm->addChild('styleUrl','#canales_P');
                    break;
                case 'Canal Corfo':
                    $pm->addChild('styleUrl','#canales_Corfo');
                    break;
                case 'Canal Secund':
                    $pm->addChild('styleUrl','#canales_S');
                    break;
                case 'Canal Terciario':
                    $pm->addChild('styleUrl','#canales_T');
                    break;
                case 'Canal Comunero':
                    $pm->addChild('styleUrl','#canales_C');
                    break;
            }
            $pm->addChild('name',$r['nombre']);
            $from=simplexml_load_string($r['algo']);
            $this->sxml_append($pm, $from);
        }
        
        
        $super=$this->doc->addChild ( 'Folder' );
        $super->addChild ( 'name' , 'Biodiversidad y áreas protegidas');
        
        //////////// promotores ambientales
        $this->agregar($super, $zip, 'pa','Promotores ambientales',PromotorAmbientalQuery::create()->find(),true);
        
        /////////////  Monitoreo de Didymosphenia Geminata
        
        $s=$this->doc->addChild ( 'Style' );
        $s->addAttribute('id','dg1');
        $is=$s->addChild('IconStyle');
        $i=$is->addChild('Icon');
        $href=$this->source.'frontend-didymosphenia_geminata.png';
        $i->addChild('href', 'files/'.basename($href));
        $zip->addFile($href, 'files/' . basename($href));
        $s=$this->doc->addChild ( 'Style' );
        $s->addAttribute('id','dg0');
        $is=$s->addChild('IconStyle');
        $i=$is->addChild('Icon');
        $href=$this->source.'frontend-didymosphenia_geminata_ausente.png';
        $i->addChild('href', 'files/'.basename($href));
        $zip->addFile($href, 'files/' . basename($href));
        
        
        $ff=$super->addChild ( 'Folder' );
        $ff->addChild ( 'name' , 'Monitoreo de Didymosphenia Geminata');
        $rs=Propel::getConnection()->query('select nombre, descripcion, didymosphenia_geminata dg, st_askml( st_setsrid(st_centroid( the_geom) ,3857)) algo from didymosphenia_geminata') ;
        while ($r=$rs->fetch(pdo::FETCH_ASSOC)) {
            $pm=$ff->addChild('Placemark');
            $pm->addChild('styleUrl','#dg'.($r['dg']?'1':'0'));
            $pm->addChild('name',nl2br( htmlspecialchars(  $r['nombre'] )));
            $pm->addChild('description',nl2br( htmlspecialchars(   $r['descripcion']  )));
            $from=simplexml_load_string($r['algo']);
            $this->sxml_append($pm, $from);
        }
            
        
        
        ///////// ANP
        $kml = simplexml_load_file( sfProjectConfiguration::guessRootDir().'/data/ANP.kml' );
        foreach($kml->Document as $aux){
            foreach($aux as $que=>$elem){
//                 $this->sxml_append($kmlOutput->Document, $elem);
                $this->sxml_append($super, $elem);
            }
        }
        
        ///////// OTBN
        $kml = simplexml_load_file( sfProjectConfiguration::guessRootDir().'/data/OTBN.kml' );
        foreach($kml->Document as $aux){
            foreach($aux as $elem){
//                 $this->sxml_append($kmlOutput->Document, $elem);
                $this->sxml_append($super, $elem);
            }
        }
        
        
        $super=$this->doc->addChild ( 'Folder' );
        $super->addChild ( 'name' , 'Gestión de efluentes y residuos');
        
        
        ///////////////  girsu
        $superGirsu=$super->addChild ( 'Folder' );
        $superGirsu->addChild ( 'name' , 'Gestión Integral de Residuos Sólidos Urbanos (GIRSU)');

        
        $estos=array(
            'girsu_bca'=>'Basural a cielo abierto',
            'girsu_bca_saneado'=>'Basural saneado',
            'girsu_pst'=>'Planta de separación y transferencia',
            'girsu_rs'=>'Relleno sanitario'
        );
        foreach($estos as $capa=>$nombre){
            
            $s=$this->doc->addChild ( 'Style' );
            $s->addAttribute('id','st_'.$capa);
            $is=$s->addChild('IconStyle');
            $i=$is->addChild('Icon');
            $href=$this->source.'frontend-'.$capa.'.png';
            $i->addChild('href', 'files/'.basename($href));
            $zip->addFile($href, 'files/' . basename($href));
            $pair= $sm->addChild('Pair');
            $pair->addChild('key','normal');
            $pair->addChild('styleUrl','#st_'.$capa);
            
            
            $ff=$superGirsu->addChild ( 'Folder' );
            $ff->addChild ( 'name' , $nombre);
            
            $rs=Propel::getConnection()->query('select nombre, descripcion,  st_askml( st_setsrid(st_centroid( the_geom) ,3857)) algo from '.$capa) ;
            while ($r=$rs->fetch(pdo::FETCH_ASSOC)) {
                $pm=$ff->addChild('Placemark');
                $pm->addChild('styleUrl','#st_'.$capa);
                $pm->addChild('name',nl2br( htmlspecialchars(  $r['nombre'] )));
                $pm->addChild('description',nl2br( htmlspecialchars(   $r['descripcion']  )));
                $from=simplexml_load_string($r['algo']);
                $this->sxml_append($pm, $from);
            }
        }
        
        
        /////////////  PTLC
        $superPtlc=$super->addChild ( 'Folder' );
        $superPtlc->addChild ( 'name' , 'Plantas de Tratamiento de Líquidos Cloacales (PTLC)');
          
        
        
        $estos=array(
            'tratamiento_barro_activado'=>'Barro activado',
            'tratamiento_descarga'=>'Descarga',
            'tratamiento_humedal'=>'Humedal / Filtro fitoterrestre',
            'tratamiento_laguna_aireada'=>'Laguna aireada mecánicamente',
            'tratamiento_laguna_estabilizacion'=>'Laguna de estabilización',
            'tratamiento_sistema_anaerobico'=>'Sistema anaeróbico'
            
        );
        foreach($estos as $capa=>$nombre){
            
            $s=$this->doc->addChild ( 'Style' );
            $s->addAttribute('id','st_'.$capa);
            $is=$s->addChild('IconStyle');
            $i=$is->addChild('Icon');
            $href=$this->source.'frontend-'.$capa.'.png';
            $i->addChild('href', 'files/'.basename($href));
            $zip->addFile($href, 'files/' . basename($href));
            $pair= $sm->addChild('Pair');
            $pair->addChild('key','normal');
            $pair->addChild('styleUrl','#st_'.$capa);
            
            
            $ff=$superPtlc->addChild ( 'Folder' );
            $ff->addChild ( 'name' , $nombre);
            
            $rs=Propel::getConnection()->query('select nombre, descripcion, st_askml( st_setsrid(st_centroid( the_geom) ,3857)) algo from '.$capa) ;
            while ($r=$rs->fetch(pdo::FETCH_ASSOC)) {
                $pm=$ff->addChild('Placemark');
                $pm->addChild('styleUrl','#st_'.$capa);
                $pm->addChild('name',nl2br( htmlspecialchars(  $r['nombre'] )));
                $pm->addChild('description',nl2br( htmlspecialchars(   $r['descripcion']  )));
                $from=simplexml_load_string($r['algo']);
                $this->sxml_append($pm, $from);
            }
        }
        
        
        
        $super=$this->doc->addChild ( 'Folder' );
        $super->addChild ( 'name' , 'Actividades económicas, generación de energía');
        
        //////////////////  mineria
        
        $sm=$this->doc->addChild ( 'StyleMap' );
        $sm->addAttribute('id','smMineria');
        
        $f=$super->addChild ( 'Folder' );
        $f->addChild ( 'name' , 'Minería');
        foreach (MineriaPeer::$categorias  as $cat_nombre=>$cat){
            $sf=$f->addChild ( 'Folder' );
            $sf->addChild ( 'name' , $cat_nombre);
            foreach ($cat as $subcat_nombre=>$subcat){
                
                if($subcat_nombre==12){
                    
                    $id=12;                    
                    $sssf=$sf->addChild ( 'Folder' );
                    $sssf->addChild ( 'name' ,'Bancos en Río');
                    $s=$this->doc->addChild('Style');
                    $s->addAttribute('id','mineria_'.$id);
                    $is=$s->addChild('IconStyle');
                    $i=$is->addChild('Icon');
                    $href=$this->source.'frontend-mineria_'.$id.'.png';
                    $i->addChild('href', 'files/'.basename($href));
                    $zip->addFile($href, 'files/' . basename($href));
                    $pair= $sm->addChild('Pair');
                    $pair->addChild('key','normal');
                    $pair->addChild('styleUrl','#mineria_'.$id);
                    foreach (MineriaQuery::create()->findByCategoria($id) as $o){
                        $pm=$sssf->addChild('Placemark');
                        $pm->addChild('styleUrl','#mineria_'.$id);
                        $pm->addChild('name',$o->getNombre());
                        $pm->addChild('description',nl2br( htmlspecialchars( $o->getDescripcion() )));
                        $p=$pm->addChild('Point');
                        
                        $ll=Dummy::getLatLon( $o->getTheGeom());
                        $p->addChild('coordinates',$ll['lat'].','.$ll['lon'].',0');
                        
                    }
                    
                    continue;
                }
                
                $ssf=$sf->addChild ( 'Folder' );
                $ssf->addChild ( 'name' , $subcat_nombre);
                foreach ($subcat as $id=>$estado){
                    $sssf=$ssf->addChild ( 'Folder' );
                    $sssf->addChild ( 'name' , $estado);
                    $s=$this->doc->addChild('Style');
                    $s->addAttribute('id','mineria_'.$id);
                    $is=$s->addChild('IconStyle');
                    $i=$is->addChild('Icon');
                    $href=$this->source.'frontend-mineria_'.$id.'.png';
                    $i->addChild('href', 'files/'.basename($href));
                    $zip->addFile($href, 'files/' . basename($href));
                    $pair= $sm->addChild('Pair');
                    $pair->addChild('key','normal');
                    $pair->addChild('styleUrl','#mineria_'.$id);
                    foreach (MineriaQuery::create()->findByCategoria($id) as $o){
                        $pm=$sssf->addChild('Placemark');
                        $pm->addChild('styleUrl','#mineria_'.$id);
                        $pm->addChild('name',$o->getNombre());
                        $pm->addChild('description',nl2br( htmlspecialchars(  $o->getDescripcion() )));
                        $p=$pm->addChild('Point');
                        
                        $ll=Dummy::getLatLon( $o->getTheGeom());
                        $p->addChild('coordinates',$ll['lat'].','.$ll['lon'].',0');
                        
                    }
                }
            }
        }
        
        /////// paques eólicos
        $icons=array(
            1=>'NO operativo',
            2=>'Operativo',
        );
        $this->agregarGrupo2( $super, 'Parques Eólicos', 'parque-eolico', $icons, ParqueEolicoQuery::create()->find(), $zip );
        
        /////// gas
        $this->agregarKml($super, KmlPeer::TIPO_GAS_ESTACIONES_REGULADORAS, $zip);
        
        $s=$this->doc->addChild ( 'Style' );
        $s->addAttribute('id','st'.KmlPeer::TIPO_GAS_CANERIAS_TGS);
        $ls=$s->addChild ( 'LineStyle' );
        $ls->addChild ( 'color', 'ffffaa00');
        $ls->addChild ( 'width', 3 );
        $this->agregarKmlStyle('#st'.KmlPeer::TIPO_GAS_CANERIAS_TGS, $super, KmlPeer::TIPO_GAS_CANERIAS_TGS, $zip);
        
        $s=$this->doc->addChild ( 'Style' );
        $s->addAttribute('id','st'.KmlPeer::TIPO_GAS_CANERIAS_AP);
        $ls=$s->addChild ( 'LineStyle' );
        $ls->addChild ( 'color', 'ffffcc00');
        $ls->addChild ( 'width', 3 );
        $this->agregarKmlStyle('#st'.KmlPeer::TIPO_GAS_CANERIAS_AP, $super, KmlPeer::TIPO_GAS_CANERIAS_AP, $zip);
        
        
        //////////////////////   suelo
        $super=$this->doc->addChild ( 'Folder' );
        $super->addChild ( 'name' , 'Suelo');
        
        $s=$this->doc->addChild ( 'Style' );
        $s->addAttribute('id','st'.KmlPeer::TIPO_COVERTURA_DE_SUELOS);
        $ps=$s->addChild ( 'PolyStyle' );
        $ps->addChild ( 'color', '0AC896C8' );
        $ps->addChild ( 'fill', 1 );
        $ps->addChild ( 'outline', 1 );
        $ls=$s->addChild ( 'LineStyle' );
        $ls->addChild ( 'color', 'ffd856d8');
        $ls->addChild ( 'width', 1 );
        $this->agregarKmlStyle('#st'.KmlPeer::TIPO_COVERTURA_DE_SUELOS, $super, KmlPeer::TIPO_COVERTURA_DE_SUELOS, $zip);
        
        
        
        ///////////////  localidades
        $super=$this->doc->addChild ( 'Folder' );
        $super->addChild ( 'name' , 'Localidades');
        $estos=array(
            
            'local_1'=>'Municipios de 1ra cat.',
            'local_2'=>'Municipios de 2da cat.',
            'local_3'=>'Comunas rurales',
            'local_4'=>'Aldeas escolares',
            'local_5'=>'Parajes'
        );
        foreach($estos as $capa=>$nombre){
            
            $s=$this->doc->addChild ( 'Style' );
            $s->addAttribute('id','st_'.$capa);
            $is=$s->addChild('IconStyle');
            $i=$is->addChild('Icon');
            $href=$this->source.'frontend-'.$capa.'.png';
            $i->addChild('href', 'files/'.basename($href));
            $zip->addFile($href, 'files/' . basename($href));
            $pair= $sm->addChild('Pair');
            $pair->addChild('key','normal');
            $pair->addChild('styleUrl','#st_'.$capa);
            
            
            $ff=$super->addChild ( 'Folder' );
            $ff->addChild ( 'name' , $nombre);
            
            $rs=Propel::getConnection()->query('select nombre, descripcion,  st_askml( st_setsrid(st_centroid( the_geom) ,3857)) algo from '.$capa) ;
            while ($r=$rs->fetch(pdo::FETCH_ASSOC)) {
                $pm=$ff->addChild('Placemark');
                $pm->addChild('styleUrl','#st_'.$capa);
                $pm->addChild('name',nl2br( htmlspecialchars(  $r['nombre'] )));
                $pm->addChild('description',nl2br( htmlspecialchars(   $r['descripcion']  )));
                $from=simplexml_load_string($r['algo']);
                $this->sxml_append($pm, $from);
            }
        }
        
        
        $super=$this->doc->addChild ( 'Folder' );
        $super->addChild ( 'name' , 'Infraestructura urbana y rural');
        
        
        $estos=array(
            KmlPeer::TIPO_RUTAS_NACIONALES=>'00fcfc',
            KmlPeer::TIPO_RUTAS_PROVINCIALES=>'f0c0f0',
        );
        foreach($estos as $kml=>$color){
            
            $s=$this->doc->addChild ( 'Style' );
            $s->addAttribute('id','st'.$kml);
            $ls=$s->addChild ( 'LineStyle' );
            $ls->addChild ( 'color', 'ff'.$color );
            $ls->addChild ( 'width', 4 );
            
            $f=$super->addChild ( 'Folder' );
            $f->addChild ( 'name' , KmlPeer::$tipos[$kml]);
            
            $rs=Propel::getConnection()->query('select nombre, descripcion, st_askml(st_multi(st_force2d(st_setsrid(the_geom,3857)))) algo from kml where tipo='.$kml) ;
            while ($r=$rs->fetch(pdo::FETCH_ASSOC)) {
                $pm=$f->addChild('Placemark');
                $pm->addChild('styleUrl','#st'.$kml);
                $pm->addChild('name',$r['nombre']);
                $pm->addChild('description',nl2br( htmlspecialchars(  $r['descripcion']?$r['descripcion']:$r['nombre'])));
                $from=simplexml_load_string($r['algo']);
                $this->sxml_append($pm, $from);
            }
        }
        
        
        $estos=array(
            KmlPeer::TIPO_AEROPUERTOS,
            KmlPeer::TIPO_PUERTOS,
            KmlPeer::TIPO_ESCUELAS,
            KmlPeer::TIPO_ESTABLECIMIENTOS_RURALES,
            KmlPeer::TIPO_ESTANCIAS,
            KmlPeer::TIPO_GENERADORES_ELECTRICOS
        );
        foreach($estos as $kml){
            $this->agregarKml($super, $kml, $zip);
        }
        
        //////////// parcelario rural
        
        $estos=array(
            KmlPeer::TIPO_PARCELARIO_RURAL=>'FF7800',
        );
        foreach($estos as $kml=>$color){
            
            $s=$this->doc->addChild ( 'Style' );
            $s->addAttribute('id','st'.$kml);
            $ps=$s->addChild ( 'PolyStyle' );
            $ps->addChild ( 'color', '1F'.$color );
            $ps->addChild ( 'fill', 1 );
            $ps->addChild ( 'outline', 1 );
            $ls=$s->addChild ( 'LineStyle' );
            $ls->addChild ( 'color', 'ff'.$color );
            $ls->addChild ( 'width', 1 );
            
            $f=$super->addChild ( 'Folder' );
            $f->addChild ( 'name' , KmlPeer::$tipos[$kml]);
            
            $rs=Propel::getConnection()->query('select nombre, descripcion, st_askml(st_multi(st_force2d(st_setsrid(the_geom,3857)))) algo from kml where tipo='.$kml) ;
            while ($r=$rs->fetch(pdo::FETCH_ASSOC)) {
                $pm=$f->addChild('Placemark');
                $pm->addChild('styleUrl','#st'.$kml);
                $pm->addChild('name',$r['nombre']);
                $pm->addChild('description',nl2br( htmlspecialchars(  $r['descripcion']?$r['descripcion']:$r['nombre'])));
                $from=simplexml_load_string($r['algo']);
                $this->sxml_append($pm, $from);
            }
        }
        
        ///////////////////   estaciones de servicio
        
        $s=$this->doc->addChild ( 'Style' );
        $s->addAttribute('id','st_estacion_1');
        $is=$s->addChild('IconStyle');
        $i=$is->addChild('Icon');
        $href=$this->source.'frontend-estacion-1.png';
        $i->addChild('href', 'files/'.basename($href));
        $zip->addFile($href, 'files/' . basename($href));
        $s=$this->doc->addChild ( 'Style' );
        $s->addAttribute('id','st_estacion_2');
        $is=$s->addChild('IconStyle');
        $i=$is->addChild('Icon');
        $href=$this->source.'frontend-estacion-2.png';
        $i->addChild('href', 'files/'.basename($href));
        $zip->addFile($href, 'files/' . basename($href));
        
        
        $ff=$super->addChild ( 'Folder' );
        $ff->addChild ( 'name' , 'Estaciones de Servicio');
        
        $rs=Propel::getConnection()->query('select nombre, descripcion, estado, st_askml( st_setsrid(st_centroid( the_geom) ,3857)) algo from estacion') ;
        while ($r=$rs->fetch(pdo::FETCH_ASSOC)) {
            $pm=$ff->addChild('Placemark');
            $pm->addChild('styleUrl','#st_estacion_'.($r['estado']?'2':'1'));
            $pm->addChild('name',nl2br( htmlspecialchars(  $r['nombre'] )));
            $pm->addChild('description',nl2br( htmlspecialchars(   $r['descripcion']  )));
            $from=simplexml_load_string($r['algo']);
            $this->sxml_append($pm, $from);
        }
        
        
                  
        ////////////////////////////////////////
        $zip->addFromString('spia.kml', $kmlOutput->asXML());

        
        $zip->close();
        
        
        
        header("Content-type: application/zip");
        header('Content-Disposition: attachment; filename="spia_chubut.kmz"');
        header("Content-length: " . filesize($fn));
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile($fn);
        exit(0);
        
//         die('LISTO' );        
    }
    

/*        
    public function executeDescargarKml(sfWebRequest $request)
    {
        $this->source = sfConfig::get('sf_web_dir').'/images/';
        
        $kmlOutput = new SimpleXMLElement ( '<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom"/>' );
        $this->doc=$kmlOutput->addChild ( 'Document' );
        $this->doc->addChild ( 'name' , 'M.A.yC.D.S.');
 
        
        //////////////////  mineria
        
        $sm=$this->doc->addChild ( 'StyleMap' );
        $sm->addAttribute('id','smMineria');
        
        $f=$this->doc->addChild ( 'Folder' );
        $f->addChild ( 'name' , 'Minería');
        foreach (MineriaPeer::$categorias  as $cat_nombre=>$cat){
            $sf=$f->addChild ( 'Folder' );
            $sf->addChild ( 'name' , $cat_nombre);
            foreach ($cat as $subcat_nombre=>$subcat){
                
                if($subcat_nombre==12){
                    
                    $id=12;                    
                    $sssf=$sf->addChild ( 'Folder' );
                    $sssf->addChild ( 'name' ,'Bancos en Río');
                    $s=$this->doc->addChild('Style');
                    $s->addAttribute('id','mineria_'.$id);
                    $is=$s->addChild('IconStyle');
                    $i=$is->addChild('Icon');
                    $href=file_get_contents($this->source.'frontend-mineria_'.$id.'.png');
                    $i->addChild('href', 'data:image/png;base64,'.base64_encode($href));
                    
                    $pair= $sm->addChild('Pair');
                    $pair->addChild('key','normal');
                    $pair->addChild('styleUrl','#mineria_'.$id);
                    foreach (MineriaQuery::create()->findByCategoria($id) as $o){
                        $pm=$sssf->addChild('Placemark');
                        $pm->addChild('styleUrl','#mineria_'.$id);
                        $pm->addChild('name',$o->getNombre());
                        $pm->addChild('description',nl2br( htmlspecialchars( '<![CDATA['.$o->getDescripcion().']]>')));
                        $p=$pm->addChild('Point');
                        
                        $ll=Dummy::getLatLon( $o->getTheGeom());
                        $p->addChild('coordinates',$ll['lat'].','.$ll['lon'].',0');
                        
                    }
                    
                    continue;
                }
                
                $ssf=$sf->addChild ( 'Folder' );
                $ssf->addChild ( 'name' , $subcat_nombre);
                foreach ($subcat as $id=>$estado){
                    $sssf=$ssf->addChild ( 'Folder' );
                    $sssf->addChild ( 'name' , $estado);
                    $s=$this->doc->addChild('Style');
                    $s->addAttribute('id','mineria_'.$id);
                    $is=$s->addChild('IconStyle');
                    $i=$is->addChild('Icon');
                    $href=file_get_contents($this->source.'frontend-mineria_'.$id.'.png');
                    $i->addChild('href', 'data:image/png;base64,'.base64_encode($href));
                    
                    $pair= $sm->addChild('Pair');
                    $pair->addChild('key','normal');
                    $pair->addChild('styleUrl','#mineria_'.$id);
                    foreach (MineriaQuery::create()->findByCategoria($id) as $o){
                        $pm=$sssf->addChild('Placemark');
                        $pm->addChild('styleUrl','#mineria_'.$id);
                        $pm->addChild('name',$o->getNombre());
                        $pm->addChild('description',nl2br( htmlspecialchars( '<![CDATA['.$o->getDescripcion().']]>')));
                        $p=$pm->addChild('Point');
                        
                        $ll=Dummy::getLatLon( $o->getTheGeom());
                        $p->addChild('coordinates',$ll['lat'].','.$ll['lon'].',0');
                        
                    }
                }
            }
        }
        

        /////////////  tratamiento

        $icons=array(
            5=>'barro_activado',
            1=>'descarga',
            3=>'humedal',
            6=>'laguna_aireada',
            4=>'laguna_estabilizacion',
            2=>'sistema_anaerobico'
        );
        
        $this->agregarGrupo('Plantas de tratamiento', 'tratamiento', TratamientoPeer::$tipos, $icons,TratamientoQuery::create() );
        
        
        /////////////  GIRSU
        
        $icons=array(
            1=>'bca',
            8=>'bca_saneado',
            3=>'pst',
            6=>'rs'
        );
        
        $this->agregarGrupo('Gestión Integral de Residuos Sólidos Urbanos', 'girsu', GirsuPeer::$tipos, $icons, GirsuQuery::create() );
        
        
        /////// estaciones
        
        $icons=array(
            1=>'NO operativo',
            2=>'Operativo',
        );
        
        $this->agregarGrupo2( $super, 'Estaciones de Servicio', 'estacion', $icons, EstacionQuery::create()->find() );
        
        
        /////// paques eólicos
        
        $icons=array(
            1=>'NO operativo',
            2=>'Operativo',
        );
        
        $this->agregarGrupo2( 'Parques Eólicos', 'parque-eolico', $icons, ParqueEolicoQuery::create()->find() );
        
        ///////////////////   promotores ambientales
        
            
        $s=$this->doc->addChild('Style');
        $s->addAttribute('id','_style_promotores_ambientales');
        $is=$s->addChild('IconStyle');
        $i=$is->addChild('Icon');
        $href=file_get_contents($this->source.'frontend-promotor_ambiental.png');
        $i->addChild('href', 'data:image/png;base64,'.base64_encode($href));
    
        $ff=$this->doc->addChild ( 'Folder' );
        $ff->addChild ( 'name' , 'Promotores Ambientales');
        
        foreach (PromotorAmbientalQuery::create()->find() as $o){
            $pm=$ff->addChild('Placemark');
            $pm->addChild('styleUrl','#_style_promotores_ambientales');
            $pm->addChild('name',nl2br( htmlspecialchars( '<![CDATA['.$o->getNombre().']]>')));
            $pm->addChild('description',nl2br( htmlspecialchars( '<![CDATA['.$o->getDescripcion().']]>')));
            $p=$pm->addChild('Point');
            $ll=Dummy::getLatLon( $o->getTheGeom());
            $p->addChild('coordinates',$ll['lat'].','.$ll['lon'].',0');
        }
        
        
        /////////////   sitios de toma de muestras

        $sm=$this->doc->addChild ( 'StyleMap' );
        $sm->addAttribute('id','smLugares');
        
        $f=$this->doc->addChild ( 'Folder' );
        $f->addChild ( 'name' , 'Sitios de toma de muestras');
        
        foreach (TipoMuestraQuery::create()->find() as $tipo){
            $s=$this->doc->addChild('Style');
            $s->addAttribute('id','_style_lugares_'.$tipo->getId());
            $is=$s->addChild('IconStyle');
            $i=$is->addChild('Icon');
            $href=file_get_contents($this->source.'/tipo-muestra/'.$tipo->getArchivo());
            $i->addChild('href', 'data:image/png;base64,'.base64_encode($href));

            foreach (LugarExtraccionQuery::create()->findByTipoId($tipo->getId()) as $o){
                $pm=$f->addChild('Placemark');
                $pm->addChild('styleUrl','#_style_lugares_'.$tipo->getId());
                $pm->addChild('name',nl2br( htmlspecialchars( '<![CDATA['.$o->getNombre().']]>')));
                $p=$pm->addChild('Point');
                
                $ll=Dummy::getLatLon( $o->getTheGeom());
                $p->addChild('coordinates',$ll['lat'].','.$ll['lon'].',0');
            }
        }
        
        
        ///////////////////////////////
        
        $this->getResponse()->setHttpHeader('Content-type','application/vnd.google-earth.kml+xml kml');
        $this->getResponse()->setHttpHeader('Content-Disposition','attachment; filename="spia-maycds-mapas-ambientales.kml"');
        return $this->renderText( html_entity_decode( $kmlOutput->asXML() , ENT_NOQUOTES, 'UTF-8'));
    }
    */
    protected $geoserver ='http://localhost:8080/geoserver/ambiente/';
    
    public function executeWms(sfWebRequest $request)
    {
        
       
        $params =$request->getParameterHolder()->getAll();
        unset($params['module'],$params['action']);
        
        $b = new sfWebBrowser();
        $b->get($this->geoserver.'wms',$params);
        
        sfConfig::set('sf_web_debug', false);
        return $this->renderText( $b->getResponseText() );
    }
    
    
    public function executeOws(sfWebRequest $request)
    {
        $request->setMethod(sfWebRequest::GET );
        $params =$request->getParameterHolder()->getAll();
        unset($params['module'],$params['action']);
        
        $b = new sfWebBrowser();
        $b->get($this->geoserver.'ows',$params);
        
        $this->getResponse()->setHttpHeader('Content-type', 'text/xml; subtype=gml/3.1.1');
        
        sfConfig::set('sf_web_debug', false);
        return $this->renderText( $b->getResponseText() );
    }
    
    
    public function executeLugares(sfWebRequest $request)
    {
        
        $this->getResponse()->setHttpHeader('Content-type', 'text/xml; subtype=gml/3.1.1');
        
        $this->lugares = LugarExtraccionQuery::create()->innerJoinWithLocalidad()
            ->withColumn("ST_Y( st_transform( ST_Centroid(the_geom) ,'EPSG:3857', 'EPSG:4326') )",'lat')
            ->withColumn("ST_X( st_transform( ST_Centroid(the_geom) ,'EPSG:3857', 'EPSG:4326') )",'lon')
            ->find();
        
            
            $this->setLayout(false);
        sfConfig::set('sf_web_debug', false);
        //return $this->renderText( $b->getResponseText() );
    }
    
    
  public function executeIndex(sfWebRequest $request)
  {
      
      $this->url = str_ireplace('frontend', 'backend', sfContext::getInstance()->getRouting()->generate('homepage',array(), true) );
        
     // if($this->getContext()->getConfiguration()->getEnvironment()=='dev'){
          $this->setTemplate('index2');
          $this->setLayout(false);
          sfConfig::set('sf_web_debug', false);
      //}
      
    
  }
    
  public function executeIframe(sfWebRequest $request)
  {
      $this->layer_names=array();
      $this->attributions=array();
      $this->attributions=join(',', $this->attributions);
      $this->layer_names=join(',', $this->layer_names);
      
      $this->esquema=$this->recu();
  }
  
  public function recu($esquema_id=null)
  {
      $r=array();
      foreach (EsquemaQuery::create()->orderByOrden()->findByEsquemaId($esquema_id) as $nodo){
          $r[]=(object)array(
              'nombre'=>$nodo->getNombre(),
              'fuente'=>$nodo->getFuente(),
              'nodes'=>$this->recu($nodo->getId()),
              'id'=>$nodo->getId(),
              'archivo'=>$nodo->getArchivo(),
              'color'=>$nodo->getColor(),
              'base'=>$nodo->getEsCapaBase()
          );
      }
      
      return count($r)? $r : null;
  }
  public function executeProxy(sfWebRequest $request)
  {
      $request->setMethod(sfWebRequest::GET );
      $params =$request->getParameterHolder()->getAll();
      unset($params['module'],$params['action']);
      
      
      $b = new sfWebBrowser();
      
      $b->get('http://ambiente.chubut.gov.ar/',$params);
      
        sfConfig::set('sf_web_debug', false);
      return $this->renderText( $b->getResponseText() );
      
  }
}
