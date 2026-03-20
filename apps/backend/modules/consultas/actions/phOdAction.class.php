<?php
class phOdAction extends   sfAction {
    
    public function execute( $request) {
        
        $kml = simplexml_load_file( '/home/enrique/git/ambiente/data/OTBN.kml' );
        
        foreach($kml->Document as $que){
            foreach($que as $type=>$folder){
                if($folder->name=='OTBN' && $type=='Folder'){
                    foreach ($folder->Placemark as  $ps){
                         $ps->addChild('styleUrl','#stOTBN'.$ps->ExtendedData->SchemaData->SimpleData[1]);
                    }
                }
            }
        }
        $kml->asXML('/home/enrique/git/ambiente/cache/OTBN.kml');
        die('ok');
    }
}