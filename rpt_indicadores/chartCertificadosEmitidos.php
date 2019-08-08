<?php

$aleatorio=rand(200,2000);

$anioX=$anioX;
$mesX=$mesX;
$vistaX=$vistaX;

?>
<style type="text/css">

#chart-container<?=$aleatorio;?> {
    width: 60%;
}
</style>

<script type="text/javascript" src="../assets/chartjs/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/Chart.bundle.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/utils.js"></script>


</head>

    <div id="chart-container<?=$aleatorio;?>" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas<?=$aleatorio;?>"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph<?=$aleatorio;?>();
        });
        function showGraph<?=$aleatorio;?>()
        {
            {
                console.log("variablesEmpresasCerti: "+<?=$mesX;?>);
                $.get("dataCertificadosEmitidos.php",
				{anioX:<?=$anioX;?>,mesX:<?=$mesX?>,vistaX:<?=$vistaX;?>},
                function (data){
                    var area = [];
                    var resultado = [];

                    for (var i in data) {
                        area.push(data[i].area);
                        console.log(data[i].area);
                        resultado.push(data[i].resultado);
                    }
                    //alert(labs);
                    var chartdata = {
                        labels: area,
                        datasets: [
                            {
                                label: 'Area.',
                                /*backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,*/
                                data: resultado,
                                backgroundColor: [
                                    "#10EBF2",
                                    "#F27310",
                                    "#8463FF",
                                    "#6384FF",
                                    "#84FF63",
                                    "#FFFF00",
                                    "#FF00FF",
                                    "#800080"
                                ]
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas<?=$aleatorio;?>");

                    var barGraph = new Chart(graphTarget, {
                        type: 'pie',
                        data: chartdata,
                        
                        options: {
                            responsive: true,
                            legend: {
                              position: 'top',
                            },
                            title: {
                              display: false,
                              text: 'Chart.js Doughnut Chart'
                            },
                            animation: {
                              animateScale: true,
                              animateRotate: true
                            },
                            tooltips: {
                              callbacks: {
                                label: function(tooltipItem, data) {
                                    var dataset = data.datasets[tooltipItem.datasetIndex];
                                  var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                    return previousValue + currentValue;
                                  });
                                  var currentValue = dataset.data[tooltipItem.index];
                                  var percentage = Math.floor(((currentValue/total) * 100)+0.5);         
                                  return percentage + "%";
                                }
                              }
                            }
                          }

                    });

                });
            }
        }
        </script>
