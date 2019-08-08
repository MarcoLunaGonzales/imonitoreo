<?php
$aleatorio=rand(200,2000);

$anioX=$anioX;
$mesX=$mesX;
$vistaX=$vistaX;

?>
<style type="text/css">

#chart-container<?=$aleatorio;?> {
    width: 100%;
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
                console.log("antes de los datos;");
                $.get("dataEmpresasCertificados.php",
                {anioX:<?=$anioX;?>,mesX:<?=$mesX?>,vistaX:<?=$vistaX;?>},
                function (data){
                    console.log("aqui mostramos los datos:"+data);
                    var unidad = [];
                    var empresas = [];
                    var certificados = [];                        

                    for (var i in data) {
                        unidad.push(data[i].unidad);
                        console.log(data[i].unidad);
                        empresas.push(data[i].empresas);
                        certificados.push(data[i].certificados);                        
                    }
                    //alert(labs);
                    var chartdata = {
                        labels: unidad,
                        datasets: [
                            {
                                label: '# Empresas.',
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,
                                data: empresas
                            },
                            {
                                label: '# Certificados.',
                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                borderColor: "rgb(75, 192, 192)",
                                borderWidth:2,
                                data: certificados
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
