<?php
class ConsultaGraficoTiempoFormFilter extends BaseMuestraFormFilter
{
    public function configure()
    {
        parent::configure();
        $this->useFields(array(
            'fecha',
            'lugar_de_extraccion_id',
        ));
        $this->widgetSchema['lugar_de_extraccion_id']->setOption('query_methods',array('innerJoinWithLocalidad','orderByLocalidad','orderByNombre'));    
        $this->widgetSchema['lugar_de_extraccion_id']->setAttribute('class', 'form-control s2');
        $this->validatorSchema['lugar_de_extraccion_id']->setOption('required', true);    
        
        $this->widgetSchema['uso']= new sfWidgetFormPropelChoice(array(
            'model'=>'Uso',
            'add_empty'=>'(Sin nivel guía)',
            'order_by'=>array('Nombre','asc')
        ));
        $this->validatorSchema['uso']= new sfValidatorPropelChoice(array(
            'model'=>'Uso',
            'required'=>false
        ));
        
    }
    
    
    public function addNivelGuiaColumnCriteria($q,$col,$v)
    {
        return $q;
    }
    
    public function addUsoColumnCriteria($q,$col,$v)
    {
        return $q;
    }
}