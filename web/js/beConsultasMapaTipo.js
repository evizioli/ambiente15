var map, wfs, estas;


$(document).ready(function(){
  wfs=  new ol.layer.Vector( {
    title: "Lugares de extracción",
    source: new ol.source.Cluster({  
        distance: 30,
        source: new ol.source.Vector({
            url: urltoows+'?service=WFS&version=1.0.0&request=GetFeature&typeName=ambiente:le&maxFeatures=10000000',
            format: new ol.format.GML2()
        })
    }),  
    
    style: function(feature, resolution){
        let size = feature.get('features').length;
        var t;
        if( feature.get('features') ){
            $.each( feature.get('features'),function(i,e){
                if(t==undefined) {
                    t=e.get('tipo_id');
                } else  if(t!=e.get('tipo_id')){
                    t='17';
                    return false;
                }
            });
        } else {
            t=feature.get('tipo_id');
        }
        return new ol.style.Style({
            image:  new ol.style.Icon({
                scale:   0.05  +0.015*  feature.get('features').length,
                src:  urltogota+iconos[  t ]
                    
            }),
            text: new ol.style.Text({ text: size>1? size.toString():'' })
        });
    }
    
  });


    map = new ol.Map({
        target: 'map',
        controls: ol.control.defaults({ attributionOptions: { collapsible: false } }),
        layers: [
          new ol.layer.Tile({
                 type: 'base',
                 visible: true,
                 title: 'Google Maps',
                 source: new ol.source.XYZ({
                     url: 'http://mt0.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}&s=Ga'
                 })
             }),
             wfs
        ],
            
        view: new ol.View({
              center: [-7550000,-5450000],
              zoom: 7
          })
    });
/*
  
    
	wfs = new OpenLayers.Layer.Vector("Lugares de extracción", {
	    eventListeners: OpenLayers.Util.extend({scope: wfs}, { 
                featureclick: function(evt) { ver_muestras(evt); },
                nofeatureclick: function(evt) { estas=[]; traer(); } 
            } ), 
	});

	*/

  map.on('singleclick', function (evt) {
      
    ver_muestras(evt);
      
  });
  
});


/*
function capas_base(){

	gsat = new OpenLayers.Layer.Google(
	        "Google Satellite",
	        { type: google.maps.MapTypeId.SATELLITE, numZoomLevels: 22  }
    );
	gmap = new OpenLayers.Layer.Google(
			"Google Streets", // the default
			{numZoomLevels: 20 }
	);
	gphy = new OpenLayers.Layer.Google(
	        "Google Physical",
	        {type: google.maps.MapTypeId.TERRAIN }
    );
	ghyb = new OpenLayers.Layer.Google(
	        "Google Hybrid",
	        {type: google.maps.MapTypeId.HYBRID, numZoomLevels: 22 }
    );
 	osm = new OpenLayers.Layer.OSM(
 	    	null,null,
 	    	{
 	    		displayInLayerSwitcher: true
 	    	}, 
 	    	{
 	    		singleTile: true, 
 	    		visibility: true, 
 	    		isBaseLayer: true
 	    	}
    );
 	bing = new OpenLayers.Layer.Bing(
 			{
 				name: "Bing Aerial con etiquetas",
 				type: "AerialWithLabels",
 				culture: "es-AR",
 				key: "AsFGe0EMQW2tLlITXUELJd7GpcDJbE1zzFn_e7vC0vO_Sd557pHtTPUDZ8mCeaFU"
 			},
 			{
 				displayInLayerSwitcher: true
 			}, 
 			{
 				singleTile: true, 
 				visibility: true, 
 				isBaseLayer: true
 			}
 	);
 	broad = new OpenLayers.Layer.Bing(
 			{
 				name: "Bing Rutas",
 				type: "Road",
 				culture: "es-AR",
 				key: "AsFGe0EMQW2tLlITXUELJd7GpcDJbE1zzFn_e7vC0vO_Sd557pHtTPUDZ8mCeaFU"
 			},
 			{
 				displayInLayerSwitcher: true
 			}, 
 			{
 				singleTile: true, 
 				visibility: true, 
 				isBaseLayer: true
 			}
 	);
	return [ gsat, gmap, gphy, ghyb, bing, broad, osm  ];
}
*/
function traer(){
    $.ajax({
      url: urlmuestrasajax,
      data: { id: estas, uso: $('#uso').val() }
    
    }).done(function( resp ) {
        $('#tocar').html(resp.data ); 
        $('#bacteriologicos').html(resp.bact ); 

        var row;
        var columns = [
            {
                field: 'field0',
                title: 'Fecha'
            }
        ];
        var data = [];
        var ids = resp.ids;
    
        $.each(resp.resultado,function(i,e){ 
            
            row = {};
            row['field0']=  e.var;
            var cont=1; 
            $.each(e.values,function(j,m){
                if(!columns[cont]){
                    columns.push({
                        field: 'field' + cont,
                        title: m.valor +  ' <a href="'+urlToPrint+'?id='+ids[j]+'" title="Imprimir Protocolo" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>'
                    });
                                
                }
                row['field'+cont]= m.rojo ? '<span class="mal">'+m.valor+'</span>' :  m.valor; 
                cont++;
            });
            if(i==0) return true;
            data.push(row);
        });
        $('#tdata').bootstrapTable({
          height: true ? 950 : undefined,
          columns: columns,
          data: data,
          showColumns: false,
          fixedColumns: true,
          fixedNumber: 1,
        });
    });

}

function ver_muestras(evt) {
    estas=[];
    wfs.getFeatures(evt.pixel).then(function (features) {
      $.each(features[0].get('features'),function(i,e){
        
         estas.push(e.get('id'));
      })
        if(estas.length>0)  traer();
    });
}

function centrar(lid) {
    estas=[lid];
    traer();
    $.each(wfs.getSource().getFeatures(),function(i,f){
      $.each(f.get('features'),function(j,ff){
        
        if(ff.get('id')==lid){
          map.getView().setCenter(ff.getGeometry().getCoordinates());
          map.getView().setZoom(15)
          return false;
        }
      });
    });
    /*
    for(x in wfs.strategies[1].features) { 
        if(wfs.strategies[1].features[x].fid=='lugar_extraccion.'+lid) {  
		    map.setCenter(new OpenLayers.LonLat(wfs.strategies[1].features[x].geometry.components[0].x ,wfs.strategies[1].features[x].geometry.components[0].y),15);
            break;  
        }
    }
    */
}
