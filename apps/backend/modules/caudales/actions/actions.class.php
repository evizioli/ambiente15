<?php

require_once dirname(__FILE__).'/../lib/caudalesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/caudalesGeneratorHelper.class.php';

/**
 * caudales actions.
 *
 * @package    ambiente
 * @subpackage caudales
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */


require ProjectConfiguration::guessRootDir().'/plugins/comunPlugin/lib/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Shared;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class caudalesActions extends autoCaudalesActions
{

    public function executeImportar(sfWebRequest $request)
    {

        $this->form = new ImportarForm();
        if($request->isMethod('post')){
            $this->form->bind($request->getParameter($this->form->getName()),$request->getFiles($this->form->getName()));
            if($this->form->isValid()){
                
                $f= $this->form->getValue('archivo');
                
                $reader = new Xls();
                $spreadsheet = $reader->load($f->getTempName());
                
//                 $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $sheetData  = $spreadsheet->getSheet(0);
                
                $c=0;
                
                for($i=6; $i<=$sheetData->getHighestDataRow(); $i++) {

                    $value=$sheetData->getCell('A'.$i)->getValue();
                    if(is_null($value)) continue;
                    
                    $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
                    if(CaudalQuery::create()->filterByFecha($date)->count()>0) continue;
                    
                    $aporte=$sheetData->getCell('B'.$i)->getValue();
                    $nivel=$sheetData->getCell('C'.$i)->getValue();
                    $turbinado=$sheetData->getCell('D'.$i)->getValue();
                    $vertido=$sheetData->getCell('E'.$i)->getValue();

                    if( !( is_null($aporte) || is_null($nivel) || is_null($turbinado) || is_null($vertido) ) ){
                        $m = new Caudal();
                        $m->setFecha($date);
                        $m->setCaudalAporte($aporte);
                        $m->setNivelEmbalse($nivel);
                        $m->setCaudalTurbinado($turbinado);
                        $m->setCaudalVertido($vertido);
                        $m->save();
                        $c++;
                    }
                }
                $this->getUser()->setFlash('notice', 'Importación correcta. '.$c.' registro(s) agregado(s)');
                $this->redirect('@caudal');
                
            }
            $this->getUser()->setFlash('error', 'Debe adjuntar una planilla de cálculo.', false);
            
        }
        
    }

    
    public function executeIndex($request)
    {
        parent::executeIndex($request);

        
        $this->caudal=array();
        $this->caudal_aporte=array();
        $this->nivel_embalse=array();
        
        $caudales = $this->filters->buildCriteria($this->getFilters())->orderByFecha()->find();
        
        foreach($caudales as $ca){
            
            $pp = sprintf('%d,%d,%d',$ca->getFecha('Y'), (int)$ca->getFecha('m')-1, $ca->getFecha('d'));
            $this->nivel_embalse[] ='{ x: new Date('.$pp.'), y: '.$ca->getNivelEmbalse().'}';
            $this->caudal[] ='{ x: new Date('.$pp.'), y: '.(floatval( $ca->getCaudalTurbinado())+floatval( $ca->getCaudalVertido())).'}';
            $this->caudal_aporte[] ='{ x: new Date('.$pp.'), y: '.(floatval( $ca->getCaudalAporte())).'}';
            
        }
        
        $this->nivel_embalse='['.join(',',$this->nivel_embalse).']';
        $this->caudal ='['.join(',',$this->caudal).']';
        $this->caudal_aporte ='['.join(',',$this->caudal_aporte).']';
        
    }
}
