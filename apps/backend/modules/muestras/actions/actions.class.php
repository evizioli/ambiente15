<?php

require_once dirname(__FILE__).'/../lib/muestrasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/muestrasGeneratorHelper.class.php';



require ProjectConfiguration::guessRootDir().'/plugins/comunPlugin/lib/vendor/autoload.php';



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class muestrasActions extends autoMuestrasActions
{
    
    
    public function executeAdjunto(sfWebRequest $r)
    {
        
        if ($doc = MuestraQuery::create()->findPk($r->getParameter('id'))) {
            
            $this->getResponse()->setHttpHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
            $this->getResponse()->setHttpHeader('Pragma', 'public');
            $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename="' . $doc->getMaNombreOriginal() . '"');
            $this->getResponse()->setHttpHeader('Expires', '0');
            $this->getResponse()->setContentType($doc->getMaMime() . '; charset=utf-8');
            $this->setLayout(false);
            return $this->renderText(file_get_contents(MuestraPeer::path().$doc->getMaArchivo() ));
        }
        $this->forward404();
    }
    
    public function executeListExportar(sfWebRequest $request)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Number','Asset','Date', 'I18N'));
        
        
        $estosNo=array(
            'id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'ye',
            'the_geom'
        );
        $estosCambiar=array(
            'didymosphenia_geminata'=>'didymosphenia_geminata_pa',
            'tipo_id'=>'tipo_muestra',
            'lugar_de_extraccion_id'=>'lugar_extraccion',
            'responsable_id'=>'responsable',
        );
        
        $tm= MuestraPeer::getTableMap();
        
        
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $columnIndex=1;

        foreach ($tm->getColumns() as $co){
            $c=MuestraPeer::translateFieldName(strtoupper( $co->getName()), BasePeer::TYPE_RAW_COLNAME, BasePeer::TYPE_FIELDNAME);
            if(in_array($c, $estosNo) || substr($c, -4)=='_lim') continue;
            
            $t=__(sfInflector::humanize($c), array(), 'messages');
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex++, 1, $t);
        }
        $row=2;
        foreach ($this->buildQuery()->find() as $muestra){
            $columnIndex=1;
            foreach ($tm->getColumns() as $co){

                $c=MuestraPeer::translateFieldName(strtoupper( $co->getName()), BasePeer::TYPE_RAW_COLNAME, BasePeer::TYPE_FIELDNAME);
                if(in_array($c, $estosNo) || substr($c, -4)=='_lim') continue;
            
                switch ($c){
                    case 'fecha':
                        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($columnIndex, $row, Date::PHPToExcel(strtotime($muestra->getFecha())));
                        $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($columnIndex,$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                        break;
                    default:

                        
                        
                        if(array_key_exists($c, $estosCambiar)) {
                            $c=$estosCambiar[$c];
                            $m='get'.sfInflector::camelize($c);
                        } else {
                            $m= 'get'.$co->getPhpName();
                            
                        }
                        $p=null;
                        if(method_exists($this, $m.'Lim')){
                            $p=$m;
                            $m='conLim';
                        }
                        $tmp =$muestra->$m($p);
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
        header('Content-Disposition: attachment;filename="muestras.xlsx"');
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
    
    public function executeListProtocolo(sfWebRequest $request)
    {
        $muestra = MuestraQuery::create()->findPk($request->getParameter('id'));
        error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_STRICT ^ E_DEPRECATED );
        
        $this->getResponse()->setHttpHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0' );
        $this->getResponse()->setHttpHeader('Pragma', 'public' );
        $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename="'.$muestra->getProtocolo().' - '.$muestra->getLugarExtraccion().' - '.$muestra->getNumero() .'.pdf"' );
        $this->getResponse()->setHttpHeader('Expires', '0' );
        
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Number','Asset','Date'));
        $muestra->vistaImpresion(new ProtocoloPdf($muestra) );
        // Stop symfony process
        throw new sfStopException();
        return sfView::NONE;
    }
    
    public function executeView(sfWebRequest $request)
    {
        $this->Muestra = $this->getRoute()->getObject();
        
        
            $estosNo=array(
                'id',
                'mostrar',
                'ye',
                'created_at',
                'updated_at',
                'created_by',
                'updated_by',
                'the_geom',
//                 'ma_archivo',
                'ma_nombre_original',
                'ma_mime',
            );
            $estosCambiar=array(
                'protocolo'=>'protocolo_ye',
                'tipo_id'=>'tipo_muestra',
                'responsable_id'=>'responsable',
                'lugar_de_extraccion_id'=>'lugar_extraccion',
                'didymosphenia_geminata'=>'didymosphenia_geminata_pa',
                'da1'=>'da1_pa',
                'da2'=>'da2_pa',
                'da3'=>'da3_pa',
                'da4'=>'da4_pa',
                'da5'=>'da5_pa',
                'ma_archivo'=>'ma_archivo_link',
            );
            $casos=array(
                'fecha'=>array('getFecha','d/m/Y')
            );
            
            $tm= MuestraPeer::getTableMap();
            $cols=$tm->getColumns();

            $this->view = array();
            foreach (MuestraPeer::$grupos as $nombre=>$grupo){
                $r=array();
                foreach ($grupo as $field){
                    if(in_array($field, $estosNo) || substr($field, -4)=='_lim') continue;
                    
                    if( method_exists($this->Muestra , 'get'.sfToolkit::camelize($field).'Lim')){
                        $field.=  '_con_lim';
                    }
                    $m='get'.sfToolkit::camelize( array_key_exists($field, $estosCambiar) ? $estosCambiar[$field] :  $field  );
                    $r[$field]= array_key_exists($field, $casos)? $casos[$field]: array($m);
                }
                $this->view[$nombre] = $r;
                
            }
        
    }
    
    public function executeEdit(sfWebRequest $request) {
        
        $object= $this->getRoute()->getObject();
        
        $gm=array_keys( UsuarioGrupoQuery::create()->findByUsuarioId($object->getCreatedBy())->toArray('GrupoId'));
        $gu=array_keys( UsuarioGrupoQuery::create()->findByUsuarioId( $this->getUser()->getId())->toArray('GrupoId'));

        if( $this->getUser()->hasCredential('muestras_abm') && (($object->getMostrar()==0 &&  count(array_intersect($gm, $gu))>0) || $this->getUser()->hasCredential('muestra_ver_todas')) ){
            return parent::executeEdit($request);
        }
        $this->forward('muestras', 'view');
    }
    
    public function executeAjax(sfWebRequest $request) {
        
//         $this->muestra=MuestraQuery::create()->innerJoinWithTipoMuestra()->findPk($request->getParameter('id'));
        $this->muestra=MuestraQuery::create()->useLugarExtraccionQuery()->leftJoinWithTipoMuestra()->endUse()->findPk($request->getParameter('id'));
        $this->forward404Unless($this->muestra);
        
        sfConfig::set('sf_web_debug', false);
        
        //return $this->renderText($this->muestra->toArray());
        $this->setLayout(false);
        
    }
    
    public function executeNew(sfWebRequest $request)
    {
        parent::executeNew($request);
        $this->form->setDefault('numero',MuestraQuery::create()->proximoNumero());
//         $this->form->setDefault('protocolo',MuestraQuery::create()->proximo());
        $this->form->setDefault('ye',date('Y'));
        $this->form->setDefault('fecha',date('d/m/Y'));
    }
    
    protected function executeBatchCambiar_visible(sfWebRequest $request)
    {
        
        $ids= $request->getParameter('ids',array());
        $this->getRequest()->getParameterHolder()->remove('ids');
        $p=array(
            'cambiar'=>array(
                'ids'=>join(',',$ids)
            )
        );
        $this->getRequest()->getParameterHolder()->add($p);
        $this->forward('muestras','cambiar');
        
    }
    
    
    public function executeCambiar(sfWebRequest $request)
    {
        $p=$request->getParameter('cambiar');
        $estas=array();
        
        
        
        foreach (MuestraQuery::create()->findPks(explode(',', $p['ids'])) as $m) {
            $m->setMostrar(!$m->getMostrar());
            $m->save();
        }
        $this->getUser()->setFlash('notice', 'Se cambiaron correctamente las marcas para mostrar/ocultar las muestras seleccionadas.');
        
        $this->redirect('muestras/index');
        
    }
    
}
