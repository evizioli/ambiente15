<?php
class ConsultaGraficoFormFilter extends BaseMuestraFormFilter
{
    public function configure()
    {
        $this->useFields(array(
            'fecha'
        ));
        $this->widgetSchema['localidad'] = new sfWidgetFormPropelChoice(array(
            'model'=>'Localidad',
            'order_by'=>array('Nombre','asc'),
            'add_empty'=>true
        ),array(
            'class'=>'s2'
        ));
        $this->validatorSchema['localidad'] = new sfValidatorPropelChoice(array(
            'model'=>'Localidad',
        ));


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
    
    public function addLocalidadColumnCriteria(MuestraQuery $q,$col,$v)
    {
        return $q->useLugarExtraccionQuery()->filterByLocalidadId($v)->endUse();
    }
}