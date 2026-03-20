<?php

/**
 * Esquema form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class EsquemaForm extends BaseEsquemaForm
{
  public function configure()
  {
      unset($this['mime'],$this['nombre_original']);
      
      $this->widgetSchema['esquema_id']->setOption('order_by', array('Nombre','asc'));
      $this->widgetSchema['esquema_id']->setAttribute('class', 's2');
      
      
      
      sfContext::getInstance()->getConfiguration()->loadHelpers(array('Asset'));
      
      if($this->isNew){
          $foto=null;
          $url=null;
      } else {
          $foto = fopen( ProjectConfiguration::caminoIconoEsquema().$this->getObject()->getArchivo(),'r');
          $url=image_path('esquema/'.$this->getObject()->getArchivo() );
      }
      
      $this->widgetSchema ['archivo'] = new FotoWidget ( array (
          'filename' => $this->getObject ()->getNombreOriginal (),
          'mime' => $this->getObject ()->getMime (),
          'foto' => $foto,
          'url' => $url,
          'height' => '150px'
      ) );
      $this->validatorSchema ['archivo'] = new sfValidatorFile ( array (
          'required' => false,//$this->isNew,
          'path' => ProjectConfiguration::caminoIconoEsquema()
          
      ) );
      
  }
  
  
  
  public function updateArchivoColumn(  $f) {
      if (is_null ( $f )) {
          return false;
      }
      
      $this->getObject ()->setNombreOriginal ( $f->getOriginalName () );
      $this->getObject ()->setMime ( $f->getType () );
      
      if( !$this->isNew ){
          unlink(ProjectConfiguration::caminoIconoEsquema().$this->getObject()->getArchivo());
          
      }
      return $f->save();
      
  }
  
}
