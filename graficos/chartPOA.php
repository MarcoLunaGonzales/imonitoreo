<?php

$aleatorio=rand(200,2000);
$codAreaX=$codAreaX;
$codUnidadX=$codUnidadX;

?>
<style type="text/css">

#chart-container<?=$aleatorio;?> {
    width: 60%;
}
</style>
<?php

//session_start();

//$fondoTemporal='1011|1020';//echo "hola como vamos";

?>
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
                console.log("antes de los datos pOA;");
                console.log("variables: "+<?=$codAreaX?>+" "+<?=$codUnidadX;?>);
                $.get("dataPOA.php",
				{codAreaX:<?=$codAreaX;?>,codUnidadX:<?=$codUnidadX;?>},
                function (data){
                    //console.log("data POA:"+data);
                    var mes = [];
                    var presupuesto = [];
					var ejecutado = [];						
                    var area = [];
                    var unidad = [] ;
                    for (var i in data) {
						mes.push(data[i].mes);
                        console.log(data[i].area+" "+data[i].unidad+" "+data[i].mes+" "+data[i].presupuesto);
                        presupuesto.push(data[i].presupuesto);
                        ejecutado.push(data[i].ejecutado);   
                        area.push(data[i].area);
                        unidad.push(data[i].unidad);
                    }
					//alert(labs);
                    var chartdata = {
                        labels: mes,
                        datasets: [
                            {
                                label: 'Planificado.',
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,
                                data: presupuesto
                            },
                            {
                                label: 'Ejecutado.',
                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                borderColor: "rgb(75, 192, 192)",
                                borderWidth:2,
                                data: ejecutado
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
