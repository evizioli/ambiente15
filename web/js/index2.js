
var map, sidebar, css={};
var layer_names={
  136: 'Sitios de toma de muestras',
  90: 'Monitoreo de Didymosphenia Geminata'
};
var l_ex={'le': '136', 'didymosphenia_geminata':'90'};

var layer_images={
  136: '../frontend-lugar_extraccion.png',
  90: '../frontend-didymosphenia_geminata.png'
};
var layers_ex={
  136: new ol.layer.Vector( {
                title: layer_names[136],
                visible: false,
                source: new ol.source.Cluster({  
                    distance: 50,
                    source: new ol.source.Vector({
                        url: urltoows+'?service=WFS&version=1.0.0&request=GetFeature&typeName=ambiente:le&maxFeatures=10000000&srsname=EPSG:3857',
                        format: new ol.format.GML2(),
                        attributions: ['Fuente: DGEA-MAyCDS - ']
                    })
                }),  
                style: function(feature, resolution){
                    let size = feature.get('features').length;
                    return new ol.style.Style({
                        image:  new ol.style.Icon({
                            scale:  (1+size/100)*0.8,
                            src: urltofepng.replace('*.png',layer_images[136])
                        }),
                        text: new ol.style.Text({ text: size>1? size.toString():'' })
                    });
                }
              }),
              
              
  90: new ol.layer.Vector( {
                title: layer_names[90],
                visible: false,
                source: new ol.source.Cluster({  
                    distance: 50,
                    source: new ol.source.Vector({
                        url: urltoows+'?service=WFS&version=1.0.0&request=GetFeature&typeName=ambiente:didymosphenia_geminata&maxFeatures=10000000&srsname=EPSG:3857',
                        format: new ol.format.GML2(),
                        attributions: ['Fuente: DGEA-MAyCDS - ']
                    })
                }),  
                style: function(feature, resolution){
                    if(feature.get('features').length==0) return null;

                    let ausente = 0;
                    let presente = 0;
                    $.each(feature.get('features'),function(i,f){
                      if(f.get('didymosphenia_geminata')=='true'){
                        presente++;
                      } else {
                        ausente++;
                      }
                    });
                    let size=presente+ausente;
                    let hex= [
                      Math.round(255*presente/size),
                      Math.round(255*ausente/size),
                      0
                    ];
                    return   new ol.style.Style({
                        image: new ol.style.Circle({
                          radius: 5,
                          stroke: new ol.style.Stroke({
                            color: '#000',
                          }),
                          fill: new ol.style.Fill({
                            color: 'rgba('+hex.join(',')+',1)',
                          }),
                        }),
                        text: new ol.style.Text({
                          text: size>1? size.toString():''
                        }),
                      });
                }
              })
              
              
};

var layer_base={}; 
layer_base[0]=new ol.layer.Tile({
       type: 'base',
       visible: true,
 /*
       source: new ol.source.TileJSON({
        attribtions: '@MapTiler',
        url: 'https://api.maptiler.com/maps/hybrid/tiles.json?key=uLvRn5fsyaw7v26OP7ro'
       }),
       title: 'Maptiler Cloud'
*/
       title: 'Google Maps',
       source: new ol.source.XYZ({
           url: 'http://mt0.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}&s=Ga'
       })
   });


function color2rgb(hex,dep=0.3){
  
  hex=hex.replace(/^([a-f\d])([a-f\d])([a-f\d])$/i
               ,(m, r, g, b) =>  r + r + g + g + b + b)
      .substring(0).match(/.{2}/g)
      .map(x => parseInt(x, 16));
    return 'rgba('+hex.join(',')+',0.2)';
}

