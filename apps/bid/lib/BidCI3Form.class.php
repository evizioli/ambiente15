<?php
class BidCI3Form extends BidConteoIndicadorForm
{
    public function configure()
    {
        parent::configure();
        $this->widgetSchema['sitio_id']->setOption('criteria', BidSitioQuery::create()->filterByAreaProtegida(ProjectConfiguration::ANPPV));
        $this->widgetSchema['especie_id']->setOption('query_methods', array( 'para'=>array(BidConteoIndicadorPeer::MAMIFEROS_CARNIVOROS) ));
        
    }
    
    protected function doUpdateObject($values)
    {
        parent::doUpdateObject($values);
        $this->getObject()->setIndicador(BidConteoIndicadorPeer::MAMIFEROS_CARNIVOROS);
    }
}