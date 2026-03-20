<?php

class smartTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'smart';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [smart|INFO] task does things.
Call it with:

  [php symfony smart|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $ch = curl_init();
    curl_setopt_array($ch, ProjectConfiguration::options() + array( CURLOPT_CUSTOMREQUEST => "GET" ));
    curl_setopt($ch, CURLOPT_URL, ProjectConfiguration::SMART_URL.sprintf( '/metadata/mission/%s', ProjectConfiguration::SMART_APV));
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        print_r( $response);
    }
    curl_close($ch);
    die();
    
  }
}