function side(nodos){

  var r=[]
  $.each(nodos,function(i,e){
      if(e.nodes!=null){
        r.push(
          new ol.layer.Group({
                        fold: 'close',
                       title: e.nombre,
                       layers:  side(e.nodes)
                    })
        );
      } else if(layers_ex[e.id]) {
         r.push( layers_ex[e.id] );
      } else {
        let l;
        if(e.color==''){
          
          
           l= new ol.layer.Vector( {
               title: e.nombre,
               visible: false,
               source: new ol.source.Cluster({  
                   distance: 50,
                   source: new ol.source.Vector({
                       url: urltoows+'?service=WFS&version=1.0.0&request=GetFeature&typeName=ambiente:gskml&viewParams=eid:'+e.id+'&maxFeatures=10000000',
                       format: new ol.format.GML2(),
                       attributions: ['Fuente: '+e.fuente+' - ']
                   })
               }),  
               style: function(feature, resolution){
                   let size = feature.get('features').length;
                   return new ol.style.Style({
                       image:  new ol.style.Icon({
                           scale:  (1+size/100)*0.8,
                           src: urltofepng.replace('*.png',e.archivo)
                       }),
                       text: new ol.style.Text({ text: size>1? size.toString():'' })
                   });
               }
             });    
        } else {

          l= new ol.layer.Vector( {
              title: e.nombre,
              visible: e.base,
              source: new ol.source.Vector({
                  url: urltoows+'?service=WFS&version=1.0.0&request=GetFeature&typeName=ambiente:gskmlA&viewParams=eid:'+e.id+'&maxFeatures=10000000',
                  format: new ol.format.GML2(),
                  attributions: ['Fuente: '+e.fuente+' - ']
              }),  
              style: function(feature, resolution){
                return new ol.style.Style({
                    stroke:  new ol.style.Stroke({
                      color: '#'+e.color ,
                      width: 1
                    }),
                    fill:  new ol.style.Fill({
//                      color: color2rgb(e.color).push(0.3)
                      color: color2rgb(e.color)
                    }),
                    /*
                    text: new ol.style.Text({ 
                      font: '10px Calibri,sans-serif', 
                      overflow:true,
                      text: feature.get('nombre'),
                      fill: new ol.style.Fill({
                            color: '#000',
                          }),
                          stroke: new ol.style.Stroke({
                            color: '#fff',
                            width: 4,
                          }) 
                    })
                    */
                });
            }
          });
        }
        if(e.base){
          layer_base[e.id]=l;
        } else {
          r.push(l );
        }
        layer_names[e.id]=e.nombre;
        layer_images[e.id]=e.archivo;
      }
  });  
  return r;
}


$(document).ready(  function() {
  
  $.each(document.styleSheets,function(i,e){
    if(e.href) return true;
    if(e.cssRules[0].selectorText.substring(0,8)=='.esquema'){
      $.each(e.cssRules,function(j,r){
        css[r.selectorText]=r.style.backgroundImage
      });
      
      return false;
    }
  });
  
  let layers= side(esquema);
  map = new ol.Map({
        target: 'map',
        controls: ol.control.defaults({ attributionOptions: { collapsible: false } }),
        layers:  $.merge( [
           // capas base
           new ol.layer.Group({
              title: 'División Política',
              layers:  Object.values(layer_base)
  
           })
        ], layers),
            
        view: new ol.View({
              center: ol.proj.fromLonLat([-70, -44]),
              zoom: 7.4
          })
    });
    sidebar = new ol.control.Sidebar({
        element: 'side_bar',
        position: 'left'
    });

    ol.control.LayerSwitcher.renderPanel(map, document.getElementById('layers'), { reverse: false, collapsed : false });
    map.addControl(sidebar);
        
        ///////////////////////////////////////////////////////
        
        
    map.on('singleclick', function (evt) {
        var mostrar=[];

//        $.each(this.getFeaturesAtPixel(evt.pixel,{ checkWrapped: true} ), function(i,e){
        $.each(this.getFeaturesAtPixel(evt.pixel,{ hitTolerance: 3, layerFilter: function(l){
          //alert(l.values_.title) ; 
          return true;
        }} ), function(i,e){
          let tmp=e.get('features');
          if(tmp){
            mostrar=mostrar.concat(e.get('features'));
          } else {
            mostrar.push(e);
          }

        });
        lateral(mostrar);
        
    });

});


