<?php

require_once __DIR__.'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
    
    //const GM_API_KEY = "AIzaSyB9XxgCWXqMU0hjvpxg7JExufjWvsSB4a4";  //ambiente
    const GM_API_KEY = "AIzaSyCvvhNpCXPXrrcoc5u8HrEpMsW7nLqh7Y0";  //riego
    
    const EMAIL = 'sistema.ambiente.chubut@gmail.com';
    //	const EMAIL = 'comunicacion.ambiente@chubut.gov.ar';
    
    
    const NOMBRE_ENTIDAD= 'Secretaría de Ambiente y Control del Desarrollo Sustentable';
    
  public function setup()
  {
//     $this->enablePlugins('sfDoctrinePlugin');
    //setup the location for our phing and propel libs
      sfConfig::set('sf_phing_path', sfConfig::get('sf_root_dir').'/plugins/sfPropelORMPlugin/lib/vendor/phing/');
      sfConfig::set('sf_propel_path', sfConfig::get('sf_root_dir').'/plugins/sfPropelORMPlugin/lib/vendor/propel/');
      sfConfig::set('sf_propel_generator_path', sfConfig::get('sf_root_dir').'/plugins/sfPropelORMPlugin/lib/vendor/propel/generator/lib/');
      
      $this->enablePlugins('comunPlugin',
          'sfTCPDFPlugin',
          'sfPropelORMPlugin',
          'sfWebBrowserPlugin'
          );
  }
  
  static public function options(){
      return array(
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => array(
          //               'Authentication: bearer '.ProjectConfiguration::SMART_TKN,
          //               'User-Agent: spia.chubut.gov.ar (eavizioli@gmail.com)',
          //               'Content-type: application/json; charset=utf-8',
              
              'Authorization: Basic ' . base64_encode( ProjectConfiguration::SMART_USR .":". ProjectConfiguration::SMART_PWD),
              'Accept: application/json',
          ),
          
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_SSL_VERIFYPEER=> false
      );
  }
  
  private static function caminoTutorial($cual)
  {
      return sfConfig::get('sf_root_dir')."/data/Tutorial-SPIA-$cual.pdf";
  }
  
  public static function caminoTutorialConsulta()
  {
      return self::caminoTutorial('consulta');
  }
  
  public static function caminoTutorialAcceso()
  {
      return self::caminoTutorial('acceso');
  }
  
  
  public static function caminoTutorialMuni()
  {
      return self::caminoTutorial('muni');
  }
  
  const DIRECTORIO_TIPO_MUESTRA="images/tipo-muestra";
  const DIRECTORIO_ESQUEMA="images/esquema";
  
  
  public static function caminoIconoTipoMuesta()
  {
      return sfConfig::get('sf_web_dir').'/'.self::DIRECTORIO_TIPO_MUESTRA.'/';
  }
  public static function caminoIconoEsquema()
  {
      return sfConfig::get('sf_web_dir').'/'.self::DIRECTORIO_ESQUEMA.'/';
  }
  /**
   * devuelve la constante self::SMART_APV sin guines. Con el parámetro $guines en true devuelve la constante con los guiones como se usa para la url de la api de smart
   * @param boolean $guiones
   * @return string|array
   *
   */
  public static function SMART_APV($guiones=false)
  {
      return $guiones ? str_ireplace('-', '', self::SMART_APV): self::SMART_APV;
  }
  
  const SMART_TKN= '405e0620-02e7-4689-b0fe-9a93c1509d96';
  const SMART_USR= 'enrique.vizioli';
  const SMART_PWD= 'wcs12345';
  //   const SMART_URL= 'https://wcshealth.smartconservationtools.org/server/api/';
  const SMART_URL= 'https://wcsargentinaconnect.smartconservationtools.org:8443/server/api/';
  //   const SMART_APV= 'fedde9bd-f960-4a7e-817e-b545c01731f8';
  //de un momento a otro dejó de tener guiones
  const SMART_APV= 'fedde9bdf9604a7e817eb545c01731f8';
  
  
  
  
  const PIMCPA='PIMCPA';
  const ANPPV='ANPPV';
  public static $areas=array(
      self::ANPPV=>'Área Nacional Protegida Península Valdés',
      self::PIMCPA=>'Parque Interjurisdiccional Marino Costero Patagonia Austral',
  );
  
}
