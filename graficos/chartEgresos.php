<?php
$anioTemporal=$anioTemporal;
$mesTemporal=$mesTemporal;
$arrayOrganismos=$arrayOrganismos;
$arrayFondos=$arrayFondos;
?>
<style type="text/css">

#chart-container3 {
    width: 100%;
}
</style>
<?php
//session_start();

//$fondoTemporal='1011|1020';//echo "hola como vamos";

?>
<script type="text/javascript" src="assets/chartjs/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/chartjs/js/Chart.bundle.js"></script>
<script type="text/javascript" src="assets/chartjs/js/utils.js"></script>


</head>

    <div id="chart-container3" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas3"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph3();
        });
        function showGraph3()
        {
            {
                console.log("antes de los datos;");
                $.get("graficos/dataEgresos.php",
				{anioTemporal:<?=$anioTemporal;?>,mesTemporal:<?=$mesTemporal;?>,arrayFondos:"<?=$arrayFondos;?>",arrayOrganismos:"<?=$arrayOrganismos?>"},
                function (data){
                    console.log("aqui mostramos los datos:"+data);
                    var fondo = [];
                    var montoPres = [];
					var montoEj = [];						

                    for (var i in data) {
						fondo.push(data[i].fondo);
                        console.log(data[i].fondo);
                        montoPres.push(data[i].montoPres);
                        montoEj.push(data[i].montoEj);                        
                    }
					//alert(labs);
                    var chartdata = {
                        labels: fondo,
                        datasets: [
                            {
                                label: 'PresEg.',
                                backgroundColor: "rgba(0,0,205,0.2)",
                                borderColor: "rgb(0,0,205)",
                                borderWidth:2,
                                data: montoPres
                            },
                            {
                                label: 'EjEg.',
                                backgroundColor: "rgba(255,69,0,0.2)",
                                borderColor: "rgb(255,69,0)",
                                borderWidth:2,
                                data: montoEj
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas3");

                    var barGraph = new Chart(graphTarget, {
                        type: 'horizontalBar',
                        data: chartdata,
						options: {
                            scales: {
                                xAxes: [{
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
