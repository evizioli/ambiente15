OpenLayers.Lang.setCode('es');
OpenLayers.ProxyHost = "proxy.cgi?url=";

var map, osm, gsat, gphy, gmap, ghyb, broad, bing,  wfs, wms, canales;


$(document).ready(function(){

	map = new OpenLayers.Map('map',{
		controls: [ 
            new OpenLayers.Control.TouchNavigation({
                dragPanOptions: {
                    enableKinetic: true
                }
            }),
            new OpenLayers.Control.Zoom(), 
            new OpenLayers.Control.LayerSwitcher(), 
            new OpenLayers.Control.MousePosition(), 
            new OpenLayers.Control.Navigation()
        ],
		projection: "EPSG:3857",
	});			
	
	var context = {
	        getSize: function(feature){
	            var s = 8;
	            if(feature.cluster) {
                     s =  s +1.2* feature.cluster.length;
	            }
	            return s;
	        },
	        label: function(feature) {
        // clustered features count or blank if feature is not a cluster
        return feature.cluster ? feature.cluster.length : "";  
      }
	        
	    };
	    
	    
	stylemap = new OpenLayers.StyleMap({
        'default': new OpenLayers.Style({
            label: "${label}",
            pointRadius: "${getSize}",
            externalGraphic: urltogota
        }, {
	            context: context
	    })
    });
    
	    
	wfs = new OpenLayers.Layer.Vector("Lugares de extracción", {
		styleMap: stylemap,
		strategies: [new OpenLayers.Strategy.BBOX(), new OpenLayers.Strategy.Cluster({ distance: 30, threshold: 2 })],
        protocol: new OpenLayers.Protocol.WFS({
			url: urltoows+'?service=WFS&version=1.0.0&request=GetFeature&typeName=ambiente:lugar_extraccion&maxFeatures=10000000',
			featureType: "lugar_extraccion",
		}),
		renderers: OpenLayers.Layer.Vector.prototype.renderers
	});

    canales = new OpenLayers.Layer.WMS(
            'Canales',
            urltowms, {
                    layers: "ambiente:canal",
                    srs: 'EPSG:22183',
                    transparent: true,
                    format: "image/png",
                    tiled:false
                }, {
                    isBaseLayer: false,
                    buffer: 0,
                    displayInLayerSwitcher: true,
                    visibility: true,
                    yx : {'EPSG:22183' : true}
                }
            );
    wms = new OpenLayers.Layer.WMS(
            'Lugares de tomas de muestras',
            urltowms, {
                    layers: "ambiente:lugar_extraccion",
                    srs: 'EPSG:3857',
                    transparent: true,
                    format: "image/png",
                    tiled:false
                }, {
                    isBaseLayer: false,
                    buffer: 0,
                    displayInLayerSwitcher: false,
                    visibility: false,
//                    yx : {'EPSG:22183' : true}
                }
            );


	
	////////////////////

	map.addLayers(capas_base().concat([ wfs, canales ]));
	
	map.setCenter(new OpenLayers.LonLat(-7290000,-5360000), 11);
	
    info = new OpenLayers.Control.WMSGetFeatureInfo({ 
        url: urltowms, 
        queryVisible: false,
        
        layers: [wms, canales],           
        eventListeners: { 
            getfeatureinfo: function(evt) { 
                $.each(map.popups,function(i){
                    map.removePopup(this);
                });
                map.addPopup(new OpenLayers.Popup.FramedCloud( 
                    "info", 
                    map.getLonLatFromPixel(evt.xy), 
                    null, 
                    evt.text, 
                    null, 
                    true 
                )); 
            },
            
       
        } 
    }); 
    map.addControl(info); 
    info.activate();
    
	
	

});



function capas_base(){

	gsat = new OpenLayers.Layer.Google(
	        "Google Satellite",
	        { type: google.maps.MapTypeId.SATELLITE, numZoomLevels: 22, visibility: false }
	    );
	gmap = new OpenLayers.Layer.Google(
			"Google Streets", // the default
			{numZoomLevels: 20 , visibility: false}
	);
	gphy = new OpenLayers.Layer.Google(
	        "Google Physical",
	        {type: google.maps.MapTypeId.TERRAIN, visibility: false}
	    );
	ghyb = new OpenLayers.Layer.Google(
	        "Google Hybrid",
	        {type: google.maps.MapTypeId.HYBRID, numZoomLevels: 22, visibility: false}
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
 				//uriScheme: "https",
 				
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
