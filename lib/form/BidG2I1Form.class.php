<?php

/**
 * BidG2I1 form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class BidG2I1Form extends BaseBidG2I1Form
{
  public function configure()
  {
      
      $this->widgetSchema['sitio_id']->setOption('order_by', array(
          'Nombre',
          'asc'
      ));
      $this->widgetSchema['sitio_id']->setOption('add_empty', true);
      $this->widgetSchema['sitio_id']->setAttribute('class', 's2');
//       $this->widgetSchema['sitio_id']->setOption('criteria', BidSitioQuery::create()->filterByAreaProtegida(ProjectConfiguration::PIMCPA));
      $this->widgetSchema['sitio_id']->setOption('query_methods',array(
            'filterByAreaProtegida'=>array(ProjectConfiguration::PIMCPA), 
            'metrosCuadradosPositivo'      
      ));
      $this->widgetSchema->setHelp('sitio_id','Sitios de tipo área en el PIMCPA (es decir polígonos).');
      $this->widgetSchema['ubicacion'] = new MapaWidget(array(
          'height' => '600px'
      ));
      $this->validatorSchema['ubicacion'] = new sfValidatorCallback(array(
          'callback'=>array('Dummy','esPunto')
      ));
    
     $this->mergePostValidator(new BidG1I1FormPostValidator());
  }
  
  public function updateUbicacionColumn($v)
  {
      if (empty($v)) {
          $this->getObject()->setUbicacion(null);
          return $v;
      }
      $r = null;
      try {
          $connection = Propel::getConnection();
          $statement = $connection->prepare('select St_GeomFromText( ? ,3857)  AS latlon ');
          $statement->bindValue(1, $v);
          $statement->execute();
          $resultset = $statement->fetch(PDO::FETCH_OBJ);
          $r = $resultset->latlon;
      } catch (Exception $e) {
          throw $e;
      }
      
      $this->getObject()->setUbicacion($r);
      
      return $v;
  }
}
