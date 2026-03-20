<?php

/**
 * TipoMuestra form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class TipoMuestraForm extends BaseTipoMuestraForm
{
  public function configure()
  {
      unset($this['mime'],$this['nombre_original']);
      
      sfContext::getInstance()->getConfiguration()->loadHelpers(array('Asset'));
      
      if($this->isNew){
          $foto=null;
          $url=null;
      } else {
          $foto = fopen( ProjectConfiguration::caminoIconoTipoMuesta().$this->getObject()->getArchivo(),'r');
          $url=image_path('tipo-muestra/'.$this->getObject()->getArchivo() );
      }
      
      $this->widgetSchema ['archivo'] = new FotoWidget ( array (
          'filename' => $this->getObject ()->getNombreOriginal (),
          'mime' => $this->getObject ()->getMime (),
          'foto' => $foto,
          'url' => $url,
          'height' => '150px'
      ) );
      $this->validatorSchema ['archivo'] = new sfValidatorFile ( array (
          'required' => $this->isNew,
          'path' => ProjectConfiguration::caminoIconoTipoMuesta()
      ) );
      
      
  }
  
  
  public function updateArchivoColumn( $f) {
      if (is_null ( $f )) {
          return false;
      }
      
      $this->getObject ()->setNombreOriginal ( $f->getOriginalName () );
      $this->getObject ()->setMime ( $f->getType () );
      
      if( !$this->isNew ){
          unlink(ProjectConfiguration::caminoIconoTipoMuesta().$this->getObject()->getArchivo());
          
      }
      return $f->save();
      
  }
  
}
