<?php
class ImportarForm extends BaseForm
{
    public function setup()
    {
        $this->setWidgets(array(
            'archivo'   => new sfWidgetFormInputFile(),
        ));
        
        $this->setValidators(array(
            'archivo'   => new sfValidatorFile(),
        ));
        
        $this->widgetSchema->setNameFormat('importar[%s]');
        
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
        
        parent::setup();
    }
}