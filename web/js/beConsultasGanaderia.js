var map, view;
var layers= [];
var layer_names={
    'Engorde': 'Engorde',
    'Ovinos_Invernada': 'Ovinos Invernada',
    'Bovinos_Invernada': 'Bovinos Invernada',
    //'kml18':'Ganadería',
    //'le': 'Lugares de extracción'
};
var nada='<div style="font-size: larger; text-align: justify; margin-top:10px">En esta pantalla podrá acceder a la visualización de la información de Ganadería por medio de un mapa. Lo primero que observa es el mapa con todas las capas habilitadas. Si desea  limpiar la información podrá sacar la selección en el icono celeste ubicado arriba a la derecha del mapa. '+
'Haciendo clic en los iconos del mapa aparecerán en este sector a la izquierda del mapa, la información asociada a los puntos seleccionados en esa área. Si quiere acceder a información de menos puntos, puede hacer zoom e ir viendo con mayor detalle la información.</div>';

var circulo_negro ;

function initMap() {}

$(document).ready(  function() {

    let l;
    for( x in layer_names){
            l= new ol.layer.Vector({
                title: layer_names[x],
                //source: new ol.source.Cluster({  
                //    distance: 50,
                    source: new ol.source.Vector({
                        url: urltoows+'?service=WFS&version=1.0.0&srsname=EPSG:3857&request=GetFeature&typeName=ambiente:'+x+'&maxFeatures=10000000',
                        format: new ol.format.GML(),
                    })
                //})
                ,  
                style: function(feature, resolution){
                    
                    let size =parseInt(feature.get('TOTAL'));
                    let r,c;
                    let capa =feature.id_.substring(0,feature.id_.indexOf('.'));
                    if( (size<=300 && capa=='Engorde' ) || (size<=1301 && capa=='Ovinos_Invernada' ) || (size<=182 && capa=='Bovinos_Invernada' )    ){
                        r='ganaderia_circulo_negro';
                    } else if(capa=='Bovinos_Invernada' ){
                        if(size<=633) {
                            r=capa+'_'+'1';
                        } else {
                            r=capa+'_'+'2';
                        }
                    } else if(capa=='Ovinos_Invernada' ){
                        if(size<=4992) {
                            r=capa+'_'+'1';
                        } else {
                            r=capa+'_'+'2';
                        }
                    } else  {
                        if(size<=1396) {
                            r=capa+'_'+'1';
                        } else {
                            r=capa+'_'+'2';
                        }
                        
                    }
                    return new ol.style.Style({
                        image:  new ol.style.Icon({
        //                    crossOrigin: 'anonymous',
                            src: urltofepng.replace('*',r)
                        }),
                    });
                }
            });    
      
        //layers[x]=l;
        layers.push(l);
    }
    //////////////////
    layers.push(
        new ol.layer.Vector({
                title: 'Lugares de extracción',
                source: new ol.source.Cluster({  
                    distance: 50,
                    source: new ol.source.Vector({
                        url: urltoows+'?service=WFS&version=1.0.0&srsname=EPSG:3857&request=GetFeature&typeName=ambiente:le&maxFeatures=10000000',
                        format: new ol.format.GML(),
                    })
                }),  
                style: function(feature, resolution){
                    
                    let size = feature.get('features').length;
        
                    return new ol.style.Style({
                        image:  new ol.style.Icon({
    //                                size: [36,30],
                                    scale:  (1+size/100)*0.8,
                //                    crossOrigin: 'anonymous',
                                    src: urltofepng.replace('*','le')
                                }),
                        text: new ol.style.Text({ text: size>1? size.toString():'' })
                    });
                }
            })
    );
    //////////////////
    layers.push(

        new ol.layer.Vector({
            title: 'Canales VIRCH',
            source: new ol.source.Vector({
                url: urltoows+'?service=WFS&version=1.0.0&srsname=EPSG:3857&request=GetFeature&typeName=ambiente:canal&maxFeatures=10000000',
                format: new ol.format.GML(),
            }),  
            style: function(f, resolution){
                let c,w;
                switch(f.get('layer')){
                    case 'Rio Chubut':
                        c='#00aa00';
                        break;
                    case 'Canal Terciario':
                        c='#0000aa';
                        break;
                    case 'Canal Secund':
                        c='#0000cc';
                        break;
                    case 'Canal P N':
                    case 'Canal P S':
                        c='#0000ff';
                        break;
                    case 'Canal Corfo':
                        c='#f00000';
                        break;
                    default:
                        //comunero
                        c='#ff0000';
                };
                switch(f.get('layer')){
                    case 'Rio Chubut':
                        w=3.2;
                        break;
                    case 'Canal Terciario':
                        w=1;
                        break;
                    case 'Canal Secund':
                        w=2;
                        break;
                    case 'Canal P N':
                    case 'Canal P S':
                        w=3;
                        break;
                    case 'Canal Corfo':
                        w=2;
                        break;
                    default:
                        //comunero
                        w=0.8;
                }
                return new ol.style.Style({
                   stroke: new ol.style.Stroke({ color: c, width: w }),
               
                });
            }
        })

    );


    view = new ol.View({
        center: ol.proj.fromLonLat([-65.4, -43.3]),
        zoom: 10.5
    });
    
    map = new ol.Map({
        target: 'map',
        controls: ol.control.defaults({ attributionOptions: { collapsible: false } }),
        layers: [
            // capas base
            new ol.layer.Group({
               'title': 'Capas base',
               layers:  [
                    new ol.layer.Tile({
                        title: 'Google Maps',
                        type: 'base',
                        visible: true,
                        source: new ol.source.XYZ({
                            url: 'http://mt0.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}&s=Ga'
                        })
                    })
               ]
            }),
           new ol.layer.Group({
               'title': 'Ganadería',
               layers:  layers
            }),
        ],
        view: view,
//        overlays: [overlay]
        
    });
    
//    ol.control.LayerSwitcher.renderPanel(map, document.getElementById('layers'), { reverse: false, collapsed : true });
  
            var layerSwitcher = new ol.control.LayerSwitcher({
                tipLabel: 'Leyenda'
            });
            map.addControl(layerSwitcher);
            layerSwitcher.showPanel();      
        
        ///////////////////////////////////////////////////////
        
        
    map.on('singleclick', function (evt) {
        
        
        var mostrar=this.getFeaturesAtPixel(evt.pixel,{ checkWrapped: true} );
        lateral(mostrar);
        
    });
    $('#datos').html(nada);

});

