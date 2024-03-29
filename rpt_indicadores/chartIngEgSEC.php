<?php

$aleatorio=rand(200,2000);

$codAreaX=$codAreaX;
$anioX=$anioX;
$mesX=$mesX;

?>
<style type="text/css">

#chart-container<?=$aleatorio;?> {
    width: 100%;
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
                console.log("variablesCursos: "+<?=$codAreaX?>+" "+<?=$mesX;?>);
                $.get("dataIngEgSEC.php",
				{codAreaX:<?=$codAreaX;?>,anioX:<?=$anioX;?>,mesX:<?=$mesX?>},
                function (data){
                    var unidad = [];
                    var resultado = [];
                    var resultadoAcum = [];                       
                    for (var i in data) {
						unidad.push(data[i].unidad);
                        resultado.push(data[i].resultado);
                        resultadoAcum.push(data[i].resultadoAcum);   
                    }
                    
                    var ArrayColor1=dynamicColors();
                    var bk1=ArrayColor1[0];
                    var borde1=ArrayColor1[1];
                    var ArrayColor2=dynamicColors();
                    var bk2=ArrayColor2[0];
                    var borde2=ArrayColor2[1];

                    var chartdata = {
                        labels: unidad,
                        datasets: [
                            {
                                label: 'ResultadoMes',
                                backgroundColor: bk1,
                                borderColor: borde1,
                                borderWidth:2,
                                data: resultado
                            },
                            {
                                label: 'ResultadoAcumulado',
                                backgroundColor: bk2,
                                borderColor: borde2,
                                borderWidth:2,
                                data: resultadoAcum
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
