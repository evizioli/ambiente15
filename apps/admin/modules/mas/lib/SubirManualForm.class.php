<?php
class SubirManualForm extends BaseForm
{
    public function setup()
    {
        
        $this->setWidgets(array(
            'consulta' => new sfWidgetFormInputFile(array(),array('class'=>'form-control')),
            'acceso' => new sfWidgetFormInputFile(array(),array('class'=>'form-control')),
            'muni' => new sfWidgetFormInputFile(array(),array('class'=>'form-control')),
        ));
        
        $this->setValidators(array(
            'consulta' => new sfValidatorFile(array(
                'mime_types'=>array('application/pdf'),
                    'required'=>false
                ),array(
                    'mime_types' => 'Debe proveer un archivo de tipo PDF'
                )),
            'acceso' => new sfValidatorFile(array(
                    'mime_types'=>array('application/pdf'),
                    'required'=>false
                ),array(
                    'mime_types' => 'Debe proveer un archivo de tipo PDF'
                )),
            'muni' => new sfValidatorFile(array(
                    'mime_types'=>array('application/pdf'),
                    'required'=>false
                ),array(
                    'mime_types' => 'Debe proveer un archivo de tipo PDF'
                )),
        ));
        
        $this->widgetSchema->setLabels(array(
            'consulta'=> 'Tutorial SPIA para usuarios de consulta',
            'acceso'=> 'Tutorial SPIA para usuarios con acceso',
            'muni'=> 'Tutorial SPIA para usuarios de municipios'
        ));        
        
        $this->widgetSchema->setNameFormat('SubirManualForm[%s]');
        
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
        
        
        parent::setup();
    }
}