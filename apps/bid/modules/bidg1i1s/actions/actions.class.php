<?php

require_once dirname(__FILE__).'/../lib/bidg1i1sGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bidg1i1sGeneratorHelper.class.php';

/**
 * bidg1i1s actions.
 *
 * @package    ambiente
 * @subpackage bidg1i1s
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class bidg1i1sActions extends autoBidg1i1sActions
{
    public function executeEdit(sfWebRequest $request) {
        parent::executeEdit($request);
        $this->form->setDefault('sexo_madurez',$this->form->getObject()->getSexoMadurez());
    }
    
    public function executeIndicador(sfWebRequest $request)
    {
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
        if($request->isMethod('post')){
            if ($request->hasParameter('_reset'))
            {
                $this->setFilters($this->configuration->getFilterDefaults());
                
                $this->redirect('bidg1i1s/indicador');
            }
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
            
            $this->filters->bind($request->getParameter($this->filters->getName()));
            if ($this->filters->isValid())
            {
                $this->setFilters($this->filters->getValues());
                
                $this->redirect('bidg1i1s/indicador');
            }
            
        }
        $query = $this->buildQuery();
        $qcl= clone $query;
        $this->actividad_pesquera  =$qcl->where('actividad_pesquera and  extract(month from fecha) in (12, 1, 2)')->count() > 0;
        
        $qcl= clone $query;
        $this->hembras_desove_intermareal =$qcl->filterByAmbiente('i')->filterBySexo('h')->filterByMadurez('d')->count() > 0;
        
        $this->total = $query->count();
        $this->grupos=$query->select(array('sexo_madurez','s'))->groupBySexo()->groupByMadurez()->withColumn('sexo||madurez','sexo_madurez')->withColumn('count(*)','s')->find();
    }
}
