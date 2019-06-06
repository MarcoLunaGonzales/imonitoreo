<?php
$anioTemporal=$anioTemporal;
$mesTemporal=$mesTemporal;
$arrayOrganismos=$arrayOrganismos;
$arrayFondos=$arrayFondos;
?>
<style type="text/css">

#chart-container2 {
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

    <div id="chart-container2" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas2"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph1();
        });
        function showGraph1()
        {
            {
                console.log("antes de los datos;");
                $.get("graficos/dataIngresos.php",
				{anioTemporal:<?=$anioTemporal;?>,mesTemporal:<?=$mesTemporal;?>,arrayFondos:"<?=$arrayFondos;?>",arrayOrganismos:"<?=$arrayOrganismos?>"},
                function (data){
                    console.log("aqui mostramos los datos:"+data);
                    var fondo = [];
                    var montoPresIngreso = [];
					var montoEjIngreso = [];						

                    for (var i in data) {
						fondo.push(data[i].fondo);
                        console.log(data[i].fondo);
                        montoPresIngreso.push(data[i].montoPresIngreso);
                        montoEjIngreso.push(data[i].montoEjIngreso);                        
                    }
					//alert(labs);
                    var chartdata = {
                        labels: fondo,
                        datasets: [
                            {
                                label: 'PresIng.',
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,
                                data: montoPresIngreso
                            },
                            {
                                label: 'EjIngreso.',
                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                borderColor: "rgb(75, 192, 192)",
                                borderWidth:2,
                                data: montoEjIngreso
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas2");

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
