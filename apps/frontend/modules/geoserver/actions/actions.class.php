<?php

/**
 * geoserver actions.
 *
 * @package    ambiente
 * @subpackage geoserver
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class geoserverActions extends sfActions
{
 
    protected $geoserver ='http://localhost:8080/geoserver';
    
  public function executeWms(sfWebRequest $request)
  {
      $request->setMethod(sfWebRequest::GET );
      $params =$request->getParameterHolder()->getAll();
      unset($params['module'],$params['action']);
      
//       if(!isset($params['service'])){
          $params['service']='WMS';
//       }
//       $ws='ows';
//       if(!isset($params['request'])){
//           $params['request']='GetCapabilities';
//       } elseif ($params['request']=='GetMap'){
          $ws='ambiente/wms';
//       }
      
//       if(!$this->getUser()->hasCredential('admin')){
          
//       }
      
      $b = new sfWebBrowser();
      
      $b->get($this->geoserver.'/'.$ws.'/',$params);
      
//       $this->getResponse()->setHttpHeader('Content-type', 'text/xml; subtype=gml/3.1.1');
      $this->getResponse()->setHttpHeader('Content-type', $request->getParameter('format','image/png'));
      
      sfConfig::set('sf_web_debug', false);
      
      return $this->renderText( str_ireplace( '::8080', '', $b->getResponseText() ));
      
  }
  
  
  
  public function executeOws(sfWebRequest $request)
  {
      $request->setMethod(sfWebRequest::GET );
      $params =$request->getParameterHolder()->getAll();
      unset($params['module'],$params['action']);
      
//       if(!$this->getUser()->hasCredential('admin')){
          
//           $f=array();
          
//           $locs = $this->getUser()->getLocalidades();
          
//           if(count($locs)>0) {
//               $f[]='localidad_id in ('.join(',',$locs).')';
//           }
          
//           $a= sfContext::getInstance()->getUser()->getTipos();
//           if(count($a)>0){
//               $f[]='tipo_id in ('.join(',',$a).')';
//           }
//           $f= join(' and ', $f);
//           if(!empty($f)){
//               $params['cql_filter']=$f;
//           }
//       }
      
      $b = new sfWebBrowser();
      
      $b->get($this->geoserver.'/ows',$params);
      
      $this->getResponse()->setHttpHeader('Content-type', 'text/xml; subtype=gml/3.1.1');
      
      
      
      sfConfig::set('sf_web_debug', false);
      return $this->renderText( $b->getResponseText() );
  }
  
  
  public function executeIndex(sfWebRequest $request)
  {
      $request->setMethod(sfWebRequest::GET );
      $params =$request->getParameterHolder()->getAll();
      unset($params['module'],$params['action']);
      
      if(!isset($params['service'])){
          $params['service']='WMS';
      }
      $ws='ows';
//       if(!isset($params['request'])){
          $params['request']='GetCapabilities';
//       } elseif ($params['request']=='GetMap'){
//           $ws='ambiente';
//       }
      
      if(!$this->getUser()->hasCredential('admin')){
          
      }
      
      $b = new sfWebBrowser();
      
      $b->get($this->geoserver.'/'.$ws.'/',$params);
      
      $this->getResponse()->setHttpHeader('Content-type', 'text/xml; subtype=gml/3.1.1');
      
      
      
      sfConfig::set('sf_web_debug', false);
      
      
      
      
      return $this->renderText( str_ireplace( $this->geoserver, $this->getController()->genUrl('geoserver/index',true), $b->getResponseText() ));
      
  }
}
