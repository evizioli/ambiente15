<?php

require ProjectConfiguration::guessRootDir().'/plugins/comunPlugin/lib/vendor/autoload.php';


class Muestra extends BaseMuestra {

    public function __call($name, $arguments)
    {
        if(substr($name, -6)=='ConLim'){
            return $this->conLim(substr($name, 0, strlen($name)-6)) ;
        }
        return call_user_func_array(array(parent::class,$name), $arguments);
    }
        
    
    public function getDivisionAlgal()
    {
        $r=array();
        return $this->getDa1(true).$this->getDa2(true).$this->getDa3(true).$this->getDa4(true).$this->getDa5(true);
    }
    
    public function getDa1($nombre=false)
    {
        if($nombre) return sfContext::getInstance()->getI18N()->__('Da1', array()).' - ';
        return $this->da1;
    }
    
    /**
     * Get the [da2] column value.
     *
     * @return     boolean
     */
    public function getDa2($nombre=false)
    {
        if($nombre) return sfContext::getInstance()->getI18N()->__('Da2', array()).' - ';
        return $this->da2;
    }
    
    /**
     * Get the [da3] column value.
     *
     * @return     boolean
     */
    public function getDa3($nombre=false)
    {
        if($nombre) return sfContext::getInstance()->getI18N()->__('Da3', array()).' - ';
        return $this->da3;
    }
    
    /**
     * Get the [da4] column value.
     *
     * @return     boolean
     */
    public function getDa4($nombre=false)
    {
        if($nombre) return sfContext::getInstance()->getI18N()->__('Da4', array()).' - ';
        return $this->da4;
    }
    
    /**
     * Get the [da5] column value.
     *
     * @return     boolean
     */
    public function getDa5($nombre=false)
    {
        if($nombre) return sfContext::getInstance()->getI18N()->__('Da5', array()).' - ';
        return $this->da5;
    }
    
    
    public function postDelete(PropelPDO $con = null)
    {
        parent::postDelete($con);
        $body ='Este es un mensaje automático para informar que la muestra n° '.$this->getNumero().
        ' (protocolo '.$this->getProtocoloYe().') ha sido eliminada de la base de datos por el usuario '.
        sfContext::getInstance()->getUser()->getNombre().
        ' el día '.date('d/m/Y').' a las '.date('H:i');
        
        $this->notificar( 'Muestra ELIMINADA', $body);
    }
    
    public function postUpdate(PropelPDO $con = null) 
    { 
        parent::postUpdate($con);
        $body ='Este es un mensaje automático para informar que la muestra n° '.$this->getNumero().
        ' (protocolo '.$this->getProtocoloYe().') ha sido modificada en la base de datos por el usuario '.
        sfContext::getInstance()->getUser()->getNombre().
        ' el día '.date('d/m/Y').' a las '.date('H:i');
        
        $this->notificar( 'Muestra MODIFICADA', $body);
    }
    
    public function postInsert(PropelPDO $con = null)
    {
        parent::postInsert($con);
        $body ='Este es un mensaje automático para informar que la muestra n° '.$this->getNumero().
        ' (protocolo '.$this->getProtocoloYe().') ha sido insertada en la base de datos por el usuario '.
        sfContext::getInstance()->getUser()->getNombre().
        ' el día '.date('d/m/Y').' a las '.date('H:i');
        
        $this->notificar( 'Muestra AGREGADA', $body);
    }
    
    public function postSave(PropelPDO $con = null) { 
        parent::postSave($con);
        if($this->getAlerta()){
            
            $mailer=sfContext::getInstance()->getMailer();
            
            $emails = array();
            $estos= UsuarioQuery::create()->useUsuarioGrupoQuery()->filterByGrupoId(GrupoPeer::ALERTAR)->endUse()->find();
            foreach($estos as $u){
                $emails[$u->getEmail()]=$u->getNombre();
            }
            $body=sprintf('Este es un mensaje automático para informar que la muestra n° %d (protocolo %d) tiene una ALERTA informada en la base de datos por el usuario %s el día %s a las %s. Lugar de la muestra: %s',
                $this->getNumero(),
                $this->getProtocoloYe(),
                sfContext::getInstance()->getUser()->getNombre(),
                date('d/m/Y'),
                date('H:i'),
                $this->getLugarExtraccion()
            );
            $m = $mailer->compose(
                ProjectConfiguration::EMAIL,
                $emails,
                'Alerta de muestra - '.ProjectConfiguration::NOMBRE_ENTIDAD,
                $body
                );
            $m->addPart( nl2br( htmlentities( $body )), 'text/html' );
                
            try {
                $mailer->send($m);
            } catch (Exception $e) {
            }
        }
    }
    
