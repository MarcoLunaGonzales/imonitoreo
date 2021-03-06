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
                $.get("dataCursosTipo.php",
				{codAreaX:<?=$codAreaX;?>,anioX:<?=$anioX;?>,mesX:<?=$mesX?>},
                function (data){
                    var unidad = [];
                    var curso1 = [];
                    var curso2 = [];                       
                    var curso3 = [];
                    var curso4 = [];                       
                    for (var i in data) {
						unidad.push(data[i].unidad);
                        curso1.push(data[i].curso1);
                        curso2.push(data[i].curso2);   
                        curso3.push(data[i].curso3);
                        curso4.push(data[i].curso4);   
                    }
                    
                    var ArrayColor1=dynamicColors();
                    var bk1=ArrayColor1[0];
                    var borde1=ArrayColor1[1];
                    var ArrayColor2=dynamicColors();
                    var bk2=ArrayColor2[0];
                    var borde2=ArrayColor2[1];
                    var ArrayColor3=dynamicColors();
                    var bk3=ArrayColor3[0];
                    var borde3=ArrayColor3[1];
                    var ArrayColor4=dynamicColors();
                    var bk4=ArrayColor4[0];
                    var borde4=ArrayColor4[1];

                    var chartdata = {
                        labels: unidad,
                        datasets: [
                            {
                                label: 'CC',
                                backgroundColor: bk1,
                                borderColor: borde1,
                                borderWidth:2,
                                data: curso1
                            },
                            {
                                label: 'PF',
                                backgroundColor: bk2,
                                borderColor: borde2,
                                borderWidth:2,
                                data: curso2
                            },
                            {
                                label: 'CR',
                                backgroundColor: bk3,
                                borderColor: borde3,
                                borderWidth:2,
                                data: curso3
                            },
                            {
                                label: 'CO',
                                backgroundColor: bk4,
                                borderColor: borde4,
                                borderWidth:2,
                                data: curso4
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
