<?php

/**
 * Kml form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class KmlForm extends BaseKmlForm
{
  public function configure()
  {
      $this->useFields(array('nombre', 'esquema_id',  'descripcion', 'the_geom'));
//       $this->widgetSchema['tipo']= new sfWidgetFormChoice(array('choices'=>array(''=>'')+KmlPeer::$tipos));
//       $this->validatorSchema['tipo']= new sfValidatorChoice(array('choices'=>array_keys(KmlPeer::$tipos)));
      $this->widgetSchema['tipo']= new sfWidgetFormInputHidden();
      $this->validatorSchema['tipo']= new sfValidatorPass( array('required'=>false, 'empty_value'=>0));
      
      $this->widgetSchema ['the_geom'] = new MapaWidget ( array (
          'height' => '600px'
      ) );
      
      
      $this->widgetSchema['esquema_id']->setOption('order_by', array('Nombre','asc'));
      $this->widgetSchema['esquema_id']->setAttribute('class', 's2');
      
      $this->widgetSchema->setLabel('the_geom','Ubicación');
      
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
