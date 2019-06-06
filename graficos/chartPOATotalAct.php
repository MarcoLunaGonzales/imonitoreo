<?php

$aleatorio=rand(200,2000);
$codUnidadX=$codUnidadX;

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
                console.log("variablesPOA: "+<?=$codUnidadX;?>);
                $.get("dataPOATotalAct.php",
				{codUnidadX:<?=$codUnidadX;?>},
                function (data){
                    console.log("data TOTAL POA:"+data);
                    var area = [];
                    var porcentajemes = [];
					var porcentajegestion = [];						
                    for (var i in data) {
						area.push(data[i].area);
                        porcentajemes.push(data[i].porcentajemes);
                        porcentajegestion.push(data[i].porcentajegestion);   
                    }
					//alert(labs);
                    var chartdata = {
                        labels: area,
                        datasets: [
                            {
                                label: '% Cump. Acum.',
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,
                                data: porcentajemes
                            },
                            {
                                label: '% Cump. Gest.',
                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                borderColor: "rgb(75, 192, 192)",
                                borderWidth:2,
                                data: porcentajegestion
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
