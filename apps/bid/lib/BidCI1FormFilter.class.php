<?php
class BidCI1FormFilter extends BidConteoIndicadorFormFilter
{
    public function configure()
    {
        parent::configure();
        $this->widgetSchema['sitio_id']->setOption('query_methods',array( 'filterByAreaProtegida'=>array( ProjectConfiguration::PIMCPA)));
        $this->widgetSchema['especie_id']->setOption('query_methods',array( 'para'=>array( BidConteoIndicadorPeer::AVES_PALYERAS_PIMCPA)));
    }
}