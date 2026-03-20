<?php

/**
 * BidG1I1 form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class BidG1I1Form extends BaseBidG1I1Form
{

    public function configure()
    {
        $this->useFields(array(
            'fecha',
            'sitio_id',
            'ambiente',
            'actividad_pesquera'
        ));

        $this->widgetSchema['ambiente'] = new sfWidgetFormChoice(array(
            'choices' => array(
                '' => ''
            ) + BidG1I1Peer::$ambientes
        ));
        $this->validatorSchema['ambiente'] = new sfValidatorChoice(array(
            'choices' => array_keys(BidG1I1Peer::$ambientes)
        ));

        $this->widgetSchema['sitio_id']->setOption('order_by', array(
            'Nombre',
            'asc'
        ));
        $this->widgetSchema['sitio_id']->setOption('add_empty', true);
        $this->widgetSchema['sitio_id']->setAttribute('class', 's2');
        $this->widgetSchema['sitio_id']->setOption('criteria', BidSitioQuery::create()->filterByAreaProtegida(ProjectConfiguration::PIMCPA));
        
        $this->widgetSchema['sexo_madurez'] = new sfWidgetFormChoice(array(
            'choices' => array('' => '' )+ BidG1I1Peer::$sexos_madureces
        ));
        $this->validatorSchema['sexo_madurez'] = new sfValidatorChoice(array(
            'choices' => array_keys(BidG1I1Peer::$sexos_madureces)
        ));
        $this->widgetSchema->setLabel('sexo_madurez', 'Sexo y madurez');
    }

    public function updateSexoMadurezColumn($sm)
    {
        $this->getObject()->setSexoMadurez($sm);
    }
}
