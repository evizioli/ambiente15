<?php

/**
 * Muestra filter form.
 *
 * @package    ambiente
 * @subpackage filter
 * @author     Your name here
 */
class MuestraFormFilter extends BaseMuestraFormFilter
{
  public function configure()
  {
      
    if(sfContext::getInstance()->getUser()->esMunicipio()){
        $f=array( 
          'fecha',
          'codigo',
          'ye',
          'tipo_id',
          'lugar_de_extraccion_id'
        );
    } else {
        $f=array( 
          'fecha',
          'numero',
          'protocolo',
          'ye',
          'tipo_id',
          'lugar_de_extraccion_id'
        );
        if(sfContext::getInstance()->getUser()->hasCredential('muestra_mostrar')){
          
            $f[]='responsable_id';
            $f[]='mostrar';
            $this->widgetSchema['responsable_id']->setOption('query_methods', array('orderByNombre'));
        }
    }
    $this->useFields($f);
    
      /*
    if(sfContext::getInstance()->getUser()->hasCredential('muestra_mostrar')){
        $this->widgetSchema['responsable_id']->setOption('query_methods', array('orderByNombre'));
    } else {
        unset($this['responsable_id']);
    }
    */
    if(sfContext::getInstance()->getUser()->hasCredential('admin')){
        $this->widgetSchema['tipos_mezclados']  = new sfWidgetFormInputCheckbox();  
        $this->validatorSchema['tipos_mezclados']  = new sfValidatorBoolean(array('required'=>false));  
    }

  	$this->widgetSchema['lugar_de_extraccion_id']->setOption('query_methods', array('orderByLocalidad','orderByNombre'));
  	$this->widgetSchema['lugar_de_extraccion_id']->setAttribute('class', 'form-control s2');
  	$this->widgetSchema->setLabel('lugar_de_extraccion_id','Lugar de extracción conocido');
  	
  	
  	$this->widgetSchema['tipo_id']->setOption('order_by', array('Nombre','asc'));
  	
  	
  	$this->widgetSchema['localidad_id']= new sfWidgetFormPropelChoice(array(
  	    'model'=>'Localidad',
  	    'add_empty'=>true,
  	    'order_by'=>array('Nombre','asc')
  	));
  	$this->validatorSchema['localidad_id']= new sfValidatorPropelChoice(array(
  	    'model'=>'Localidad',
  	    'required'=>false,
  	));
  }
}
