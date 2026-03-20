<?php
class FotoWidget extends sfWidgetFormInputFile {
    
    public static $imgs =array(
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/x-png',
        'image/gif',
    );
    
    protected function configure($options = array(), $attributes = array())
    {
        parent::configure($options, $attributes);
        
        $this->addOption('mime',null);
        $this->addOption('filename',null);
        $this->addOption('height','20px');
        $this->addOption('foto',null);
        $this->addOption('url',false);
    }
    
    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        $attributes = array_merge(array('onchange'=>'readURL(event.target);'),$attributes);
        
        
        
        if( is_resource($value) && get_resource_type($value)=='stream' ){
            $stream = $value;
        } elseif ( is_resource( $this->getOption('foto')) && get_resource_type( $this->getOption('foto') )=='stream' ) {
            $stream = $this->getOption('foto');
        } else {
            $stream =null;
        }
        
        if( $stream &&  !( is_null( $this->getOption('filename') ) || is_null( $this->getOption('mime') ) ) ) {
            
            if( in_array($this->getOption('mime'),self::$imgs) ) {
                
                $src='data:'.$this->getOption('mime').';base64,'.base64_encode ( stream_get_contents ( $stream ) );
                
                $f=sprintf('<a target="_blank" %s><img height="%s" id="%s_foto" src="%s" title="%s"/></a><br>',
                    $this->getOption('url') ? 'href="'.$this->getOption('url') .'"' : '',
                    $this->getOption('height'),
                    $this->generateId($name),
                    $src,
                    $this->getOption('filename')
                    );
            } else {
                $f=sprintf('<a target="_blank" %s>%s</a><br>',
                    $this->getOption('url') ? 'href="'.$this->getOption('url') .'"' : '',
                    $this->getOption('filename')
                    );
            }
        } else {
            $f='';
        }
        
        return $f.parent::render($name,null,$attributes,$errors);
    }
    
    public function getJavascripts()
    {
        return array('FotoWidget.js');
    }
    
}