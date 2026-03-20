<?php



// sfMixer::register('BaseMuestra:delete:post', 'MuestraPeer::notificarBorrado');

class MuestraPeer extends BaseMuestraPeer {

    public static function conduc($v,$muestra,$c)
    {
        if(strpos($muestra[$c], ' ')!==false) {
            $a= explode(' ', $muestra[$c]);
            return $a[0].' '. self::$conduc[intval($a[1])];
        }
    }
    
    public static $conduc = array( '0'=>'µS/cm', '1'=>'mS/cm' );
    
    public static function path()
    {
        return sfConfig::get('sf_data_dir').'/muestras_adjuntos/';
    }
    
    public static $grupos = array(  
        'General' =>   array(    
            'codigo',
            'numero',    
            'protocolo',    
            'ye',    
            'lugar_de_extraccion_id',    
            'tipo_id',    
            'fecha',    
            'responsable_id',    
            'rotulo_precinto',    
            'solicitado_por',    
            'observaciones',    
            'mostrar',  
            'alerta'
            ),  
        'Bactereológico' =>   array(    
            'nmp_coliformes_totales_100',    
            'nmp_coliformes_totales_100_lim',    
            'nmp_coliformes_fecales_100',    
            'nmp_coliformes_fecales_100_lim',    
            'nmp_escherichia_coli_100',    
            'nmp_escherichia_coli_100_lim',    
            'nmp_enterococos_fecales_100',    
            'nmp_enterococos_fecales_100_lim',  
            
            ),  
        'Físico Químicos' =>   array(    
            'temperatura',    
            'ph',    
            'conductividad_electrica',    
            'conductividad_electrica_unidad',    
            'turbiedad_unt',    
            'od_mg_l',    
            'od_porcentaje',    
            'dbo5_mg_l',    
            'dbo5_mg_l_lim',    
            'dqo_mg_l',    
            'dqo_mg_l_lim',    
            'dureza_ca_co3_mg_l',    
            'cloruros_mg_l',    
            'cloruros_mg_l_lim',    
            'sulfatos_mg_l',    
            'sulfatos_mg_l_lim',    
            'calcio_mg_l',    
            'magnesio_mg_l',    
            'magnesio_mg_l_lim',    
            'sodio_mg_l',    
            'sodio_mg_l_lim',    
            'potasio_mg_l',    
            'potasio_mg_l_lim',    
            'ras',    
            'alcalinidad_total',    
            'alcalinidad_total_lim',    
            'carbonatos',    
            'carbonatos_lim',    
            'bicarbonatos',    
            'bicarbonatos_lim',  
            
            ),  
        'Sólidos' =>   array(    
            'sol_sup_tot_103_105_mg_l',    
            'sol_sup_tot_103_105_mg_l_lim',    
            'solidos_sedimentables_10min_mg_l',    
            'solidos_sedimentables_10min_mg_l_lim',    
            'solidos_sedimentables_1h_mg_l',    
            'solidos_sedimentables_1h_mg_l_lim',    
            'solidos_sedimentables_2h_mg_l',    
            'solidos_sedimentables_2h_mg_l_lim',    
            'sol_tot_105_mg_l',    
            'sol_tot_105_mg_l_lim',    
            'sol_totales_fijos_mg_l',    
            'sol_totales_fijos_mg_l_lim',    
            'sol_totales_volatiles_mg_l',    
            'sol_totales_volatiles_mg_l_lim',    
            'sol_dis_tot',    
            'sol_dis_fijos',    
            'sol_dis_volat',  
            
            ),  
        'Orgánicos' =>   array(    
            'nitritos',    
            'nitritos_lim',    
            'nitratos',    
            'nitratos_lim',    
            'fosfatos',    
            'fosforo_reactivo_disuelto',    
            'fosforo_reactivo_disuelto_lim',    
            'grasas_aceites',    
            'grasas_aceites_lim',    
            'detergentes_anionicos',    
            'detergentes_anionicos_lim',  
                
            ),  
        'Microalgas' => array(
            'taxa',
            'da1',
            'da2',
            'da3',
            'da4',
            'da5',
            'ma_archivo'
            ),
        'Otros' =>   array(    
            'fluoruros',    
            'fluoruros_lim',    
            'didymosphenia_geminata'  
            
            )
    
    );
    
	static function conLim($valor,$muestra,$col)
	{
	    
	    return $muestra[$col.'_con_lim'];
	}
	
	
} // MuestraPeer
