$(document).ready(function(){

CanvasJS.addCultureInfo("es",
                {
                    decimalSeparator: ".",
                    digitGroupSeparator: ",",
                    days: ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"],
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
            },

            axisY:[{
                labelFontSize: 12,
                title: "Nivel embalse (m)",
                lineColor: "#FF0000",
                titleFontColor: "#FF0000",
                labelFontColor: "#FF0000"
            }],
            axisY2:[{
                title: "Caudales (m3/s)",
                lineColor: "#7F6084",
                titleFontColor: "#7F6084",
                labelFontColor: "#7F6084"
            }],

            data:  chartData

        };
    if(chartData[0].dataPoints.length>0)    new CanvasJS.Chart("chart", options).render();
    


});
