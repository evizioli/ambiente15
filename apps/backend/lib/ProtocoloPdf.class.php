<?php
class ProtocoloPdf extends sfTCPDF
{
    private $muestra;
    
    const PIE=225;
    public function __construct(Muestra $muestra)
    {
        parent::__construct();
        $this->muestra= $muestra;
        
        $this->setCellMargins(1,1,1,1);
//         $this->SetCellPadding(0.2);
        
        $this->SetMargins(20, 60,10);
        $this->SetAutoPageBreak(true, 30);
    }
    
    public function Header()
    {
        
        $this->setCellMargins(2,2,2,2);
       
//         $this->Image(sfProjectConfiguration::guessRootDir().'/web/images/header-protocolo-1.png', $this->lMargin, 15, 0, 0, null, '', '', true, 300, '', false, false, false, false, false, false);
        //$this->Image(sfProjectConfiguration::guessRootDir().'/web/images/header-protocolo-2.png', $this->getPageWidth()/2-$this->rMargin, 15, 0, 0, null, '', '', true, 300, '', false, false, false, false, false, false);
        $this->Image(sfProjectConfiguration::guessRootDir().'/web/images/header-protocolo.png', $this->lMargin, 15,$this->getPageWidth()-($this->lMargin+$this->rMargin), 20, null, '', '', true, 300, '', false, false, false, false, false, false);
        $this->SetFont(PDF_FONT_NAME_MAIN,'BU',12);
        $this->writeHTMLCell($this->getPageWidth()-($this->lMargin+$this->rMargin),0,$this->lMargin ,35, 'PROTOCOLO ANALÍTICO', 0,1,null,null,'C');
        
        //$this->SetY($this->GetY()+5);
        
        $aux=$this->GetY();
        $this->SetFont(PDF_FONT_NAME_MAIN,'B',12);
        $this->Line($this->lMargin, $this->GetY(), $this->getPageWidth()-$this->rMargin, $this->GetY());
        $this->writeHTMLCell(60,0,$this->lMargin ,$this->GetY(), 'PROTOCOLO N°');
        $this->writeHTMLCell($this->getPageWidth()-($this->lMargin+$this->rMargin+60),0,$this->lMargin+60 ,$this->GetY(), $this->muestra->getProtocoloYe(),0,1);
        
        $this->Line($this->lMargin, $this->GetY(), $this->getPageWidth()-$this->rMargin, $this->GetY());
        $this->writeHTMLCell(60,0,$this->lMargin ,$this->GetY(), 'MUESTRA N°');
        $this->writeHTMLCell($this->getPageWidth()-($this->lMargin+$this->rMargin+60),0,$this->lMargin+60 ,$this->GetY(), $this->muestra->getNumero(), 0,1);

        $this->Line($this->lMargin, $this->GetY(), $this->getPageWidth()-$this->rMargin, $this->GetY());
        $this->Line($this->lMargin, $aux, $this->lMargin, $this->GetY());
        $this->Line($this->lMargin+60, $aux, $this->lMargin+60, $this->GetY());
        $this->Line($this->getPageWidth()-($this->rMargin), $aux, $this->getPageWidth()-( $this->rMargin ), $this->GetY());

        $this->SetY($this->GetY()+5);
        
        
        if($this->proto ){
            $this->Line($this->lMargin, $this->GetY(), $this->getPageWidth()-$this->rMargin, $this->GetY());
            
            $this->SetFont(PDF_FONT_NAME_MAIN,'',10);
            foreach( $this->proto as $r){
                if(!( is_null( $r[0]) || empty($r[0]) ) ){
                    $this->fila(array(
                        array('texto'=>$r[1], 'ancho'=>60),
                        array('texto'=>$r[0], 'ancho'=>$this->getPageWidth()-($this->lMargin+$this->rMargin+60)),
                    ));
                }
            }
            $this->Line($this->lMargin, $this->GetY(), $this->getPageWidth()-$this->rMargin, $this->GetY());
            $this->proto=false;
            
            $this->SetY($this->GetY()+5);
            
        }
        
        $this->SetFont(PDF_FONT_NAME_MAIN,'BU',10);
        $this->Line($this->lMargin, $this->GetY(), $this->getPageWidth()-$this->rMargin, $this->GetY());
        
        $this->fila(array(
            array('texto'=>'PARÁMETRO', 'ancho'=>60, 'ali'=>'C'),
            array('texto'=>'RESULTADO', 'ancho'=>30, 'ali'=>'C'),
            array('texto'=>'MÉTODO', 'ancho'=>$this->getPageWidth()-($this->lMargin+$this->rMargin+90), 'ali'=>'C'),
        ));
        $this->Line($this->lMargin, $this->GetY(), $this->getPageWidth()-$this->rMargin, $this->GetY());

        $this->cuerpo=$this->GetY();
        
    
    }
    
    public function Footer()
    {
        $this->Image(sfProjectConfiguration::guessRootDir().'/web/images/firma-protocolo.png', 140, 240, 52.6, 0, 'png', '', '', true, 300, '', false, false, false, false, false, false);
        
        $this->SetFontSize(10);
        $this->writeHTMLCell($this->getPageWidth()-($this->lMargin+$this->rMargin),0,$this->lMargin ,270, '<b>Dirección de Laboratorio Ambiental</b><br>
 Subsecretaría de Gestión Ambiental y Desarrollo Sustentable<br>
Laprida N° 170 (9103) - Rawson<br>
Tel/Fax. (0280) 4482-516 - laboratorioambientechubut@yahoo.com', null,null,null,1,'C');
//         $this->SetFontSize(7);
//         $this->writeHTMLCell($this->getPageWidth()-($this->lMargin+$this->rMargin),0,$this->lMargin ,280, 'Los resultados consignados se refieren exclusivamente a las muestras recibidas y/o sometidas a ensayo. El Laboratorio declina toda responsabilidad por el uso indebido que se hiciere de éste informe.', null,null,null,1,'J');
        
    }
    
    public function fila($v)
    {

        $aux=0;
        foreach ($v as $celda){
            $aux=max($this->getStringHeight($celda['ancho'], $celda['texto']), $aux);
        }
        if($aux+$this->GetY()>self::PIE){
            $this->AddPage();
            $y=$this->cuerpo;
        } else {
            $y = $this->GetY();
        }
        $b=array($this->GetX());
        $yd=0;
        
        
        foreach ($v as $celda){
            if(!isset($celda['ali'])) $celda['ali']='L';
            $this->writeHTMLCell($celda['ancho'],7,end($b),$y, $celda['texto'],0, 1,null, true,$celda['ali']);
            $yd=max($this->GetY(),$yd);
            $b[]=end($b)+$celda['ancho'];
        }
//         $this->Line($b[0], $y, end($b), $y);
        foreach ($b as $x){
            $this->Line($x, $y, $x, $yd);
        }
        $this->line($b[0], $yd, end($b), $yd);
//         $this->Line(array_sum($b), $y, array_sum($b), $yd);
            
    }
    
}