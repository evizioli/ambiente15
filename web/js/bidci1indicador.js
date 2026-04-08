$(document).ready(function(){

    CanvasJS.addCultureInfo("es",
    {
      decimalSeparator: ".",
      digitGroupSeparator: ",",
      shortMonths: ["ene","feb","mar","abr","may","jun","jul","ago","sep","oct","nov","dic"]
    });
    var options = {
        backgroundColor: "#FAFAF0",
         culture:  "es",
        zoomEnabled: true, 
        zoomType: "xy", 
        legend: {
        },
        axisX:{  
           labelAngle: -90,
            labelFontSize: 12,
           valueFormatString: "DD/MM/YYYY",
            title: "Tiempo (quincena por mess de cada año)",
            interval: 15,
               intervalType: "day",
        },

        axisY:[{
            labelFontSize: 12,
            title: "Abundancia (n° de indivíduos)",
            lineColor: "#FF0000",
            titleFontColor: "#FF0000",
            labelFontColor: "#FF0000"
        }],

        data:  chartData

    };
    if(chartData.length>0)    new CanvasJS.Chart("chart", options).render();
    


});
