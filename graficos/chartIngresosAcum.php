<style type="text/css">

#chart-container1 {
    width: 100%;
}
</style>
<?php
set_time_limit(0);
//session_start();

//$fondoTemporal='1011|1020';//echo "hola como vamos";

?>
<script type="text/javascript" src="assets/chartjs/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/chartjs/js/Chart.bundle.js"></script>
<script type="text/javascript" src="assets/chartjs/js/utils.js"></script>


</head>

    <div id="chart-container1" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas1"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph();
        });
        function showGraph()
        {
            {
                console.log("antes de los datos;");
                $.get("graficos/dataIngresosAcum.php",
                {},
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
                                backgroundColor: "rgba(209, 51, 255, 0.2)",
                                borderColor: "rgb(209, 51, 255)",
                                borderWidth:2,
                                data: montoPresIngreso
                            },
                            {
                                label: 'EjIngreso.',
                                backgroundColor: "rgba(51, 255, 51, 0.2)",
                                borderColor: "rgb(51, 255, 51)",
                                borderWidth:2,
                                data: montoEjIngreso
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas1");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            responsive: true,
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: ''
                            }
                        }
                    });

                });
            }
        }
        </script>
