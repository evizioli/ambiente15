<?php

/**
 * consultas actions.
 *
 * @package    ambiente
 * @subpackage consultas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class consultasActions extends sfActions
{
    
    public function executeAlgas(sfWebRequest $request)
    {
//         $this->filters = new ConsultaGraficoTiempoFormFilter();

        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Tag','Url'));

        $this->filters = new ConsultaAlgasFormFilter();
        unset($this->filters['uso']);
        if ($request->isMethod ( 'post' )) {
            if($request->hasParameter('limpiar')){
                $this->getUser ()->setAttribute ( 'algas', array ( 'lugar_de_extraccion_id'=>null), 'consultas' );
                $this->redirect ( 'consultas/algas' );
                
            }
            
            $this->filters->bind ( $request->getParameter ( $this->filters->getName() ) );
            if ($this->filters->isValid ()) {
                $this->getUser ()->setAttribute ( 'algas', $this->filters->getValues (), 'consultas' );
                $this->redirect ( 'consultas/algas' );
            }
        }
        
        $this->hay= LugarExtraccionQuery::create()->soloConAlgas()->count()>0;
        
        $f = $this->getUser ()->getAttribute ( 'algas', array ( 'lugar_de_extraccion_id'=>null), 'consultas' );
        $this->filters->setDefaults ( $f );
        $this->lugar = LugarExtraccionQuery::create()->findPk($f['lugar_de_extraccion_id'] );

        $this->resp=array();
        $this->chart=array();
        if( $this->lugar  ){
            
            $muestras= $this->filters->buildCriteria($f)->filterByTaxa(0, Criteria::GREATER_THAN)->orderByFecha()->find();
            
            $row=array(
                'var'=>'Fecha',
                'values'=>array()
            );
            foreach ($muestras as $m){
                $row['values'][]=array(
                    'rojo'=>false,
                    'valor'=>$m->getFecha('d/m/Y')
                );
            }
            $this->resp[]=$row;
            
            $row=array(
                'var'=>'Cantidad de taxa',
                'values'=>array()
            );
            foreach ($muestras as $m){
                $row['values'][]=array(
                    'rojo'=>false,
                    'valor'=>$m->getTaxa()
                );
                $pp = sprintf('%d,%d,%d',$m->getFecha('Y'), (int)$m->getFecha('m')-1, $m->getFecha('d'));
                $this->chart[] ='{ x: new Date('.$pp.'), y: '.$m->getTaxa().'}';
            }
            $this->resp[]=$row;
            
            $row=array(
                'var'=>'División algal',
                'values'=>array()
            );
            $this->resultado=array();
            foreach ($muestras as $m){
                $a=array();
                for($i=1; $i<=5; $i++){
                    $met='getDa'.$i;
                    if($m->$met()) $a[]=$this->getContext()->getI18N()->__(sfInflector::humanize( 'da'.$i ), array(),'messages');
                }
                $row['values'][]=array(
                    'rojo'=>false,
                    'valor'=>join(', ',$a)
                );
                $this->resultado[$m->getFecha()]='{
        			type: "column",
        			name: "taxa",
        			showInLegend: true,
        			dataPoints: [' . $m->getTaxa() . ']
        		}';
            }
            $this->resp[]=$row;
            
            $row=array(
                'var'=>'Informe',
                'values'=>array()
            );
            foreach ($muestras as $m){
                $row['values'][]=array(
                    'rojo'=>false,
                    'valor'=>$m->getMaArchivo()?link_to($m->getMaNombreoriginal(),'muestras/adjunto?id='.$m->getId()) : ''
                );
            }
            $this->resp[]=$row;
        }
        $this->chart='['.join(',',$this->chart).']';
        
    }
    
    public function executeCaudales(sfWebRequest $request)
    {
        $this->filters = new CaudalFormFilter ();
        if ($request->isMethod ( 'post' )) {
            if($request->hasParameter('limpiar')){
                $this->getUser ()->setAttribute ( 'caudales', array ( ), 'consultas' );
                $this->redirect ( 'consultas/caudales' );
                
            }
            
            $this->filters->bind ( $request->getParameter ( $this->filters->getName() ) );
            if ($this->filters->isValid ()) {
                $this->getUser ()->setAttribute ( 'caudales', $this->filters->getValues (), 'consultas' );
                $this->redirect ( 'consultas/caudales' );
            }
        }
        
        $f = $this->getUser ()->getAttribute ( 'caudales', array ( ), 'consultas' );
        $this->filters->setDefaults ( $f );
            
            
        $this->caudales = $this->filters->buildCriteria($f)->orderByFecha()->find();
        $this->caudal_aporte=array();
        $this->nivel_embalse=array();
//         $this->caudal_turbinado=array();
//         $this->caudal_vertido=array();
        $this->caudal=array();
        
        foreach($this->caudales as $ca){
            $pp = sprintf('%d,%d,%d',$ca->getFecha('Y'), (int)$ca->getFecha('m')-1, $ca->getFecha('d'));
            if($ca->getCaudalAporte()) $this->caudal_aporte[] ='{ x: new Date('.$pp.'), y: '.$ca->getCaudalAporte().'}';
            if($ca->getNivelEmbalse()) $this->nivel_embalse[] ='{ x: new Date('.$pp.'), y: '.$ca->getNivelEmbalse().'}';
//             if($ca->getCaudalTurbinado()) $this->caudal_turbinado[] ='{ x: new Date('.$pp.'), y: '.$ca->getCaudalTurbinado().'}';
//             if($ca->getCaudalVertido()) $this->caudal_vertido[] ='{ x: new Date('.$pp.'), y: '.$ca->getCaudalVertido().'}';
            if($ca->getCaudalVertido()+$ca->getCaudalTurbinado()) $this->caudal[] ='{ x: new Date('.$pp.'), y: '.($ca->getCaudalVertido()+$ca->getCaudalTurbinado()).'}';

        }
            
        $this->caudal_aporte='['.join(',',$this->caudal_aporte).']';
        $this->nivel_embalse='['.join(',',$this->nivel_embalse).']';
//         $this->caudal_turbinado='['.join(',',$this->caudal_turbinado).']';
//         $this->caudal_vertido='['.join(',',$this->caudal_vertido).']';
        $this->caudal='['.join(',',$this->caudal).']';
        
        
    }
    
    
    public function executeTutorial(sfWebRequest $request)
    {
        if($this->getUser()->hasCredential('muestras') ){
            if($this->getUser()->esMunicipio()){
                $f =  ProjectConfiguration::caminoTutorialMuni();
            } else {
                $f =  ProjectConfiguration::caminoTutorialAcceso();
            }
        } else {
            $f= ProjectConfiguration::caminoTutorialConsulta(); 
        }
        $this->getResponse()->setHttpHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0' );
        $this->getResponse()->setHttpHeader('Pragma', 'public' );
        $this->getResponse()->setHttpHeader('Expires', '0' );
        $this->getResponse()->setContentType('application/pdf; charset=utf-8');
        return $this->renderText( file_get_contents($f) );
        
    }
    
    
    public function executeIndex(sfWebRequest $request)
    {
        
    }
    
    public function executeGraficosTiempo(sfWebRequest $request)
    {
        
        $this->filters = new ConsultaGraficoTiempoFormFilter ();
        if ($request->isMethod ( 'post' )) {
            if($request->hasParameter('limpiar')){
                $this->getUser ()->setAttribute ( 'graficosTiempo', array ( ), 'consultas' );
                $this->redirect ( 'consultas/graficosTiempo' );
                
            }
            
            $this->filters->bind ( $request->getParameter ( $this->filters->getName() ) );
            if ($this->filters->isValid ()) {
                $this->getUser ()->setAttribute ( 'graficosTiempo', $this->filters->getValues (), 'consultas' );
                $this->redirect ( 'consultas/graficosTiempo' );
            }
        }
        
        $f = $this->getUser ()->getAttribute ( 'graficosTiempo', array ( 'lugar_de_extraccion_id'=>null), 'consultas' );
        $this->filters->setDefaults ( $f );
        $this->uso=isset($f['uso'])?$f['uso']:0;
        $this->lugar = LugarExtraccionQuery::create()->findPk($f['lugar_de_extraccion_id'] );
        if( $this->lugar  ){
            
            $this->tabla=array();
            $tmp= array();
            $tmp2= array();
            foreach (ToleranciaPeer::$campos_bactereologicos as $x=>$c) {
                $tmp[$x]= array();
                $tmp2[$x]= array();
            }
            
            $aux = $this->crudo($this->filters->buildCriteria ( $f ));
            $df = new sfDateFormat(sfContext::getInstance()->getUser()->getCulture());
            
            //throw new Exception();
            
            while( $d=$aux->fetch(PDO::FETCH_ASSOC )) {
                
                
                $t= ToleranciaPeer::$tipos[$x];
                
                $this->tabla[]=$d;
                foreach (ToleranciaPeer::$campos_bactereologicos as $x=>$c) {

                    $pp = sprintf('%d,%d,%d',$df->format($d['f'],'yyyy'), (int)$df->format($d['f'],'MM')-1, $df->format($d['f'],'dd'));
                    $tmp[$x][]=sprintf('{ x: new Date( %s), y: %f }',
                        $pp,
                        $d[$c]
                    );
                    if(round($d[$c.'_maximo'],0)>0){
                        
                        $tmp2[$x][]=sprintf('{ x: new Date( %s), y: %f, toolTipContent: "%s: %s"  }',
                            $pp,
                            $d[$c.'_maximo'],
                            $t.' nivel guía',
                            round($d[$c.'_maximo'],0)
                        );
                    }
                    
                }
                
            }
            
            $this->resultado=array();
            foreach ($tmp as $x=>$valores){
                    
                $t= ToleranciaPeer::$tipos[$x];
                
                $this->resultado[]='{
        			type: "column",
        			name: "'.$t.'",
                    color: "'.$this->color[$x].'",
        			showInLegend: true,
        			yValueFormatString: "0#",
        			dataPoints: [' . join ( ",", $valores) . ']
        		}'.($this->uso>0 ? ',{
        			type: "line",
        			name: "'.$t.' nivel guía",
                    color: "'.$this->color[$x].'",
        			showInLegend: true,
                    lineThickness: 5,
                    markerType: "none",
        			yValueFormatString: "0#",
        			dataPoints: [' . join ( ",", $tmp2[$x]) . ']
        		}' : '');
            }

            
        }
        
    }
    
    protected $color = array(
        1=>'red',
        2=>'green',
        3=>'blue',
        4=>'yellow',
    );
    
    protected function crudo(ModelCriteria $criteria)
    {
        if(!$this->getUser()->hasCredential('muestra_ver_todas')) $criteria->filterByMostrar(true);
        $params = array();
        
        $locs= sfContext::getInstance()->getUser()->getLocalidades();
        if(count($locs)>0){
            $criteria->useLugarExtraccionQuery()->filterByLocalidadId($locs,Criteria::IN)->endUse();
        }
        $tipos= sfContext::getInstance()->getUser()->getTipos();
        if(count($tipos)>0){
            $criteria->filterByTipoId($tipos,Criteria::IN);
        }
        
        $dbMap = Propel::getDatabaseMap($criteria->getDbName());
        $db = Propel::getDB($criteria->getDbName());
        $whereClause = array();
        foreach ($criteria->keys() as $key) {
            
            $criterion = $criteria->getCriterion($key);
            $table = null;
            foreach ($criterion->getAttachedCriterion() as $attachedCriterion) {
                $tableName = $attachedCriterion->getTable();
                $table = $criteria->getTableForAlias($tableName);
//                 $fromClause[] = $table . ' ' . $tableName;
                if (($criteria->isIgnoreCase() || $attachedCriterion->isIgnoreCase())  && $dbMap->getTable($table)->getColumn($attachedCriterion->getColumn())->isText()) {
                    $attachedCriterion->setIgnoreCase(true);
                }
            }
            
            $criterion->setDB($db);
            
            $sb = '';
            $criterion->appendPsTo($sb, $params);
            $whereClause[] = $sb;
        }
        
        $u= $this->uso>0 ? $this->uso : 0;
         
            
        $sql = '
                         
        select muestra.fecha f, lugar_extraccion.id lid, lugar_extraccion.nombre l,
        	muestra.nmp_coliformes_totales_100, sc_coliformes_totales.maximo nmp_coliformes_totales_100_maximo,
        	muestra.nmp_coliformes_fecales_100, sc_coliformes_fecales.maximo nmp_coliformes_fecales_100_maximo,
        	muestra.nmp_escherichia_coli_100, sc_coli.maximo nmp_escherichia_coli_100_maximo,
        	muestra.nmp_enterococos_fecales_100, sc_enterococos.maximo nmp_enterococos_fecales_100_maximo
                    
        from muestra
        	inner join lugar_extraccion on muestra.lugar_de_extraccion_id= lugar_extraccion.id
                    
                    
        	left join(
        		SELECT muestra.id, sc.maximo
        		FROM muestra
        		     inner JOIN ( SELECT * from tolerancia_desde_hasta(1,'.$u.') )  sc ON  muestra.fecha >= sc.desde AND muestra.fecha <= sc.hasta
        		         
        		  WHERE muestra.nmp_coliformes_totales_100 IS NOT NULL
        		         
        	) sc_coliformes_totales on sc_coliformes_totales.id = muestra.id
        		         
        	left join(
        		SELECT muestra.id, sc.maximo
        		FROM muestra
        		     inner JOIN ( SELECT * from tolerancia_desde_hasta(2,'.$u.')  )  sc ON  muestra.fecha >= sc.desde AND muestra.fecha <= sc.hasta
        		         
        		  WHERE muestra.nmp_coliformes_fecales_100 IS NOT NULL
        		         
        	) sc_coliformes_fecales on sc_coliformes_fecales.id = muestra.id
        		         
        	left join(
        		SELECT muestra.id, sc.maximo
        		FROM muestra
        		     inner JOIN ( SELECT * from tolerancia_desde_hasta(3,'.$u.')  )  sc ON  muestra.fecha >= sc.desde AND muestra.fecha <= sc.hasta
        		WHERE muestra.nmp_escherichia_coli_100 IS NOT NULL
        		         
        	) sc_coli on sc_coli.id = muestra.id
        		         
        	left join(
        		SELECT muestra.id, sc.maximo
        		FROM muestra
        		     inner JOIN ( SELECT * from tolerancia_desde_hasta(4,'.$u.')  )  sc ON  muestra.fecha >= sc.desde AND muestra.fecha <= sc.hasta
        		         
        		WHERE muestra.nmp_enterococos_fecales_100 IS NOT NULL
        		         
        	) sc_enterococos on sc_enterococos.id = muestra.id
        		         
        		         
            WHERE  (muestra.nmp_coliformes_totales_100 IS NOT NULL or muestra.nmp_coliformes_fecales_100 IS NOT NULL or muestra.nmp_enterococos_fecales_100 IS NOT NULL or muestra.nmp_escherichia_coli_100 IS NOT NULL) and '.join(' and ',$whereClause ) 
            
            .' order by fecha desc,lugar_extraccion.nombre';
            
            
                
        $crudo  = Propel::getConnection()->prepare($sql);
        $db->bindValues( $crudo, $params, $dbMap);
        $crudo->execute();
        return $crudo;
    }
    
    public function executeGraficos(sfWebRequest $request)
    {
      
        $this->filters = new ConsultaGraficoFormFilter ();
        if ($request->isMethod ( 'post' )) {
            if($request->hasParameter('limpiar')){
                $this->getUser ()->setAttribute ( 'graficos', array ('localidad'=>null), 'consultas' );
                $this->redirect ( 'consultas/graficos' );
                
            }
            $this->filters->bind ( $request->getParameter ( $this->filters->getName() ) );
            if ($this->filters->isValid ()) {
                $this->getUser ()->setAttribute ( 'graficos', $this->filters->getValues (), 'consultas' );
                $this->redirect ( 'consultas/graficos' );
            }
        }
        
        $f = $this->getUser ()->getAttribute ( 'graficos', array ( 'localidad'=>null), 'consultas' );
        $this->filters->setDefaults ( $f );
        
        $this->localidad=LocalidadQuery::create()->findPk($f['localidad']);
        $this->uso=isset($f['uso'])?$f['uso']:0;
        if($this->localidad  ){
        
            

            $tmp=array();
            $tmp2=array();
            $this->lugares=array();
            
            $this->maximo=array();
            
            $this->tabla=array();
            
            $aux = $this->crudo($this->filters->buildCriteria ( $f ));
            
            while( $d=$aux->fetch(PDO::FETCH_ASSOC )) {
                
                
                $this->tabla[]=$d;
                if(!isset($this->lugares[$d['lid']])) $this->lugares[$d['lid']]=$d['l'];
                
                if(!isset($tmp[$d['f']])) {
                    $tmp[$d['f']]=array();
                    $tmp2[$d['f']]=array();
                }
                if(!isset($tmp[$d['f']][$d['lid']])) {
                    $tmp[$d['f']][$d['lid']]=array();
                    $tmp2[$d['f']][$d['lid']]=array();
                }
                foreach (ToleranciaPeer::$campos_bactereologicos as $x=>$c) {
                    $t=ToleranciaPeer::$tipos[$x];
                    
                    $tmp[$d['f']][$x][$d['lid']]=sprintf('{ label: "%s", y: %f, toolTipContent: "%s: %s" }',
                                                    str_ireplace('"','´´',$d['l']),
                                                    $d[$c],
                                                    $t,
                                                    round($d[$c],0)
                                                );
                    
                    $tmp2[$d['f']][$x][$d['lid']]=sprintf('{ label: "%s", y: %f, toolTipContent: "%s: %s"  }',
                                                    str_ireplace('"','´´',$d['l']),
                                                    $d[$c.'_maximo'],
                                                    $t.' nivel guía',
                                                    round($d[$c.'_maximo'],0)
                                                );

                    if( !isset($this->maximo[$d['f']])) $this->maximo[$d['f']]=0;
                    $this->maximo[$d['f']]= max($this->maximo[$d['f']],($this->uso>0 ? $d[$c.'_maximo'] : $d[$c] )*1.1);
                    
                }
            }

            $this->resultado=array();
            foreach ($tmp as $fecha=>$valores){
                foreach (ToleranciaPeer::$campos_bactereologicos as $x=>$c) {
                        
                    $t= ToleranciaPeer::$tipos[$x];
                    
                    $this->resultado[$fecha][$x] ='{
            			type: "column",
            			name: "'.$t.'",
                        color: "'.$this->color[$x].'", 
            			showInLegend: true,
            			yValueFormatString: "0#",
            			dataPoints: [' . join ( ",", $valores[$x]) . ']
            		}'.($this->uso>0 ? ',{
            			type: "line",
            			name: "'.$t.' nivel guía",
                        color: "'.$this->color[$x].'", 
            			showInLegend: true,
                        markerType: "none",
            			yValueFormatString: "0#",
            			dataPoints: [' . join ( ",", $tmp2[$fecha][$x]) . ']
            		}' : '');
                }
            }
            
        }
    }

	protected $geoserver ='http://localhost:8080/geoserver/ambiente/';

	
// 	public function executeImportarDos()
// 	{
	    
// 	    $re= <<<EOD
// /(N|W|O|S|E)\s+(\d+)\s?°\s?(\d+)\s?('{1}|’{1}|´{1})\s?(\d+\.?\,?\d*?)("|'{2}|’{2}|´{2})/miu
// EOD;
	    
// 	    $mapa = array (
// 	        'numero' => 1, 
// 	        'protocolo' => 2, 
// // 	        'tipo' => 3, 
// // 	        'lugar_de_extraccion_id' => 5, 
// 	        'fecha' => 7, 
// 	        'nmp_coliformes_totales_100' => 8, 
// 	        'nmp_coliformes_totales_100_lim' => 9, 
// 	        'nmp_coliformes_fecales_100' => 10, 
// 	        'nmp_coliformes_fecales_100_lim' => 11, 
// 	        'nmp_escherichia_coli_100' => 12, 
// 	        'nmp_escherichia_coli_100_lim' => 13, 
// 	        'nmp_enterococos_fecales_100' => 14, 
// 	        'nmp_enterococos_fecales_100_lim' => 15, 
// 	        'temperatura' => 16, 
// 	        'ph' => 17, 
// 	        'conductividad_electrica' => 18, 
// 	        'turbiedad_unt' => 19, 
// 	        'od_mg_l' => 20, 
// 	        'od_porcentaje' => 21, 
// 	        'dqo_mg_l' => 22, 
// 	        'dbo5_mg_l' => 23, 
// 	        'dureza_ca_co3_mg_l' => 24, 
// 	        'cloruros_mg_l' => 25, 
// 	        'cloruros_mg_l_lim' => 26, 
// 	        'sulfatos_mg_l' => 27, 
// 	        'sulfatos_mg_l_lim' => 28, 
// 	        'calcio_mg_l' => 29, 
// 	        'magnesio_mg_l' => 30, 
// 	        'sodio_mg_l' => 31, 
// 	        'sodio_mg_l_lim' => 32, 
// 	        'potasio_mg_l' => 33, 
// 	        'potasio_mg_l_lim' => 34, 
// 	        'ras' => 35, 
// 	        'sol_sup_tot_103_105_mg_l' => 36, 
// 	        'sol_sup_tot_103_105_mg_l_lim' => 37, 
// 	        'solidos_sedimentables_10min_mg_l' => 38, 
// 	        'solidos_sedimentables_10min_mg_l_lim' => 39, 
// 	        'solidos_sedimentables_1h_mg_l' => 40, 
// 	        'solidos_sedimentables_1h_mg_l_lim' => 41, 
// 	        'solidos_sedimentables_2h_mg_l' => 42, 
// 	        'solidos_sedimentables_2h_mg_l_lim' => 43, 
// 	        'sol_tot_105_mg_l' => 44, 
// 	        'sol_totales_fijos_mg_l' => 45, 
// 	        'sol_totales_volatiles_mg_l' => 46, 
// 	        'sol_dis_tot' => 47, 
// 	        'sol_dis_fijos' => 48, 
// 	        'sol_dis_volat' => 49, 
// 	        'fluoruros' => 50, 
// // 	        'fluoruros_lim' => ??, 
// 	        'nitritos' => 51, 
// 	        'nitritos_lim' => 52, 
// 	        'nitratos' => 53, 
// 	        'nitratos_lim' => 54, 
// 	        'fosfatos' => 55, 
// 	        'observaciones' => 56, 
// // 	        'didymosphenia_geminata' => ??, 
// 	    );

// 	    if (($gestor = fopen(ProjectConfiguration::guessRootDir()."/data/fixtures/Muestras para enrique para cargar 2019.csv", "r")) !== FALSE) {
// 	        fgetcsv($gestor, 1000, ","); //me salto los nombres de columna
// 	        while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
// 	            print_r($datos);
// 	            echo '<hr>';
// 	            preg_match_all($re,  $datos[5], $esto);
// 	            if(count($esto[0])==2){
//     	            foreach (array_keys($esto[0]) as $i){
//     	                $v= (int)$esto[2][$i] +(int)$esto[3][$i]/60 +floatval($esto[5][$i])/3600;
//     	                switch(strtoupper($esto[1][$i]) ){
//     	                    case 'S':
//     	                        $lat=$v*-1;
//     	                        break;
//     	                    case 'N':
//     	                        $lat=$v;
//     	                        break;
//     	                    case 'O':
//     	                    case 'W':
//     	                        $lon= $v*-1;
//     	                        break;
//     	                    case 'E':
//     	                        $lon= $v;
//     	                        break;
//     	                }
//     	            }
//     	            $statement = Propel::getConnection()->prepare( "select ST_Transform( st_geomfromtext('GEOMETRYCOLLECTION(POINT( $lon $lat ))',4326),'EPSG:4326','EPSG:3857' ) AS latlon" );
//     	            $statement->execute ();
//     	            $resultset = $statement->fetch ( PDO::FETCH_OBJ );
//     	            $the_geom= $resultset->latlon;
// 	            } else {
//     	            $the_geom=  null;
// 	            }
// 	            $nombre= trim(preg_replace('/'.$datos[3].'\s*-*\s*(.*)/i', '$1', $datos[4]));
// 	            if(!$localidad = LocalidadQuery::create()->findOneByNombre(trim($datos[3])) ){
// 	                $localidad = new Localidad();
// 	                $localidad->setNombre($datos[3]);
// 	                $localidad->save();
// 	            }
// 	            if(!$lugar = LugarExtraccionQuery::create()->filterByNombre($nombre)->filterByLocalidadId($localidad->getId())->findOne() ){
// 	                $lugar = new LugarExtraccion();
// 	                $lugar->setLocalidad($localidad);
// 	                $lugar->setNombre($nombre);
// 	                $lugar->setTheGeom($the_geom);
// 	                $lugar->save();
// 	            }
// 	            $m = new Muestra();
// 	            $m->setLugarDeExtraccionId($lugar->getId());
// 	            foreach ($mapa as $campo=>$columna){
// 	                if(!empty($datos[$columna-1])) {
// 	                    $met='set'.sfInflector::camelize($campo);
// 	                    $m->$met($datos[$columna-1]);
// 	                } 
// 	            }
	            
// 	            $m->save();
	            
// 	        }
// 	        fclose($gestor);
// 	    }
// 	    die('listo');
// 	}
	
// 	public function executeImportar() {
	    
// 	    $re= <<<EOD
// /(N|W|O|S|E)\s+(\d+)\s?°\s?(\d+)\s?('{1}|’{1}|´{1})\s?(\d+\.?\,?\d*?)("|'{2}|’{2}|´{2})/miu
// EOD;
	    
	    

// 	    if (($gestor = fopen("/home/enrique/Descargas/Muestras para enrique para cargar.csv", "r")) !== FALSE) {
// 	        fgetcsv($gestor, 1000, ","); //me salto los nombres de columna
// 	        while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
// 	            print_r($datos);
// 	            echo '<hr>';
// // 	            preg_match_all($re,  $datos[5], $esto);
	            
	            
// // 	            if(count($esto[0])==2){

	                
// //     	            foreach (array_keys($esto[0]) as $i){
// //     	                $v= (int)$esto[2][$i] +(int)$esto[3][$i]/60 +floatval($esto[5][$i])/3600;
// //     	                switch(strtoupper($esto[1][$i]) ){
// //     	                    case 'S':
// //     	                        $lat=$v*-1;
// //     	                        break;
// //     	                    case 'N':
// //     	                        $lat=$v;
// //     	                        break;
// //     	                    case 'O':
// //     	                    case 'W':
// //     	                        $lon= $v*-1;
// //     	                        break;
// //     	                    case 'E':
// //     	                        $lon= $v;
// //     	                        break;
// //     	                }
// //     	            }
// //     	            $statement = Propel::getConnection()->prepare( "select ST_Transform( st_geomfromtext('GEOMETRYCOLLECTION(POINT( $lon $lat ))',4326),'EPSG:4326','EPSG:3857' ) AS latlon" );
// //     	            $statement->execute ();
// //     	            $resultset = $statement->fetch ( PDO::FETCH_OBJ );
// //     	            $the_geom= $resultset->latlon;
// // 	            } else {
// //     	            $the_geom=  null;
// // 	            }
// // 	            $nombre= trim(preg_replace('/'.$datos[3].'(\s*)-(\s*)(.*)/i', '$3', $datos[4]));
// // 	            if(!$localidad = LocalidadQuery::create()->findOneByNombre(trim($datos[3])) ){
// // 	                $localidad = new Localidad();
// // 	                $localidad->setNombre($datos[3]);
// // 	                $localidad->save();
// // 	            }
// // 	            if(!$lugar = LugarExtraccionQuery::create()->filterByNombre($nombre)->filterByLocalidadId($localidad->getId())->findOne() ){
// // 	                $lugar = new LugarExtraccion();
// // 	                $lugar->setLocalidad($localidad);
// // 	                $lugar->setNombre($nombre);
// // 	                $lugar->setTheGeom($the_geom);
// // 	                $lugar->save();
// // 	            }

// 	            $m = new Muestra();
// 	            $m->setNumero((int)$datos[0]);
// 	            $m->setProtocolo((int)$datos[1]);
// die('buscar en la tabla');
// 	            $k=array_search(strtolower($datos[2]), array_map('strtolower', MuestraPeer::$tipos));
// 	            $m->setTipo($k);
	            
// // 	            $m->setTheGeom( $the_geom);
	             
// 	            preg_match('/(\d{2})\/(\d{2})\/(\d{4})/',$datos[6],$esto);
// 	            $m->setFecha($esto[3].'-'.$esto[2].'-'.$esto[1]);
	            
//                 $match=array();
//                 if(preg_match_all('/(\D*)(\d+.?\d*)/', $datos[7],$match) ){
//                     if(trim($match[1][0])=='<' || trim($match[1][0])=='˂'){
//     	                $m->setNmpColiformesTotales100Lim(-1);
//                     } elseif(trim($match[1][0])=='>'){
//     	                $m->setNmpColiformesTotales100Lim(1);
//     	            }
//     	            $m->setNmpColiformesTotales100( (float)$match[2][0]);
//                 }
	            
//                 $match=array();
//                 if(preg_match_all('/(\D*)(\d+.?\d*)/', $datos[8],$match) ){
//                     if(trim($match[1][0])=='<' || trim($match[1][0])=='˂'){
//     	                $m->setNmpColiformesFecales100Lim(-1);
//                     } elseif(trim($match[1][0])=='>'){
//     	                $m->setNmpColiformesFecales100Lim(1);
//     	            }
//     	            $m->setNmpColiformesFecales100((float)$match[2][0]);
//                 }
	            
//                 $match=array();
//                 if(preg_match_all('/(\D*)(\d+.?\d*)/', $datos[9],$match) ){
                    
//                     if(trim($match[1][0])=='<' || trim($match[1][0])=='˂'){
//     	                $m->setNmpEscherichiaColi100Lim(-1);
//                     } elseif(trim($match[1][0])=='>'){
//                         $m->setNmpEscherichiaColi100Lim(1);
//     	            }
//     	            $m->setNmpEscherichiaColi100((float)$match[2][0]);
//                 }
	            
//                 $match=array();
//                 if(preg_match_all('/(\D*)(\d+.?\d*)/', $datos[10],$match) ){
//                     if(trim($match[1][0])=='<' || trim($match[1][0])=='˂'){
//                         $m->setNmpEnterococosFecales100Lim(-1);
//                     } elseif(trim($match[1][0])=='>'){
//                         $m->setNmpEnterococosFecales100Lim(1);
//     	            }
//     	            $m->setNmpEnterococosFecales100((float)$match[2][0]);
//                 }
	            
	            
//                 if(is_numeric($datos[11])) $m->setTemperatura((float)$datos[11]);
//                 if(is_numeric($datos[12])) $m->setPh((float)$datos[12]);
//                 if(is_numeric($datos[13])) $m->setConductividadElectrica((int)$datos[13]);
//                 if(is_numeric($datos[14])) $m->setTurbiedadUnt((float)$datos[14]);
	            
//                 if(is_numeric($datos[15])) $m->setOdMgL((float)$datos[15]);
//                 if(is_numeric($datos[16])) $m->setOdPorcentaje((int)$datos[16]);
	            
// 	            $m->setDidymospheniaGeminata(!empty($datos[17])?true:null);
	            
// 	            if(is_numeric($datos[18])) $m->setDbo5MgL((int)$datos[18]);
// 	            if(is_numeric($datos[19])) $m->setDqoMgL((float)$datos[19]);
	            
// 	            if(is_numeric($datos[20])) $m->setDurezaCaCo3MgL((int)$datos[20]);
// 	            if(is_numeric($datos[21])) $m->setClorurosMgL((float)$datos[21]);
// 	            if(is_numeric($datos[22])) $m->setSulfatosMgL((float)$datos[22]);
// 	            if(is_numeric($datos[23])) $m->setCalcioMgL((float)$datos[23]);
// 	            if(is_numeric($datos[24])) $m->setMagnesioMgL((float)$datos[24]);
// 	            if(is_numeric($datos[25])) $m->setSodioMgL((float)$datos[25]);
// 	            if(is_numeric($datos[26])) $m->setPotasioMgL((float)$datos[26]);
// 	            if(is_numeric($datos[27])) $m->setRas((float)$datos[27]);
	            
// 	            $match=array();
// 	            if(preg_match_all('/(\D*)(\d+.?\d*)/', $datos[28],$match) ){
// 	                if(trim($match[1][0])=='<' || trim($match[1][0])=='˂'){
// 	                    $m->setNmpEnterococosFecales100Lim(-1);
// 	                } elseif(trim($match[1][0])=='>'){
// 	                    $m->setNmpEnterococosFecales100Lim(1);
// 	                }
// 	                $m->setSolSupTot103105MgL((int)$match[2][0]);
// 	            } 
	            
// 	            if(preg_match_all('/(\D*)(\d+.?\d*)/', $datos[29],$match) ){
// 	                if(trim($match[1][0])=='<' || trim($match[1][0])=='˂'){
// 	                    $m->setSolidosSedimentables10minMgLLim(-1);
// 	                } elseif(trim($match[1][0])=='>'){
// 	                    $m->setSolidosSedimentables10minMgLLim(1);
// 	                }
// 	                $m->setSolidosSedimentables10minMgL((float)$match[2][0]);
// 	            }
	            
// 	            if(preg_match_all('/(\D*)(\d+.?\d*)/', $datos[30],$match) ){
// 	                if(trim($match[1][0])=='<' || trim($match[1][0])=='˂'){
// 	                    $m->setSolidosSedimentables1hMgLLim(-1);
// 	                } elseif(trim($match[1][0])=='>'){
// 	                    $m->setSolidosSedimentables1hMgLLim(1);
// 	                }
// 	                $m->setSolidosSedimentables1hMgL((float)$match[2][0]);
// 	            }
	            
// 	            if(preg_match_all('/(\D*)(\d+.?\d*)/', $datos[31],$match) ){
// 	                if(trim($match[1][0])=='<' || trim($match[1][0])=='˂'){
// 	                    $m->setSolidosSedimentables2hMgLLim(-1);
// 	                } elseif(trim($match[1][0])=='>'){
// 	                    $m->setSolidosSedimentables2hMgLLim(1);
// 	                }
// 	                $m->setSolidosSedimentables2hMgL((float)$match[2][0]);
// 	            }
	            
// 	            if(is_numeric($datos[32])) $m->setSolTot105MgL((int)$datos[32]);
// 	            if(is_numeric($datos[33])) $m->setSolTotalesFijosMgL((int)$datos[33]);
// 	            if(is_numeric($datos[34])) $m->setSolTotalesVolatilesMgL((int)$datos[34]);
	            
// // 	            $m->setLugarExtraccion($lugar);
// 	            $m->setLugarExtraccion($datos[4]); // ojo!!: reemplazar en al columna 5 el nombre del lugar por su correspondiente id en la base de produccion
	            
// 	            if(is_numeric($datos[35])) $m->setSolDisTot((int)$datos[35]);
// 	            if(is_numeric($datos[36])) $m->setSolDisFijos((int)$datos[36]);
// 	            if(is_numeric($datos[37])) $m->setSolDisVolat((int)$datos[37]);
	            
// 	            $m->setMostrar(TRUE);

	            
// 	            if(preg_match_all('/(\D*)(\d+.?\d*)/', $datos[38],$match) ){
// 	                if(trim($match[1][0])=='<' || trim($match[1][0])=='˂'){
// 	                    $m->setFluorurosLim(-1);
// 	                } elseif(trim($match[1][0])=='>'){
// 	                    $m->setFluorurosLim(1);
// 	                }
// 	                $m->setFluoruros((float)$match[2][0]);
// 	            }
	            
// 	            if(preg_match_all('/(\D*)(\d+.?\d*)/', $datos[39],$match) ){
// 	                if(trim($match[1][0])=='<' || trim($match[1][0])=='˂'){
// 	                    $m->setNitritosLim(-1);
// 	                } elseif(trim($match[1][0])=='>'){
// 	                    $m->setNitritosLim(1);
// 	                }
// 	                $m->setNitritos((float)$match[2][0]);
// 	            }
	            
// 	            if(preg_match_all('/(\D*)(\d+.?\d*)/', $datos[40],$match) ){
// 	                if(trim($match[1][0])=='<' || trim($match[1][0])=='˂'){
// 	                    $m->setNitratosLim(-1);
// 	                } elseif(trim($match[1][0])=='>'){
// 	                    $m->setNitratosLim(1);
// 	                }
// 	                $m->setNitratos((float)$match[2][0]);
// 	            }
	            
	            
// 	            if(is_numeric($datos[41])) $m->setFosfatos((float)$datos[41]);
	            
// 	            $m->save();
	            
// 	        }
// 	        fclose($gestor);
// 	    }
// 	    die('listo');
// 	}
	
  public function executeMapa(sfWebRequest $request)
  {
  }
		
  public function executeMapaTipo(sfWebRequest $request)
  {
      $this->iconos=array(17=>'sin-especificar.png');
      $this->tipos= TipoMuestraQuery::create()->find() ;
      foreach ($this->tipos as $mt){
          $this->iconos[$mt->getId()]=$mt->getArchivo();
      }
  }

  public function executeWms(sfWebRequest $request)
  {
  	$params =$request->getParameterHolder()->getAll();
  	unset($params['module'],$params['action']);
  
  	$b = new sfWebBrowser();
  
  
  
  	$b->get($this->geoserver.'wms',$params);
  
  	sfConfig::set('sf_web_debug', false);
  	return $this->renderText( $b->getResponseText() );
  }

  public function executeWfs(sfWebRequest $request)
  {
  	//$request->setMethod(sfWebRequest::GET );
  	$params =$request->getParameterHolder()->getAll();
  	unset($params['module'],$params['action']);
  
  	
  	
  	$b = new sfWebBrowser();
  
  	$b->post($this->geoserver.'wfs',$params);
  
  

  	$this->getResponse()->setHttpHeader('Content-type', 'text/xml; subtype=gml/3.1.1');
  	//foreach($b->getResponseHeaders() as $k=>$v) $this->getResponse()->setHttpHeader($k, $v);
  
  
  	sfConfig::set('sf_web_debug', false);
  	return $this->renderText( $b->getResponseText() );
  }
  
  public function executeOws(sfWebRequest $request)
  {
  	$request->setMethod(sfWebRequest::GET );
  	$params =$request->getParameterHolder()->getAll();
  	unset($params['module'],$params['action']);
  	
  	if(!$this->getUser()->hasCredential('admin')){
      	
  	    $f=array();
  	    
  	    $locs = $this->getUser()->getLocalidades();
          	
      	if(count($locs)>0) {
      	    $f[]='localidad_id in ('.join(',',$locs).')';
      	}
      	
      	$a= sfContext::getInstance()->getUser()->getTipos();
      	if(count($a)>0){
      	    $f[]='tipo_id in ('.join(',',$a).')';
      	}
      	$f= join(' and ', $f);
      	if(!empty($f)){
      	    $params['cql_filter']=$f;
      	}
  	}
  	
  	$b = new sfWebBrowser();
  
  	$b->get($this->geoserver.'ows',$params);
  
  	$this->getResponse()->setHttpHeader('Content-type', 'text/xml; subtype=gml/3.1.1');
  
  
  
  	sfConfig::set('sf_web_debug', false);
  	return $this->renderText( $b->getResponseText() );
  }
  
  
}
