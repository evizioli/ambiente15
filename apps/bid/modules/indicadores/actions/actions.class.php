<?php

/**
 * default actions.
 *
 * @package    ambiente
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class indicadoresActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }
  
  public function executeMapa(sfWebRequest $request)
  {
      
  }
  
  public function executeKml(sfWebRequest $request)
  {
      
      if($kmlOutput = file_get_contents(ProjectConfiguration::guessRootDir().'/data/'.$request->getParameter('nombre').'.kml') ){ 
        $this->getResponse()->setHttpHeader('Content-type','application/vnd.google-earth.kml+xml');
        return $this->renderText( $kmlOutput );
      }
      $this->forward404();
  }
  
}
