<?php

/**
 * Muestra form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class MuestraForm extends BaseMuestraForm {
	public function configure() {
        
	    $f=array();
	    foreach (MuestraPeer::$grupos as $g) {
	        $f=array_merge($f,$g);
	    }

	    
        if(sfContext::getInstance()->getUser()->esMunicipio()){
            unset($f[array_search('numero', $f)]);
            unset($f[array_search('protocolo', $f)]);
            unset($f[array_search('mostrar', $f)]);
            
        } else {
            unset($f[array_search('codigo', $f)]);
            if(!sfContext::getInstance()->getUser()->hasCredential('muestra_mostrar')){
                unset($f[array_search('mostrar', $f)]);
            }
        }
                
	    $this->useFields($f);
	    
        $this->widgetSchema['dbo5_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)', 1=>'> (mayor al valor indicado)')
        ));
        $this->widgetSchema['dqo_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)', 1=>'> (mayor al valor indicado)')
        ));
	    
        $this->widgetSchema['nmp_coliformes_totales_100_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',
                -1=>'< (menor al valor indicado)',
                 1=>'> (mayor al valor indicado)',
                -2=>'&le; (menor Ó IGUAL al valor indicado)',
                 2=>'&ge; (mayor  Ó IGUAL al valor indicado)'
            )
        ));
        
        $this->widgetSchema['nmp_coliformes_fecales_100_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',
                -1=>'< (menor al valor indicado)',
                 1=>'> (mayor al valor indicado)',
                -2=>'&le; (menor Ó IGUAL al valor indicado)',
                 2=>'&ge; (mayor  Ó IGUAL al valor indicado)'
            )
        ));
        
        $this->widgetSchema['nmp_escherichia_coli_100_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',
                -1=>'< (menor al valor indicado)',
                 1=>'> (mayor al valor indicado)',
                -2=>'&le; (menor Ó IGUAL al valor indicado)',
                 2=>'&ge; (mayor  Ó IGUAL al valor indicado)'
            )
        ));
        
        $this->widgetSchema['nmp_enterococos_fecales_100_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',
                -1=>'< (menor al valor indicado)',
                 1=>'> (mayor al valor indicado)',
                -2=>'&le; (menor Ó IGUAL al valor indicado)',
                 2=>'&ge; (mayor  Ó IGUAL al valor indicado)'
            )
        ));
        
        
        $this->widgetSchema['magnesio_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',
                -1=>'< (menor al valor indicado)',
                 1=>'> (mayor al valor indicado)',
                -2=>'&le; (menor Ó IGUAL al valor indicado)',
                 2=>'&ge; (mayor  Ó IGUAL al valor indicado)'
            )
        ));
        
        $this->widgetSchema['cloruros_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));
        
        $this->widgetSchema['sulfatos_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));
        
        $this->widgetSchema['sodio_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));
        
        $this->widgetSchema['potasio_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));
        
        $this->widgetSchema['sol_sup_tot_103_105_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));
        
        $this->widgetSchema['solidos_sedimentables_10min_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));
        
        $this->widgetSchema['solidos_sedimentables_1h_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));
        
        $this->widgetSchema['solidos_sedimentables_2h_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));
        
        $this->widgetSchema['sol_tot_105_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));
        
        $this->widgetSchema['sol_totales_fijos_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));
        
        $this->widgetSchema['sol_totales_volatiles_mg_l_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));
        
        $this->widgetSchema['fluoruros_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< L.D.')
        ));
        
        $this->widgetSchema['nitritos_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado / N.D.)')
        ));
        
        $this->widgetSchema['nitratos_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'',-1=>'< (menor al valor indicado)')
        ));

        
        $this->widgetSchema['grasas_aceites_lim']=new sfWidgetFormChoice(array(
            'choices'=>array(  ''=>'',-1=>'< (menor al valor indicado)', 1=>'> (mayor al valor indicado)' )
        ));
        
        $this->widgetSchema['fosforo_reactivo_disuelto_lim']=new sfWidgetFormChoice(array(
            'choices'=>array(  ''=>'', -1=>'< (menor al valor indicado)', )
        ));
	
        $this->widgetSchema['detergentes_anionicos_lim']=new sfWidgetFormChoice(array(
            'choices'=>array(  ''=>'', -1=>'< (menor al valor indicado)', )
        ));
	
        $this->widgetSchema['alcalinidad_total_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'', -1=>'< (menor al valor indicado)', 1=>'> (mayor al valor indicado)', )
        ));
	
        $this->widgetSchema['carbonatos_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'', -1=>'< (menor al valor indicado)', 1=>'> (mayor al valor indicado)', )
        ));
	
        $this->widgetSchema['bicarbonatos_lim']=new sfWidgetFormChoice(array(
            'choices'=>array( ''=>'', -1=>'< (menor al valor indicado)', 1=>'> (mayor al valor indicado)', )
        ));
        
        $this->validatorSchema['ye']->setOption('min', 1);
        
		$this->widgetSchema['tipo_id']->setOption('add_empty', true);
		$this->widgetSchema['tipo_id']->setOption('order_by', array('Nombre','asc'));
		
		$this->widgetSchema['responsable_id']->setOption('query_methods', array('orderByNombre'));

		$this->widgetSchema['lugar_de_extraccion_id']->setOption('query_methods', array('orderByLocalidad','orderByNombre'));
		$this->widgetSchema['lugar_de_extraccion_id']->setAttribute('class','form-control s2');

		$locs= sfContext::getInstance()->getUser()->getLocalidades();
		if(count($locs)>0){
		    $this->validatorSchema['lugar_de_extraccion_id']->setOption('required',true);
		    $this->validatorSchema['lugar_de_extraccion_id']->setOption('query_methods',array('filterByLocalidadId'=>array( $locs, Criteria::IN)));
		}
		
		if($this->widgetSchema['numero']){
    		$this->widgetSchema['numero']->setAttribute('autofocus','autofocus');
	       	$this->validatorSchema['numero'] = new sfValidatorNumber();
		}
		$this->widgetSchema['didymosphenia_geminata']= new sfWidgetFormChoice(array(
		    'choices'=>array( null=>'', 'true'=>'Datectada', 'false'=>'No Detectada' )
		));
		$this->validatorSchema['didymosphenia_geminata']= new sfValidatorChoice(array(
		    'choices'=>array( 'true', 'false' ),
		    'required'=>false
		));
		
		$this->widgetSchema['da1']= new sfWidgetFormChoice(array(
		    'choices'=>array( null=>'', 'true'=>'Datectada', 'false'=>'No Detectada' )
		));
		$this->validatorSchema['da1']= new sfValidatorChoice(array(
		    'choices'=>array( 'true', 'false' ),
		    'required'=>false
		));
		
		$this->widgetSchema['da2']= new sfWidgetFormChoice(array(
		    'choices'=>array( null=>'', 'true'=>'Datectada', 'false'=>'No Detectada' )
		));
		$this->validatorSchema['da2']= new sfValidatorChoice(array(
		    'choices'=>array( 'true', 'false' ),
		    'required'=>false
		));
		
		$this->widgetSchema['da3']= new sfWidgetFormChoice(array(
		    'choices'=>array( null=>'', 'true'=>'Datectada', 'false'=>'No Detectada' )
		));
		$this->validatorSchema['da3']= new sfValidatorChoice(array(
		    'choices'=>array( 'true', 'false' ),
		    'required'=>false
		));
		
		$this->widgetSchema['da4']= new sfWidgetFormChoice(array(
		    'choices'=>array( null=>'', 'true'=>'Datectada', 'false'=>'No Detectada' )
		));
		$this->validatorSchema['da4']= new sfValidatorChoice(array(
		    'choices'=>array( 'true', 'false' ),
		    'required'=>false
		));
		
		$this->widgetSchema['da5']= new sfWidgetFormChoice(array(
		    'choices'=>array( null=>'', 'true'=>'Datectada', 'false'=>'No Detectada' )
		));
		$this->validatorSchema['da5']= new sfValidatorChoice(array(
		    'choices'=>array( 'true', 'false' ),
		    'required'=>false
		));
		
		$this->widgetSchema['conductividad_electrica_unidad']= new sfWidgetFormChoice(array(
		    'choices'=>MuestraPeer::$conduc
		));
		$this->validatorSchema['conductividad_electrica_unidad']= new sfValidatorChoice(array(
		    'choices'=>array_keys(MuestraPeer::$conduc),
		    'required'=>false,
		    'empty_value'=>0
		));
		
		
		
		if($this->isNew){
		    $foto=null;
		} else {
		    $nombre_fichero = MuestraPeer::path().'/'.$this->getObject()->getMaArchivo();
		    $foto = fopen($nombre_fichero, "r");
		}
		
		$this->widgetSchema ['ma_archivo'] = new FotoWidget ( array (
		    'foto' => $foto,
		    'filename' => $this->getObject ()->getMaNombreOriginal(),
		    'mime' => $this->getObject ()->getMaMime (),
		    'url' => sfContext::getInstance ()->getController ()->genUrl ( 'muestras/adjunto?id=' . $this->getObject ()->getId () ),
		));
		
		$this->validatorSchema ['ma_archivo'] = new sfValidatorFile (array(
		    'required'=>$this->getOption('requerido',false),
		    'path' => MuestraPeer::path()
		));
		
		
		sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
		foreach ($f as $campo){
		    if(substr($campo, -4)=='_lim') {
		        $this->widgetSchema->setLabel($campo, __(sfInflector::humanize(substr($campo, 0,strlen($campo)-4)), array(), 'messages').' (indicar aprox.)');
		    }
		}
		$this->widgetSchema->setLabels(array(
		   'taxa'=>'Cantidad de taxa',
		    'da1'=>'Diatomeas (Bacillariophyta)',
		    'da2'=>'Algas Verdes (Chlorophyceae)',
		    'da3'=>'Algas Pardo Doradas (Chrysophyta)',
		    'da4'=>'Dinoflagelados (Dinophyta)',
		    'da5'=>'Cianobacterias (Cyanobacteria)',
		    'ma_archivo'=>'Adjuntar informe'
		));
	
	}
	
	protected function updateDefaultsFromObject()
	{
	    parent::updateDefaultsFromObject();

	    if (!($this->isNew() || is_null( $this->getObject()->getDidymospheniaGeminata() ) ) ){
	        $this->setDefault('didymosphenia_geminata',  $this->getObject()->getDidymospheniaGeminata()?'true':'false' );
	    }
	    if (!($this->isNew() || is_null( $this->getObject()->getDa1() ) ) ){
	        $this->setDefault('da1',  $this->getObject()->getDa1()?'true':'false' );
	    }
	    if (!($this->isNew() || is_null( $this->getObject()->getDa2() ) ) ){
	        $this->setDefault('da2',  $this->getObject()->getDa2()?'true':'false' );
	    }
	    if (!($this->isNew() || is_null( $this->getObject()->getDa3() ) ) ){
	        $this->setDefault('da3',  $this->getObject()->getDa3()?'true':'false' );
	    }
	    if (!($this->isNew() || is_null( $this->getObject()->getDa4() ) ) ){
	        $this->setDefault('da4',  $this->getObject()->getDa4()?'true':'false' );
	    }
	    if (!($this->isNew() || is_null( $this->getObject()->getDa5() ) ) ){
	        $this->setDefault('da5',  $this->getObject()->getDa5()?'true':'false' );
	    }
	}
	
	
	public function updateMaArchivoColumn( sfValidatedFile $f=null) {
	    if (is_null ( $f )) {
	        return false;
	    }
	    if(!$this->isNew){
	        unlink(MuestraPeer::path().$this->getObject()->getMaArchivo());
	    }
	    $this->getObject ()->setMaNombreOriginal ( $f->getOriginalName () );
	    $this->getObject ()->setMaMime ( $f->getType () );
	    
	    return $f->save();
	    
	}
	public function getJavaScripts()
	{
	    return array_merge(parent::getJavaScripts(),array('MuestraForm.js'));
	}
	
}
