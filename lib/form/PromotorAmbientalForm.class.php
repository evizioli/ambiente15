<?php

/**
 * PromotorAmbiental form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class PromotorAmbientalForm extends BasePromotorAmbientalForm
{
  public function configure()
  {
      $this->widgetSchema ['the_geom'] = new MapaWidget ( array (
          'height' => '600px'
      ) );
      $this->widgetSchema->setLabel('the_geom','Ubicación');
      
      unset($this['foto'],$this['mime'],$this['nombre_original']);
      
      $this->widgetSchema ['foto'] = new FotoWidget ( array (
          'filename' => $this->getObject ()->getNombreOriginal (),
          'mime' => $this->getObject ()->getMime (),
          'foto' => $this->getObject ()->getFoto(),
          'url' => sfContext::getInstance ()->getController ()->genUrl ( 'promotores/foto?id=' . $this->getObject ()->getId () ),
          'height' => '300px'
      ) );
      $this->validatorSchema ['foto'] = new sfValidatorFile ( array (
          'required' => $this->isNew
      ) );
  }
  
  public function updateFotoColumn($f) {
      if (is_null ( $f )) {
          return false;
      }
      $this->getObject ()->setNombreOriginal ( $f->getOriginalName () );
      $this->getObject ()->setMime ( $f->getType () );
//       if( in_array($f->getType (), array( 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/gif' ))) {
//           try {
//               $thumbnail = new sfThumbnail(300,300);
//               $thumbnail->loadFile(  $f->getTempName () );
//               return $thumbnail->toString();
              
//           } catch (Exception $e) {
              
//           }
//       }
      return file_get_contents ( $f->getTempName () );
      
  }
  
  public function updateTheGeomColumn($v) {
      if (empty ( $v )) {
          $this->getObject ()->setTheGeom ( null );
          return $v;
      }
      $r = null;
      try {
          $connection = Propel::getConnection ();
          $statement = $connection->prepare ( 'select St_GeomFromText( ? ,3857)  AS latlon ' );
          $statement->bindValue ( 1, $v );
          $statement->execute ();
          $resultset = $statement->fetch ( PDO::FETCH_OBJ );
          $r = $resultset->latlon;
      } catch ( Exception $e ) {
          throw $e;
      }
      
      $this->getObject ()->setTheGeom ( $r );
      
      return $v;
  }
  
}
