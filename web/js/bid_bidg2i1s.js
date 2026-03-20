var wkt = new ol.format.WKT();

$(document).ready(  function() {
  

  source=  new ol.source.Vector({
      format: new ol.format.GML(),
  });      
  source2=  new ol.source.Vector({
    format: new ol.format.GML(),
  });
  map = new ol.Map({
        target: 'mapa',
        controls: ol.control.defaults({ attributionOptions: { collapsible: false } }),
        layers:   [
          new ol.layer.Tile({
               type: 'base',
               visible: true,
               title: 'Google Maps',
               source: new ol.source.XYZ({
                   url: 'https://mt0.google.com/vt/lyrs=s&hl=en&x={x}&y={y}&z={z}&s=Ga'
               })
          }),
          
          
          new ol.layer.Vector({
                          title: '',
                          source: new ol.source.Cluster({  
                              distance: 50,
                              source: source
                          }),  
                          style: function(feature ){
                              
                              let size = feature.get('features').length;
                  
                              return new ol.style.Style({
                                  image:  new ol.style.Icon({
              //                                size: [36,30],
                                              scale:  (1+size/100)*0.4,
                          //                    crossOrigin: 'anonymous',
//                                              src: urltofepng.replace('*','le')
                                              src: urltofepng
                                          }),
                                  text: new ol.style.Text({ text: size>1? size.toString():'' })
                              });
                          }
                      }),
          
          
          new ol.layer.Vector({
                          title: '',
                          source: source2,
                          /*  
                          style: function(feature ){
                              
                              let size = feature.get('features').length;
                  
                              return new ol.style.Style({
                                  image:  new ol.style.Icon({
              //                                size: [36,30],
                                              scale:  (1+size/100)*0.4,
                          //                    crossOrigin: 'anonymous',
//                                              src: urltofepng.replace('*','le')
                                              src: urltofepng
                                          }),
                                  text: new ol.style.Text({ text: size>1? size.toString():'' })
                              });
                          }
                          */
                      })
          
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([-67.7, -44]),
          zoom: 6
        })
    });
    
    if(features.length>0) {
      source.addFeatures(features.map(a => wkt.readFeature(a)));
    }

    if(features2.length>0) {
      source2.addFeatures(features2.map(a => wkt.readFeature(a)));
    }


    var totalExtent = ol.extent.createEmpty();
      var hasContent = false;
      map.getLayers().forEach(function(layer) {
          // Solo procesamos capas vectoriales que tengan una fuente con datos
          if (layer instanceof ol.layer.Vector) {
            const source = layer.getSource();
            const extent = source.getExtent();
            
            // Verificar que el extent sea válido y no esté vacío
            if (extent && extent[0] !== Infinity) {
              ol.extent.extend(totalExtent, extent);
              hasContent = true;
            }
          }
        });
    if(hasContent) {
      source.addFeatures(features.map(a => wkt.readFeature(a)));
      map.getView().fit(totalExtent , {
          maxZoom: 9, 
          padding: [30, 30, 30, 30]
        });
    }

});

