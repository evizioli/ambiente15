<?php

require_once dirname(__FILE__).'/../lib/especiesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/especiesGeneratorHelper.class.php';

/**
 * especies actions.
 *
 * @package    ambiente
 * @subpackage especies
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class especiesActions extends autoEspeciesActions
{
    public function executeImpo()
    {
        $ch = curl_init();
        curl_setopt_array($ch, ProjectConfiguration::options() + array(
            CURLOPT_CUSTOMREQUEST => "GET"
        ));
        $url='https://wcsargentinaconnect.smartconservationtools.org:8443/server/api/';
        curl_setopt($ch, CURLOPT_URL, $url.  'metadata/datamodel/'.ProjectConfiguration::SMART_APV.'/info' );
        
        $response = curl_exec($ch);
        
        curl_close($ch);
        
        print_r($response);
        die();
        
    }
    public function executeEdit(sfWebRequest $request)
    {
        parent::executeEdit($request);
        $default=BidEspecieRelevanciaQuery::create()
        ->select(array( 'i'))
        ->withColumn('indicador','i')
        ->filterByEspecieId($request->getParameter('id'))
        ->find()->toArray();
        $this->form->setDefault('indicador', $default);
    }
    
}
