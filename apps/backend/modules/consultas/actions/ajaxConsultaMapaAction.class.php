<?php
class ajaxConsultaMapaAction extends   sfAction {
    
    
    public function execute( $request) {
        
        sfConfig::set('sf_web_debug',false);
        $this->lugar= LugarExtraccionQuery::create()->leftJoinWithTipoMuestra()
        ->useLocalidadQuery()
        ->orderByNombre()
        ->endUse()
        ->orderByNombre()
        ->findPks($request->getParameter('id'));
        //         $this->forward404If($this->lugar->count()==0);
        if($this->lugar->count()>0){
            $this->nombres= array();
            
            foreach ($this->lugar as $l) $this->nombres[$l->getId()]=$l->conTipo();
            
            $w='true';
            if(!$this->getUser()->hasCredential('admin')){
                $tipos= $this->getUser()->getTipos();
                if(count($tipos)>0){
                    $w.=' and muestra.tipo_id in( '.join(',', $tipos).' )';
                }
                if(!$this->getUser()->hasCredential('muestra_ver_todas')){
                    $w.=' and muestra.mostrar';
                }
            }
            
            
            $q = " select muestra.*,  lugar_extraccion.*, localidad.nombre localidad,
                
            muestra.id mid,
                
            CASE
                WHEN didymosphenia_geminata=true THEN 'Detectada'
                WHEN didymosphenia_geminata=false THEN 'No Detectada'
                ELSE ''
            END didymosphenia_geminata_pa,
                
                
            lugar_extraccion.nombre  lugar,
                
            protocolo || '/' || ye protocolo_ye,
                
            sc_coliformes_totales.maximo nmp_coliformes_totales_100_maximo,
        	sc_coliformes_fecales.maximo nmp_coliformes_fecales_100_maximo,
        	sc_coli.maximo nmp_escherichia_coli_100_maximo,
        	sc_enterococos.maximo nmp_enterococos_fecales_100_maximo,
                
        	sc_coliformes_totales.maximo nmp_coliformes_totales_100_con_lim_maximo,
        	sc_coliformes_fecales.maximo nmp_coliformes_fecales_100_con_lim_maximo,
        	sc_coli.maximo nmp_escherichia_coli_100_con_lim_maximo,
        	sc_enterococos.maximo nmp_enterococos_fecales_100_con_lim_maximo,
                
            CASE
                WHEN nmp_coliformes_totales_100_lim=1 THEN '>'
                WHEN nmp_coliformes_totales_100_lim=-1 THEN '<'
                WHEN nmp_coliformes_totales_100_lim=2 THEN '≥'
                WHEN nmp_coliformes_totales_100_lim=-2 THEN '≤'
                ELSE ''
            END || nmp_coliformes_totales_100 nmp_coliformes_totales_100_con_lim,
                
            CASE
                WHEN nmp_coliformes_fecales_100_lim=1 THEN '>'
                WHEN nmp_coliformes_fecales_100_lim=-1 THEN '<'
                WHEN nmp_coliformes_fecales_100_lim=2 THEN '≥'
                WHEN nmp_coliformes_fecales_100_lim=-2 THEN '≤'
                ELSE ''
            END || nmp_coliformes_fecales_100 nmp_coliformes_fecales_100_con_lim,
                
            CASE
                WHEN nmp_escherichia_coli_100_lim=1 THEN '>'
                WHEN nmp_escherichia_coli_100_lim=-1 THEN '<'
                WHEN nmp_escherichia_coli_100_lim=2 THEN '≥'
                WHEN nmp_escherichia_coli_100_lim=-2 THEN '≤'
                ELSE ''
            END || nmp_escherichia_coli_100 nmp_escherichia_coli_100_con_lim,
                
            CASE
                WHEN nmp_enterococos_fecales_100_lim=1 THEN '>'
                WHEN nmp_enterococos_fecales_100_lim=-1 THEN '<'
                WHEN nmp_enterococos_fecales_100_lim=2 THEN '≥'
                WHEN nmp_enterococos_fecales_100_lim=-2 THEN '≤'
                ELSE ''
            END || nmp_enterococos_fecales_100 nmp_enterococos_fecales_100_con_lim,
                
            tipo_muestra.nombre tipo,
            CASE WHEN dbo5_mg_l_lim >0 THEN '>' WHEN dbo5_mg_l_lim<0 THEN '<' ELSE '' END || dbo5_mg_l dbo5_mg_l_con_lim,
            CASE WHEN dqo_mg_l_lim >0 THEN '>' WHEN dqo_mg_l_lim<0 THEN '<' ELSE '' END || dqo_mg_l dqo_mg_l_con_lim,

            CASE 
                WHEN conductividad_electrica> 0 THEN conductividad_electrica || ' ' || conductividad_electrica_unidad
                ELSE ''
            END conductividad_electrica_con_unidad
                
                
                
        from muestra
        	inner join lugar_extraccion on muestra.lugar_de_extraccion_id= lugar_extraccion.id
        	inner join localidad on lugar_extraccion.localidad_id= localidad.id
                
                
        	inner join tipo_muestra on tipo_muestra.id = muestra.tipo_id
                
        	left join(
        		SELECT muestra.id, sc.maximo
        		FROM muestra
        		     inner JOIN ( SELECT * from tolerancia_desde_hasta(1,".$request->getParameter('uso').") )  sc ON  muestra.fecha >= sc.desde AND muestra.fecha <= sc.hasta
        		         
        		  WHERE muestra.nmp_coliformes_totales_100 IS NOT NULL
        		         
        	) sc_coliformes_totales on sc_coliformes_totales.id = muestra.id
        		         
        	left join(
        		SELECT muestra.id, sc.maximo
        		FROM muestra
        		     inner JOIN ( SELECT * from tolerancia_desde_hasta(2,".$request->getParameter('uso').")  )  sc ON  muestra.fecha >= sc.desde AND muestra.fecha <= sc.hasta
        		         
        		         
        		  WHERE muestra.nmp_coliformes_fecales_100 IS NOT NULL
        		         
        	) sc_coliformes_fecales on sc_coliformes_fecales.id = muestra.id
        		         
        	left join(
        		SELECT muestra.id, sc.maximo
        		FROM muestra
        		     inner JOIN ( SELECT * from tolerancia_desde_hasta(3,".$request->getParameter('uso').")  )  sc ON  muestra.fecha >= sc.desde AND muestra.fecha <= sc.hasta
        		         
        		         
        		  WHERE muestra.nmp_escherichia_coli_100 IS NOT NULL
        		         
        	) sc_coli on sc_coli.id = muestra.id
        		         
        	left join(
        		SELECT muestra.id, sc.maximo
        		FROM muestra
        		     inner JOIN ( SELECT * from tolerancia_desde_hasta(4,".$request->getParameter('uso').")  )  sc ON  muestra.fecha >= sc.desde AND muestra.fecha <= sc.hasta
        		     
        		     
        		  WHERE muestra.nmp_enterococos_fecales_100 IS NOT NULL
        		  
        	) sc_enterococos on sc_enterococos.id = muestra.id
        	
            where $w and muestra.lugar_de_extraccion_id in (".join(',',$request->getParameter('id')).")
            order by muestra.fecha desc, localidad.nombre, lugar_extraccion.nombre
        	";
            
            ///////////////////////
            $this->ph = MuestraQuery::create()
            ->select(array('prom','mini','maxi','uf'))
            ->withColumn('avg(ph)::numeric(10,1)','prom')
            ->withColumn('min(ph)','mini')
            ->withColumn('max(ph)','maxi')
            ->withColumn('max(fecha)','uf')
            ->filterByPh(null, Criteria::ISNOTNULL)
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->findOne();
            
            $this->ph['ulti'] = MuestraQuery::create()
            ->select( 'ulti')
            ->withColumn('ph','ulti')
            ->filterByFecha($this->ph['uf'])
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->orderById('desc')
            ->findOne();
            
            
            
            ///////////////////////
            $this->temperatura = MuestraQuery::create()
            ->select(array('prom','mini','maxi','uf'))
            ->withColumn('avg(temperatura)::numeric(10,1)','prom')
            ->withColumn('min(temperatura)','mini')
            ->withColumn('max(temperatura)','maxi')
            ->withColumn('max(fecha)','uf')
            ->filterByConductividadElectrica(null, Criteria::ISNOTNULL)
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->findOne();
            
            $this->temperatura['ulti'] = MuestraQuery::create()
            ->select( 'ulti')
            ->withColumn('temperatura','ulti')
            ->filterByFecha($this->temperatura['uf'])
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->orderById('desc')
            ->findOne();
            
            ///////////////////////
            
            $this->nmp_enterococos_fecales_100 = MuestraQuery::create()
            ->select(array('prom','mini','maxi','uf'))
            ->withColumn('avg(nmp_enterococos_fecales_100)::numeric(10,1)','prom')
            ->withColumn('min(nmp_enterococos_fecales_100)','mini')
            ->withColumn('max(nmp_enterococos_fecales_100)','maxi')
            ->withColumn('max(fecha)','uf')
            ->filterByNmpEnterococosFecales100(null, Criteria::ISNOTNULL)
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->findOne();
            
            $this->nmp_enterococos_fecales_100['ulti'] = MuestraQuery::create()
            ->select( 'ulti')
            ->withColumn('nmp_enterococos_fecales_100','ulti')
            ->filterByFecha($this->nmp_enterococos_fecales_100['uf'])
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->orderById('desc')
            ->findOne();
            
            
            ///////////////////////
            
            $this->nmp_escherichia_coli_100 = MuestraQuery::create()
            ->select(array('prom','mini','maxi','uf'))
            ->withColumn('avg(nmp_escherichia_coli_100)::numeric(10,1)','prom')
            ->withColumn('min(nmp_escherichia_coli_100)','mini')
            ->withColumn('max(nmp_escherichia_coli_100)','maxi')
            ->withColumn('max(fecha)','uf')
            ->filterByNmpEnterococosFecales100(null, Criteria::ISNOTNULL)
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->findOne();
            
            $this->nmp_escherichia_coli_100['ulti'] = MuestraQuery::create()
            ->select( 'ulti')
            ->withColumn('nmp_escherichia_coli_100','ulti')
            ->filterByFecha($this->nmp_escherichia_coli_100['uf'])
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->orderById('desc')
            ->findOne();
            
            
            ///////////////////////
            
            $this->nmp_coliformes_fecales_100 = MuestraQuery::create()
            ->select(array('prom','mini','maxi','uf'))
            ->withColumn('avg(nmp_coliformes_fecales_100)::numeric(10,1)','prom')
            ->withColumn('min(nmp_coliformes_fecales_100)','mini')
            ->withColumn('max(nmp_coliformes_fecales_100)','maxi')
            ->withColumn('max(fecha)','uf')
            ->filterByNmpEnterococosFecales100(null, Criteria::ISNOTNULL)
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->findOne();
            
            $this->nmp_coliformes_fecales_100['ulti'] = MuestraQuery::create()
            ->select( 'ulti')
            ->withColumn('nmp_coliformes_fecales_100','ulti')
            ->filterByFecha($this->nmp_coliformes_fecales_100['uf'])
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->orderById('desc')
            ->findOne();
            
            
            ///////////////////////
            $this->nmp_coliformes_totales_100 = MuestraQuery::create()
            ->select(array('prom','mini','maxi','uf'))
            ->withColumn('avg(nmp_coliformes_totales_100)::numeric(10,1)','prom')
            ->withColumn('min(nmp_coliformes_totales_100)','mini')
            ->withColumn('max(nmp_coliformes_totales_100)','maxi')
            ->withColumn('max(fecha)','uf')
            ->filterByNmpEnterococosFecales100(null, Criteria::ISNOTNULL)
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->findOne();
            
            $this->nmp_coliformes_totales_100['ulti'] = MuestraQuery::create()
            ->select( 'ulti')
            ->withColumn('nmp_coliformes_totales_100','ulti')
            ->filterByFecha($this->nmp_coliformes_totales_100['uf'])
            ->filterByLugarDeExtraccionId( $request->getParameter('id'), Criteria::IN)
            ->filterByMostrar(1)
            ->orderById('desc')
            ->findOne();
            
            $this->muestras = Propel::getConnection()->query($q )->fetchAll(PDO::FETCH_ASSOC);
            
            $this->columnas = BaseMuestraPeer::getFieldNames();
            
            $this->mostrar= array (
                'fecha' => array(null,'format_date',array('dd/MM/yyyy',null,null,null)),
                'localidad' => null,
                'nombre' => array('Lugar'),
                'protocolo_ye' => array('Protocolo'),
                'tipo' => null,
                'nmp_coliformes_totales_100' => array(null,array( 'MuestraPeer','conLim'), array()),
                'nmp_coliformes_fecales_100' => array(null,array( 'MuestraPeer','conLim'), array()),
                'nmp_escherichia_coli_100' => array(null,array( 'MuestraPeer','conLim'), array()),
                'nmp_enterococos_fecales_100' => array(null,array( 'MuestraPeer','conLim'), array()),
                'temperatura' => null,
                'ph' => null,
                'conductividad_electrica_con_unidad' =>array('Conductividad eléctrica',array( 'MuestraPeer','conduc'), array()),
                'turbiedad_unt' => null,
                'od_mg_l' => null,
                'od_porcentaje' => null,
                'didymosphenia_geminata_pa' => array('Didymosphenia Geminata'),
                'dbo5_mg_l' => array(null,array( 'MuestraPeer','conLim'), array()),
                'dqo_mg_l' => array(null,array( 'MuestraPeer','conLim'), array()),
                'dureza_ca_co3_mg_l' => null,
                'cloruros_mg_l' => null,
                'sulfatos_mg_l' => null,
                'calcio_mg_l' => null,
                'magnesio_mg_l' => null,
                'sodio_mg_l' => null,
                'potasio_mg_l' => null,
                'sol_sup_tot_103_105_mg_l' => null,
                'solidos_sedimentables_10min_mg_l' => null,
                'solidos_sedimentables_1h_mg_l' => null,
                'solidos_sedimentables_2h_mg_l' => null,
                'sol_tot_105_mg_l' => null,
                'sol_totales_fijos_mg_l' => null,
                'sol_totales_volatiles_mg_l' => null,
                'sol_dis_tot' => null,
                'sol_dis_fijos' => null,
                'sol_dis_volat' => null,
                'taxa'=>null
            );
        }
        
        //         $this->setLayout(false);
        
        
        $ret['bact']=$this->getPartial('bacteriologicos', array(
            'nmp_coliformes_totales_100' => $this->nmp_coliformes_totales_100,
            'nmp_coliformes_fecales_100' => $this->nmp_coliformes_fecales_100,
            'nmp_escherichia_coli_100' => $this->nmp_escherichia_coli_100,
            'nmp_enterococos_fecales_100' => $this->nmp_enterococos_fecales_100,
            'temperatura'=>$this->temperatura,
            'ph'=>$this->ph
        ));
        
        $ret['data']=$this->getPartial('data', array(
        //            'mostrar'=>$this->mostrar,
            'lugar'=>$this->lugar,
            'nombres'=>$this->nombres,
            //            'muestras'=>$this->muestras
            'muestras_count'=>count( $this->muestras)
        ));
        
        
        $numberFormat = new sfNumberFormat($this->getContext()->getUser()->getCulture());
        
        
        $resultado=[];
        foreach ($this->mostrar as $col => $aux){
            $row=array(
                'var'=>!(is_null($aux) || is_null($aux[0])) ? $aux[0] : $this->getContext()->getI18N()->__(sfInflector::humanize(  $col ), array(),'messages'),
                'values'=>array()
            );
            foreach ($this->muestras as $m){
                $tmp = ($aux && isset($aux[1])) ? call_user_func_array($aux[1],array_merge( array($m[$col]),$aux[2],array($m,$col)))  : $m[$col]  ;
                $row['values'][]=array(
                    'rojo'=>isset($m[$col.'_maximo']) && $m[$col.'_maximo']<=$m[$col],
                    'valor'=>is_numeric($tmp) ? $numberFormat->format($tmp) : $tmp
                );
            }
            
            $resultado[]=$row;
        }
        $ret['resultado']=(object)$resultado;
        
        $ids=[];
        foreach ($this->muestras as $m){
            $ids[]=$m['mid'];
        }
        $ret['ids']=$ids;
        
        $this->getResponse()->setContentType('application/json');
        
        return $this->renderText( json_encode($ret) );
        
        
    }
}