function lateral(mostrar){
   if(mostrar.length==0 ){
            sidebar.close();
            $('#datos').empty();
            
        } else {
            o={};
            $.each(mostrar, function(i,f){
                l=f.get('esquema_id');
                if(!l){
                  l=l_ex[f.id_.substring(0,f.id_.indexOf('.'))];
                }
                if( eval('o['+l+']')==undefined ){
                    eval('o['+l+']={ titulo: "'+layer_names[l]+'", features:[] }')
                }
                eval('o['+l+'].features.push(f)');
                
            });
            
            let aux='';min='';
            let b1=true,m1=true,m2=true,m3=true;
            for(x in o) {
                if(layer_base[x]) continue;
                aux+='<img src="'+urltofepng.replace('*.png',layer_images[x])+'"/> '+o[x].titulo+'<dl>';
                
                switch(x){
                        case '64':
                        case '52':
                        case '53':
                        case '54':
                            if(m1){
                                m1=false;
                                min+="\n\n<b>Minería Categoría I</b>\n\nSegún el Código de minería (Ley Nac. N° 1919) – Título 1 – Art. 3: Corresponden a la primera categoría:\n"+
                                    "a) Las sustancias metalíferas siguientes: oro, plata, platino, mercurio, cobre, hierro, plomo, estaño, zinc, níquel, cobalto, bismuto, manganeso, antimonio, wolfram, aluminio, berilio, vanadio, cadmio, tantalio, molibdeno, litio y potasio;\n"+
                                    "b) Los combustibles: hulla, lignito, antracita e hidrocarburos sólidos;\n"+
                                    "c) El arsénico, cuarzo, feldespato, mica, fluorita, fosfatos calizos, azufre, boratos y wollastonita; (Inciso sustituido por art. 1° de la Ley N° 25.225 B.O. 29/12/1999.)\n"+
                                    "d) Las piedras preciosas.\n"+
                                    "e) Los vapores endógenos.";
                            } 
                            break;

                        case '55':
                        case '56':
                            if(m2){
                                m2=false;
                                min+="\n\n<b>Minería Categoría II</b>\n\nSegún el Código de minería (Ley Nac. N° 1919) – Título 1 – Art. 4: Corresponden a la segunda categoría:\n"+
                                    "a) Las arenas metalíferas y piedras preciosas que se encuentran en el lecho de los ríos, aguas corrientes y los placeres.\n"+
                                    "b) Los desmontes, relaves y escoriales de explotaciones anteriores, mientras las minas permanecen sin amparo y los relaves y escoriales de los establecimientos de beneficio abandonados o abiertos, en tanto no los recobre su dueño.\n"+
                                    "c) Los salitres, salinas y turberas.\n"+
                                    "d) Los metales no comprendidos en la primera categoría.\n"+
                                    "e) Las tierras piritosas y aluminosas, abrasivos, ocres, resinas, esteatitas, baritina, caparrosas, grafito, caolín, sales alcalinas o alcalino terrosas, amianto, bentonita, zeolitas o minerales permutantes o permutíticos.";
                            }
                            break;
                        
                        case '57':
                        case '58':
                        case '59':
                        case '60':
                        case '61':
                        case '62':
                        case '63':
                            if(m3){
                                m3=false;
                                min+='\n\n<b>Minería Categoría III</b>\n\nSegún el Código de minería (Ley Nac. N° 1919) – Título 1 – Art. 5: Componen la tercera categoría las producciones minerales de naturaleza pétrea o terrosa, y en general todas las que sirven para materiales de construcción y ornamento, cuyo conjunto forma las canteras.';
                            }
                            break;
                }                    
                
                
                
                for(y in o[x].features){
                    switch(x){

                        case '132':
                        case '133':
                        case '134':
                            
                            if(b1){
                                b1=false;
                                desc='Sectores de muy alto valor de conservación que no deben transformarse. Son los que deben permanecer como bosques para siempre.';
                                aux+='<dt> Categoría I <span style="background-color: red; color: white">(rojo)</span></dt><dd>'+desc.replace(/(?:\r\n|\r|\n)/g, '<br>')+'</dd>';
                                desc='Sectores de mediano valor de conservación. Se trata de zonas que pueden estar degradadas, pero que con adecuadas actividades de restauración pueden tener un valor alto de conservación y ser usados para: aprovechamiento sostenible, turismo, recolección e investigación científica.';
                                aux+='<dt> Categoría II <span style="background-color: yellow; color: black">(amarillo)</span></dt><dd>'+desc.replace(/(?:\r\n|\r|\n)/g, '<br>')+'</dd>';
                                desc='Sectores de bajo valor de conservación que pueden transformarse parcialmente o en su totalidad.';
                                aux+='<dt> Categoría III <span style="background-color: green; color: black">(verde)</span></dt><dd>'+desc.replace(/(?:\r\n|\r|\n)/g, '<br>')+'</dd>';
                            }

                            break;
                        case '135':
//                            aux+='<dt>'+decodeURIComponent(escape(o[x].features[y].properties.get('Nombre')))+'</dt><dd>';
                            aux+='<dt>'+decodeURIComponent(escape(o[x].features[y].properties.Nombre ))+'</dt><dd>';
//                            aux+=decodeURIComponent(escape(o.ANP.features[y].properties.get('Ins_Legal'))).replace(/(?:\r\n|\r|\n)/g, '<br>')+'<br>';
                            aux+=decodeURIComponent(escape(o.ANP.features[y].properties.Ins_Legal )).replace(/(?:\r\n|\r|\n)/g, '<br>')+'<br>';
//                            aux+=decodeURIComponent(escape(o.ANP.features[y].properties.get('Num_Ley'))).replace(/(?:\r\n|\r|\n)/g, '<br>');
                            aux+=decodeURIComponent(escape(o.ANP.features[y].properties.Num_Ley )).replace(/(?:\r\n|\r|\n)/g, '<br>');
                            aux+='</dd>';
                            break;
                        default:
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
                    }
                }
                aux+='</dl>';
            }
            aux+=min.replace(/(?:\r\n|\r|\n)/g, '<br>');
            $('#datos').html(aux);
            sidebar.open('profile');
        }

}

