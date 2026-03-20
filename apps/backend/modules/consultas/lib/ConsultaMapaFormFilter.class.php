<?php
class ConsultaMapaFormFilter extends Baseform
{
    public function setup()
    {
        $this->widgetSchema->addFormFormatter('bsf', new BsFormatter( $this->widgetSchema));
        $this->widgetSchema->setFormFormatterName('bsf');
        
        $this->setWidgets(array(
            'uso'=> new sfWidgetFormPropelChoice(array(
                'model'=>'Uso',
                'add_empty'=>'(Sin nivel guía)',
                'order_by'=>array('Nombre','asc')
            )),
            'fecha' => new sfWidgetFormFilterDate(array(
                'from_date' => new sfWidgetFormBootstrapDatePicker(), 
                'to_date' => new sfWidgetFormBootstrapDatePicker(), 
                'template' => '<div style="width:18px; display: inline-block;">De</div>%from_date%<br /><div style="width:18px; display: inline-block;">A</div>%to_date%', 'with_empty' => false)),
            
        ));
        
        $this->setValidators(array(
            
            'uso'=> new sfValidatorPropelChoice(array(
                'model'=>'Uso',
                'required'=>false
            )),
            'fecha' => new sfValidatorDateRange(array(
                'required' => false, 
                'from_date' => new sfValidatorDate(array('required' => false)), 
                'to_date' => new sfValidatorDate(array('required' => false)))),
            
        ));
        
        $this->widgetSchema->setNameFormat('consulta_mapa[%s]');
        
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
        
        parent::setup();
        
    }

}