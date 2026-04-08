<?php
class BidCI2Form extends BidConteoIndicadorForm
{
    public function configure()
    {
        parent::configure();
        $this->widgetSchema['sitio_id']->setOption('query_methods',array( 'filterByAreaProtegida'=>array( ProjectConfiguration::ANPPV)));
        $this->widgetSchema['especie_id']->setOption('query_methods', array( 'para'=>array(BidConteoIndicadorPeer::AVES_PALYERAS_ANPPV) ));
        
    }
    
    protected function doUpdateObject($values)
    {
        parent::doUpdateObject($values);
        $this->getObject()->setIndicador(BidConteoIndicadorPeer::AVES_PALYERAS_ANPPV);
    }
}