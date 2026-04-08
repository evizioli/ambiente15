<?php
class BidCI2FormFilter extends BidConteoIndicadorFormFilter
{
    public function configure()
    {
        parent::configure();
        $this->widgetSchema['sitio_id']->setOption('criteria', BidSitioQuery::create()->filterByAreaProtegida(ProjectConfiguration::ANPPV));
        $this->widgetSchema['especie_id']->setOption('query_methods',array( 'para'=>array( BidConteoIndicadorPeer::AVES_PALYERAS_ANPPV)));
    }
}