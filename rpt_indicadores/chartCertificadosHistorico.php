<?php

$aleatorio=rand(200,2000);

$anioX=$anioX;
$mesX=$mesX;
$vistaX=$vistaX;

?>
<style type="text/css">

#chart-container<?=$aleatorio;?> {
    width: 70%;
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
                console.log("certi historicos: "+<?=$mesX;?>);
                $.get("dataCertificadosHistorico.php",
				{anioX:<?=$anioX;?>,mesX:<?=$mesX?>,vistaX:<?=$vistaX;?>},
                function (data){
                    var anio = [];
                    var tcp = [];
                    var tcs = [];                       
                    for (var i in data) {
						anio.push(data[i].anio);
                        tcp.push(data[i].tcp);
                        tcs.push(data[i].tcs);   
                    }
                    
                    var ArrayColor1=dynamicColors();
                    var bk1=ArrayColor1[0];
                    var borde1=ArrayColor1[1];
                    var ArrayColor2=dynamicColors();
                    var bk2=ArrayColor2[0];
                    var borde2=ArrayColor2[1];

                    var chartdata = {
                        labels: anio,
                        datasets: [
                            {
                                label: 'TCP',
                                backgroundColor: bk1,
                                borderColor: borde1,
                                borderWidth:2,
                                data: tcp
                            },
                            {
                                label: 'TCS',
                                backgroundColor: bk2,
                                borderColor: borde2,
                                borderWidth:2,
                                data: tcs
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas<?=$aleatorio;?>");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata,
						options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });

                });
            }
        }
        </script>
