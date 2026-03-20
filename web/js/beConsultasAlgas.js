$(document).ready(function(){
    var row
    var columns = [
        {
            field: 'field0',
            title: 'Fecha'
        }
    ];
    var data = [];
    $.each(resp,function(i,e){ 
        row = {};
        row['field0']=  e.var;
        var cont=1; 
        $.each(e.values,function(j,m){
            if(!columns[cont]){
                columns.push({
                    field: 'field' + cont,
//                    title: m.valor +  ' <a href="'+urlToPrint+'?id='+ids[j]+'" title="Imprimir Protocolo" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>'
                    title: m.valor 
                });
                            
            }
            row['field'+cont]= m.rojo ? '<span class="mal">'+m.valor+'</span>' :  m.valor; 
            
            cont++;
        });
        if(i==0) return true;
        data.push(row);
    });

    $('#tdata').bootstrapTable({
      height: false ? 610 : undefined,
      columns: columns,
      data: data,
      showColumns: false,
      fixedColumns: true,
      fixedNumber: 1,
    });
    if(chartData.length>0)   {     
        var options = {
           backgroundColor: "#FAFAF0",
            dataPointMinWidth: 5,
            legend: {
                fontSize: 12
            },
            axisX:{  
                labelFontSize: 12,
                valueFormatString: "DD/MM/YYYY",
            },
    
            axisY: {
            
                labelFontSize: 12,
                valueFormatString: "0#",
                title: "Cantidad de taxa",
            },
    
            data:[{
                type: "line",
                showInLegend: false,
                dataPoints: chartData
            }]
             
        };
        new CanvasJS.Chart("chart", options).render();
    }
    
    
});