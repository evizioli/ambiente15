<?php

/**
 * muestras module configuration.
 *
 * @package    ambiente
 * @subpackage muestras
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class muestrasGeneratorConfiguration extends BaseMuestrasGeneratorConfiguration
{ 
    
    public function getFormDisplay()
    {
        $r=MuestraPeer::$grupos;
        /*
        if(sfContext::getInstance()->getUser()->hasCredential('muestra_mostrar')){
            unset($r['General'][array_search('codigo', $r['General'])]);
        } else {
            unset($r['General'][array_search('mostrar', $r['General'])]);
            unset($r['General'][array_search('numero', $r['General'])]);
            unset($r['General'][array_search('protocolo', $r['General'])]);
        }
        */
        
        if(sfContext::getInstance()->getUser()->esMunicipio()){
            unset($r['General'][array_search('mostrar', $r['General'])]);
            unset($r['General'][array_search('numero', $r['General'])]);
            unset($r['General'][array_search('protocolo', $r['General'])]);
        } else {
            unset($r['General'][array_search('codigo', $r['General'])]);
             if(!sfContext::getInstance()->getUser()->hasCredential('muestra_mostrar')){
                unset($r['General'][array_search('mostrar', $r['General'])]);
             }
        }
        return $r;
    }
    
}