    protected function notificar( $subject, $body)
    {
        $mailer=sfContext::getInstance()->getMailer();
        
        $emails = array();
        $estos= UsuarioQuery::create()->useUsuarioGrupoQuery()->filterByGrupoId(GrupoPeer::NOTIFICAR)->endUse()->find();
        foreach($estos as $u){
            $emails[$u->getEmail()]=$u->getNombre();
        }

        
        $m = $mailer->compose(
            ProjectConfiguration::EMAIL,
            $emails,
            $subject.'- '.ProjectConfiguration::NOMBRE_ENTIDAD,
            $body
            );
        $m->addPart( nl2br( htmlentities( $body )), 'text/html' );
            
        try {
            $mailer->send($m);
        } catch (Exception $e) {
        }
//             US
//--------------------
//              and them
        
        $emails = array();
        $estos= UsuarioQuery::create()
        ->useUsuarioGrupoQuery()
            ->useGrupoQuery()
                ->useGrupoLocalidadQuery()
                ->filterByLocalidadId($this->getLugarExtraccion()?$this->getLugarExtraccion()->getLocalidadId() :null)
                ->endUse()
            ->endUse()
        ->endUse()
        ->groupById()
        ->find();
        
        foreach ($estos as $u){
            $emails[$u->getEmail()]=$u->getNombre();
        }
        
        $body2="La Dirección de Ry SIA le informa que ha sido actualizada la base del Sist Prov de Información Ambiental con nuevos datos pertenecientes a su ejido.";        
        $m = $mailer->compose(
            ProjectConfiguration::EMAIL,
            $emails,
            $subject.'- '.ProjectConfiguration::NOMBRE_ENTIDAD,
            $body2
            );
        $m->addPart( nl2br( htmlentities( $body2 )), 'text/html' );
            
        try {
            $mailer->send($m);
        } catch (Exception $e) {
        }
        
    }
    
    public function getProtocoloYe()
    {
        return $this->protocolo.'/'.$this->ye;
    }
    
    public function getCoordenadasGeograficas()
    {
        if(!$le= $this->getLugarExtraccion()) return null;
        $value = Dummy::geomToWkt($le->getTheGeom());
        list ($lat, $lon) = Dummy::getLatLon(Dummy::getCentroid($value));
        return Dummy::aGMS($lat, $lon);
    }
    
    
    public function vistaImpresion(ProtocoloPdf $pdf)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Number','Asset','Date', 'I18N'));
        $mg=$pdf->getMargins();

        
        $pdf->proto =array(
            array($this->getSolicitadoPor() ,'<b>A solicitud</b>'),
            array($this->getResponsable()? $this->getResponsable()->__toString() : '','<b>Responsable del muestreo</b>'),
            array($this->getTipoMuestra(),'<b>Matriz de la muestra</b>'),
            array($this->getLugarExtraccion()?$this->getLugarExtraccion()->__toString():'','<b>Lugar</b>'),
            array($this->getCoordenadasGeograficas(),'<b>Coordenadas geográficas</b>'),
            array($this->getFecha('d/m/Y'),'<b>Fecha de extracción</b>'),
            array($this->getRotuloPrecinto(),'<b>Rótulo / precinto</b>')
        );
        $pdf->AddPage();
        
        $pdf->SetY($pdf->cuerpo);
        
        
        $pdf->SetFont(PDF_FONT_NAME_MAIN,'',9);
        
