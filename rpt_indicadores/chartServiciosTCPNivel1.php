<?php

$aleatorio=rand(200,2000);

$codAreaX=$codAreaX;
$anioX=$anioX;
$mesX=$mesX;

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
                console.log("variablesTCP: "+<?=$codAreaX?>+" "+<?=$mesX;?>);
                $.get("dataServiciosTCPNivel1.php",
				{codAreaX:<?=$codAreaX;?>,anioX:<?=$anioX;?>,mesX:<?=$mesX?>},
                function (data){
                    var servicio = [];
                    var montomes = [];
                    var montoacum = [];                       
                    for (var i in data) {
						servicio.push(data[i].servicio);
                        montomes.push(data[i].montomes);
                        montoacum.push(data[i].montoacum);   
                    }
                    
                    var ArrayColor1=dynamicColors();
                    var bk1=ArrayColor1[0];
                    var borde1=ArrayColor1[1];
                    var ArrayColor2=dynamicColors();
                    var bk2=ArrayColor2[0];
                    var borde2=ArrayColor2[1];

                    var chartdata = {
                        labels: servicio,
                        datasets: [
                            {
                                label: 'MontoMes',
                                backgroundColor: bk1,
                                borderColor: borde1,
                                borderWidth:2,
                                data: montomes
                            },
                            {
                                label: 'MontoAcumulado',
                                backgroundColor: bk2,
                                borderColor: borde2,
                                borderWidth:2,
                                data: montoacum
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas<?=$aleatorio;?>");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
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