function lateral(mostrar){
   if(mostrar.length==0 ){
            $('#datos').html(nada);
            
        } else {
            o={};
            $.each(mostrar, function(i,f){
                l=f.id_.substring(0,f.id_.indexOf('.'));
                if( eval('o.'+l)==undefined ){
                    if(layer_names[l]){
                        eval('o.'+l+'={ titulo: "'+layer_names[l]+'", features:[] }')
                    } else {
                        eval('o.'+l+'={ titulo: "Canales", features:[] }')
                    }
                }
                eval('o.'+l+'.features.push(f)');
                
            });
            
            let aux='';min='';
            let b1=true,m1=true,m2=true,m3=true;
            for(x in o) {
                
//                aux+='<img src="'+urltofepng.replace('*',x)+'"/> '+o[x].titulo+'<dl>';
                aux+='<dl>';
                
                
                for(y in o[x].features){
                    switch(x){
                        case 'canal':
                            aux+='<dt>'+o[x].features[y].get('nombre')+'</dt><dd>';
                            aux+=o[x].features[y].get('layer').replace(/(?:\r\n|\r|\n)/g, '<br>');
                            aux+='</dd>';
                            break;
                        case 'le':
                        case 'kml18':
                            if(o[x].features[y] instanceof ol.Feature){
                                aux+='<dt>'+o[x].features[y].get('nombre')+'</dt><dd>';
                                if(o[x].features[y].get('descripcion')){
                                    aux+=o[x].features[y].get('descripcion').replace(/(?:\r\n|\r|\n)/g, '<br>');
                                } else {
                                    aux+='&nbsp;'
                                }
                            } else {
                                aux+='<dt>'+o[x].features[y].properties.nombre+'</dt><dd>';
                                if(o[x].features[y].properties.descripcion){
                                    aux+=o[x].features[y].properties.descripcion.replace(/(?:\r\n|\r|\n)/g, '<br>');
                                } else {
                                    aux+='&nbsp;'
                                }
                            }
                            aux+='</dd>';
                            break;
                        default:
                            let size=parseInt(o[x].features[y].get('TOTAL'));
                            if( (size<=300 && x=='Engorde' ) || (size<=1301 && x=='Ovinos_Invernada' ) || (size<=182 && x=='Bovinos_Invernada' )    ){
                                r='ganaderia_circulo_negro';
                            } else if(x=='Bovinos_Invernada' ){
                                if(size<=633) {
                                    r=x+'_'+'1';
                                } else {
                                    r=x+'_'+'2';
                                }
                            } else if(x=='Ovinos_Invernada' ){
                                if(size<=4992) {
                                    r=x+'_'+'1';
                                } else {
                                    r=x+'_'+'2';
                                }
                            } else  {
                                if(size<=1396) {
                                    r=x+'_'+'1';
                                } else {
                                    r=x+'_'+'2';
                                }
                                
                            }
                            aux+='<dt><img src="'+urltofepng.replace('*',r)+'"/>  Especie: '+o[x].features[y].get('ESPECIE')+', RENSPA: '+o[x].features[y].get('RENSPA')+', cantidad: '+parseInt(o[x].features[y].get('TOTAL'))+'</dt><dd>';
                            aux+=ol.coordinate.toStringHDMS(o[x].features[y].getGeometry().clone().transform('EPSG:3857','EPSG:4326').getCoordinates())+'<br>';
                            aux+='</dd>';
                    }
                }
                aux+='</dl>';
            }
            aux+=min.replace(/(?:\r\n|\r|\n)/g, '<br>');
            $('#datos').html(aux);
        }

}