        $estosNo=array(
            'id',
            'numero',
            'tipo_id',
            'protocolo',
            'solicitado_por',
            'observaciones',
            'lugar_de_extraccion_id',
            'fecha',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'mostrar',
            'responsable_id',
            'rotulo_precinto',
            'ye',
            'the_geom',
//             'ma_archivo',
            'ma_nombre_original',
            'ma_mime',
            'alerta',
            'conductividad_electrica_unidad'
        );
        $estosCambiar=array(
            'didymosphenia_geminata'=>'didymosphenia_geminata_pa',
            'da1'=>'da1_pa',
            'da2'=>'da2_pa',
            'da3'=>'da3_pa',
            'da4'=>'da4_pa',
            'da5'=>'da5_pa',
            'ma_archivo'=>'ma_archivo_leyenda',
            'conductividad_electrica'=>'conductividad_electrica_'.$this->conductividad_electrica_unidad,
        );
        
        $f=new sfNumberFormat(_current_language('es'));
        $tm= MuestraPeer::getTableMap();
        
        $cols=$tm->getColumns();
        
        
        foreach ($cols as $co){
            $c=MuestraPeer::translateFieldName(strtoupper( $co->getName()), BasePeer::TYPE_RAW_COLNAME, BasePeer::TYPE_FIELDNAME);
            if(in_array($c, $estosNo) || substr($c, -4)=='_lim') continue;
            
            if(array_key_exists($c, $estosCambiar)) {
                $c=$estosCambiar[$c];
                $m='get'.sfInflector::camelize($c);
            } else {
                $m= 'get'.$co->getPhpName();
            }
            $tit=__(sfInflector::humanize($c), array(), 'messages');
                
            $p=null;
            if(method_exists($this, $m.'Lim')){
                $p=$m;
                $m='conLim';
            }
            $tmp = is_null($p) ? $this->$m() : $this->$m($p);
            if(!(is_null($tmp) || trim($tmp)=='')) {
                $tmp =preg_replace('/,0+$/', '',  is_numeric($tmp) ?  $f->format( $tmp ) : $tmp);
                $pdf->fila(array(
                    array('texto'=>$tit, 'ancho'=>60 ),
                    array('texto'=>$tmp, 'ancho'=>30, 'ali'=>'C'),
                    array('texto'=>$this->getMetodo($c), 'ancho'=>$pdf->getPageWidth()-($mg['left']+$mg['right']+90)),
                ));
            }
        }
        $o='<b><u>OBSERVACIONES: </u></b>'.nl2br( htmlspecialchars( $this->observaciones));
        $aux = $pdf->getStringHeight($pdf->getPageWidth()-($mg['left']+$mg['right']), $o);
        if($aux+$pdf->GetY()>ProtocoloPdf::PIE){
            $pdf->AddPage();
            $y=$pdf->cuerpo;
        } else {
            $y = $pdf->GetY();
        }
        $pdf->writeHTMLCell($pdf->getPageWidth()-($mg['left']+$mg['right']),0,$mg['left'] ,$y, $o, null,1);
        
