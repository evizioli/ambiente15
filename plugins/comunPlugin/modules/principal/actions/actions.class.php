<?php

/**
 * principal actions.
 *
 * @package    sspp_fact_telef
 * @subpackage principal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class principalActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    
  }
  
  public function executeExcel(sfWebRequest $request)
  {
		$this->rows=$request->getParameter('rows', array());
		$this->configuration=$request->getParameter('configuration', array());
		
		sfConfig::set('sf_web_debug', false);

		$this->setLayout(false);

		$this->getResponse()->setHttpHeader('Cache-Control', 'no-cache, must-revalidate' );
		$this->getResponse()->setHttpHeader('Pragma', 'no-cache' );
		$this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=resultados.xls' );
		$this->getResponse()->setContentType('application/msexcel; charset=utf-8');

				    
  }
  
  
}