        $pdf->SetFontSize(8);
        $y =$pdf->GetY()+5;
        $pdf->writeHTMLCell($pdf->getPageWidth()-($mg['left']+$mg['right']),0,$mg['left'] ,$y, 'Los resultados consignados se refieren exclusivamente a las muestras recibidas y/o sometidas a ensayo. El Laboratorio declina toda responsabilidad por el uso indebido que se hiciere de éste informe.', null,null,null,1,'J');

        
        $pdf->lastPage();
        $pdf->Output( $this->__toString());
        
    }
    
    public function __toString()
    {
        return $this->numero.' - '.$this->getLugarExtraccion();
    }
    
    public function getConductividadElectricaConUnidad(){
        return $this->getConductividadElectrica(). ( $this->getConductividadElectrica() ? ' '.MuestraPeer::$conduc[$this->getConductividadElectricaUnidad()]: '' );
    }
    
    public function getConductividadElectrica0(){
        return $this->getConductividadElectrica();
    }
    
    public function getConductividadElectrica1(){
        return $this->getConductividadElectrica();
    }
    
    public function getMetodo($c)
    {
        switch ($c){
            case 'temperatura':
            case 'ph':
            case 'conductividad_electrica':
            case 'conductividad_electrica_0':
            case 'conductividad_electrica_1':
                $r='Medición in situ con sonda OAKTON PC450';
                break;
            case 'od_mg_l':
            case 'od_porcentaje':
                $r='IRAM 29009 Medición con Sonda YSI 550A';
                break;
            case 'turbiedad_unt':
                $r='SM 2130 B';
                break;
            case 'cloruros_mg_l':
                $r='SM 4500 Cl B';
                break;
            case 'dureza_ca_co3_mg_l':
                $r='SM 2340 C';
                break;
            case 'calcio_mg_l':
                $r='SM 2500-Ca D';
                break;
            case 'magnesio_mg_l':
                $r='SM 3500-Mg E';
                break;
            case 'sulfatos_mg_l':
                $r='SM 4500 SO42- E';
                break;
            case 'dbo5_mg_l':
                $r='SM 5210 B';
                break;
            case 'dqo_mg_l':
                $r='HACH 8000';
                break;
            case 'sol_sup_tot_103_105_mg_l':
                $r='SM 2540 D';
                break;
            case 'solidos_sedimentables_10min_mg_l':
            case 'solidos_sedimentables_1h_mg_l':
            case 'solidos_sedimentables_2h_mg_l':
                $r='SM 2540 F';
                break;
            case 'sol_dis_tot':
                $r='SM 2540 C';
                break;
            case 'sol_dis_fijos':
            case 'sol_dis_volat':
            case 'sol_totales_fijos_mg_l':
            case 'sol_totales_volatiles_mg_l':
                $r='SM 2540 E';
                break;
            case 'sol_tot_105_mg_l':
                $r='SM 2540 B';
                break;
            case 'fenoles':
                $r='HACH 8047 (USEPA 420.1)';
                break;
            case 'ras':
                $r='Por cálculo  (Water Quality Criteria EPA año 1973)';
                break;
            case 'sodio_mg_l':
                $r='SM 3500-Na D';
                break;
            case 'potasio_mg_l':
                $r='SM 3500-K D';
                break;
            case 'grasas_aceites':
                $r='EPA 1664';
                break;
            case 'nmp_coliformes_totales_100':
                $r='Técnica del Número más Probable - SM 9221 B';
                break;
            case 'nmp_coliformes_fecales_100':
                $r='Técnica del Número más Probable - SM 9221 E';
                break;
            case 'nmp_escherichia_coli_100':
                $r='Técnica del Número más Probable - SM 9221 F';
                break;
            case 'nmp_enterococos_fecales_100':
                $r='Técnica del Número más Probable - Rothe/Litsky';
                break;
            case 'fosforo_reactivo_disuelto':
                $r='HACH 8048';
                break;
            case 'nitratos':
                $r='HACH 8039';
                break;
            case 'detergentes_anionicos':
                $r='SM 5540 C';
                break;
            case 'as':
            case 'cd':
            case 'cr':
            case 'cu':
            case 'pb':
            case 'zn':
            case 'fe':
            case 'mn':
                $r='ICP - AES';
                break;
            case 'alcalinidad_total':
            case 'carbonatos':
            case 'bicarbonatos':
                $r='SM 2320B';
                break;
            case 'fluoruros':
                $r='Electrodo ion selectivo - EPA 340.2';
                break;
            default:
                $r='';
        }
        return $r;    
    }
    
    
    public function getDidymospheniaGeminataPa()
    {
        if(!is_null($this->didymosphenia_geminata )){
            return $this->didymosphenia_geminata ?  'Detectada': 'No Detectada' ;
        }
        return null;
    }
    
    public function getDa1Pa()
    {
        if(!is_null($this->da1)){
            return $this->da1 ?  'Detectada': 'No Detectada' ;
        }
        return null;
    }
    
    
    public function getDa2Pa()
    {
        if(!is_null($this->da2)){
            return $this->da2 ?  'Detectada': 'No Detectada' ;
        }
        return null;
    }
    
    
    public function getDa3Pa()
    {
        if(!is_null($this->da3)){
            return $this->da3 ?  'Detectada': 'No Detectada' ;
        }
        return null;
    }
    
    
    public function getDa4Pa()
    {
        if(!is_null($this->da4)){
            return $this->da4 ?  'Detectada': 'No Detectada' ;
        }
        return null;
    }
    
    
    public function getDa5Pa()
    {
        if(!is_null($this->da5)){
            return $this->da5 ?  'Detectada': 'No Detectada' ;
        }
        return null;
    }
    
    public function getMaArchivoLeyenda()
    {
        return $this->ma_archivo ? 'Doc. adjunto': null;
    }
    
    
    
    public function getMaArchivoLink()
    {
        return $this->ma_archivo ? link_to('Doc. adjunto','muestras/adjunto?id='.$this->id ): null;
    }
    
    
    public function getLocalidad()
    {
        return $this->getLugarExtraccion()->getLocalidad();    
    }
    
    public function getMapa()  {
        

        $r= <<<EOD
<div id="mapa" style="width: 500px; height:300px"></div>
<script type="text/javascript">
//<![CDATA[

function initMap(){
    var lat=%s;
    var lon=%s;
    var map = new google.maps.Map(document.getElementById('mapa'), { center: new google.maps.LatLng(lat, lon ), zoom: 15 });
    var point = new google.maps.LatLng(lat,lon );
    var marker = new google.maps.Marker({ map: map, position: point });
}
//]]>
</script>
<script async type="text/javascript" src="https://maps.google.com/maps/api/js?key=%s&amp;callback=initMap"></script>
EOD;
        
        list($lat,$lon)=Propel::getConnection()->query("select
            ST_Y( st_transform( ST_Centroid( the_geom ) ,'EPSG:3857', 'EPSG:4326') )lat,
            ST_X( st_transform( ST_Centroid( the_geom ) ,'EPSG:3857', 'EPSG:4326') )lon
            from muestra where id=".$this->id )->fetch(PDO::FETCH_NUM);
        
        return sprintf($r, $lat, $lon , ProjectConfiguration::GM_API_KEY);
    }
    
    public function getConLim($m)
    {
        return $this->conLim($m);
    }
    public function conLim($m)
    {
        
        $f=new sfNumberFormat( 'es' );
        $ml=$m.'Lim';
        if($this->$ml()==1) {
            return '> '.$f->format( $this->$m());
        } elseif($this->$ml()==-1) {
            return '< '.$f->format( $this->$m());
        } elseif($this->$ml()==2) {
            return '≥ '.$f->format( $this->$m());
        } elseif($this->$ml()==-2) {
            return '≤ '.$f->format( $this->$m());
        }
        return is_null($this->$m()) ? null : $f->format( $this->$m());
    }
    
    
    
    public function getNmpEnterococosFecales100($con_lim=false)
    {
        return $con_lim ? $this->conLim(__FUNCTION__) : call_user_func_array(array(parent::class,__FUNCTION__), array());
    }
    
    public function getNmpEscherichiaColi100($con_lim=false)
    {
        return $con_lim ? $this->conLim(__FUNCTION__) : call_user_func_array(array(parent::class,__FUNCTION__), array());
    }
    
    public function getNmpColiformesTotales100($con_lim=false)
    {
        return $con_lim ? $this->conLim(__FUNCTION__) : call_user_func_array(array(parent::class,__FUNCTION__), array());
    }
    
    public function getNmpColiformesFecales100($con_lim=false)
    {
        return $con_lim ? $this->conLim(__FUNCTION__) : call_user_func_array(array(parent::class,__FUNCTION__), array());
    }

    //PARA EL LISTADO
    public function getNmpEnterococosFecales100ConLim()
    {
        return $this->getNmpEnterococosFecales100(true);
    }
    
    public function getNmpEscherichiaColi100ConLim()
    {
        return $this->getNmpEscherichiaColi100(true);
    }
    
    public function getNmpColiformesTotales100ConLim()
    {
        return $this->getNmpColiformesTotales100(true);
    }
    
    public function getNmpColiformesFecales100ConLim()
    {
        return $this->getNmpColiformesFecales100(true);
    }
    
    public function getTipoLugar()
    {
        return $this->getLugarExtraccion()->getTipoMuestra();
    }
    
    public function getLugarTipo()
    {
        $r = $this->getLugarExtraccion()->__toString();
        if($t=$this->getLugarExtraccion()->getTipoMuestra()){
            $r.=' ('.$t.')';
        }
        return $r;
    }
    
} // Muestra
