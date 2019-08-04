              <table width="100%" class="table table-condensed" id="main">
                <thead>
                  <tr>
                    <th class="text-center font-weight-bold">Servicio</th>
                    <th class="text-center font-weight-bold" colspan="4">TCP</th>
                    <th class="text-center font-weight-bold" colspan="4">TCS</th>
                    <th class="text-center font-weight-bold" colspan="4">Totales</th>
                  </tr>
                  <tr>
                    <th class="text-center font-weight-bold">-</th>
                    <th class="text-center font-weight-bold"># Mes</th>
                    <th class="text-center font-weight-bold"># Acum</th>
                    <th class="text-center font-weight-bold">% Mes</th>
                    <th class="text-center font-weight-bold">% Acum</th>

                    <th class="text-center font-weight-bold"># Mes</th>
                    <th class="text-center font-weight-bold"># Acum</th>
                    <th class="text-center font-weight-bold">% Mes</th>
                    <th class="text-center font-weight-bold">% Acum</th>

                    <th class="text-center font-weight-bold"># Mes</th>
                    <th class="text-center font-weight-bold"># Acum</th>
                    <th class="text-center font-weight-bold">% Mes</th>
                    <th class="text-center font-weight-bold">% Acum</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlU="SELECT u.codigo, u.nombre, u.abreviatura FROM unidades_organizacionales u WHERE u.codigo in ($cadenaUnidades) order by 2";
                  $stmtU = $dbh->prepare($sqlU);
                  $stmtU->execute();
                  $stmtU->bindColumn('codigo', $codigoX);
                  $stmtU->bindColumn('abreviatura', $abrevX);

                  /*ESTA PARTE ES PARA OBTENER LOS TOTALES*/
                  $totalMesUnidadX=0;
                  $totalAcumUnidadX=0;

                  $cantEmpresasTCP=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,0,$vista);
                  $cantEmpresasTCPAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,1,$vista);

                  $cantEmpresasTCS=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,0,$vista);
                  $cantEmpresasTCSAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,1,$vista);

                  $totalMesUnidadX=$cantEmpresasTCP+$cantEmpresasTCS;
                  $totalAcumUnidadX=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;
                  /*FIN OBTENER LOS TOTALES*/

                  while($rowU = $stmtU -> fetch(PDO::FETCH_BOUND)){
                    $totalMesUnidad=0;
                    $totalAcumUnidad=0;

                    $cantEmpresasTCP=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,39,0,0,$vista);
                    $cantEmpresasTCPAcum=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,39,0,1,$vista);

                    $cantEmpresasTCS=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,38,0,0,$vista);
                    $cantEmpresasTCSAcum=obtenerCantCertificados($codigoX,$anioTemporal,$mesTemporal,38,0,1,$vista);
                    
                    $totalMes=$cantEmpresasTCP+$cantEmpresasTCS;
                    $totalAcumulado=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                    $totalMesUnidad=$cantEmpresasTCP+$cantEmpresasTCS;
                    $totalAcumUnidad=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                    $partMesTCP=0;
                    $partMesTCS=0;
                    if($totalMes>0){
                      $partMesTCP=($cantEmpresasTCP/$totalMes)*100;                    
                      $partMesTCS=($cantEmpresasTCS/$totalMes)*100;                    
                    }

                    $partAcumTCP=0;
                    $partAcumTCS=0;
                    if($totalAcumulado>0){
                      $partAcumTCP=($cantEmpresasTCPAcum/$totalAcumulado)*100;                    
                      $partAcumTCS=($cantEmpresasTCSAcum/$totalAcumulado)*100;                    
                    }
                    $porcentajeMes=($totalMesUnidad/$totalMesUnidadX)*100;
                    $porcentajeAcum=($totalAcumUnidad/$totalAcumUnidadX)*100;

                    $urlDetalle="rptCertificadosDetalle.php?vista=$vista&codUnidad=$codigoX&mes=$mesTemporal&anio=$anioTemporal&norma=&iaf=0&certificador=0";
                  ?>
                  <tr>
                    <td class="text-center"><?=$abrevX;?></td>
                    <td class="table-warning text-center"><a href="<?=$urlDetalle;?>&codArea=39&acumulado=0" target="_blank"><?=($cantEmpresasTCP==0)?"-":formatNumberInt($cantEmpresasTCP);?></a></td>
                    <td class="table-primary text-center"><a href="<?=$urlDetalle;?>&codArea=39&acumulado=1" target="_blank"><?=($cantEmpresasTCPAcum==0)?"-":formatNumberInt($cantEmpresasTCPAcum);?></a></td>
                    <td class="table-danger text-center"><?=($partMesTCP==0)?"-":formatNumberInt($partMesTCP);?></td>
                    <td class="table-success text-center"><?=($partAcumTCP==0)?"-":formatNumberInt($partAcumTCP);?></td>

                    <td class="table-warning text-center"><a href="<?=$urlDetalle;?>&codArea=38&acumulado=0" target="_blank"><?=($cantEmpresasTCS==0)?"-":formatNumberInt($cantEmpresasTCS);?></a></td>
                    <td class="table-primary text-center"><a href="<?=$urlDetalle;?>&codArea=38&acumulado=1" target="_blank"><?=($cantEmpresasTCSAcum==0)?"-":formatNumberInt($cantEmpresasTCSAcum);?></a></td>
                    <td class="table-danger text-center"><?=($partMesTCS==0)?"-":formatNumberInt($partMesTCS);?></td>
                    <td class="table-success text-center"><?=($partAcumTCS==0)?"-":formatNumberInt($partAcumTCS);?></td>

                    <td class="table-warning text-center font-weight-bold"><?=formatNumberInt($totalMesUnidad);?></td>
                    <td class="table-primary text-center font-weight-bold"><?=formatNumberInt($totalAcumUnidad);?></td>
                    <td class="table-danger text-center font-weight-bold"><?=($porcentajeMes==0)?"-":formatNumberDec($porcentajeMes);?></td>
                    <td class="table-success text-center font-weight-bold"><?=($porcentajeAcum==0)?"-":formatNumberDec($porcentajeAcum);?></td>

                  </tr>
                  <?php
                  }
                  $totalMesUnidad=0;
                  $totalAcumUnidad=0;

                  $cantEmpresasTCP=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,0,$vista);
                  $cantEmpresasTCPAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,39,0,1,$vista);

                  $cantEmpresasTCS=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,0,$vista);
                  $cantEmpresasTCSAcum=obtenerCantCertificados(0,$anioTemporal,$mesTemporal,38,0,1,$vista);
                  
                  $totalMes=$cantEmpresasTCP+$cantEmpresasTCS;
                  $totalAcumulado=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                  $totalMesUnidad=$cantEmpresasTCP+$cantEmpresasTCS;
                  $totalAcumUnidad=$cantEmpresasTCPAcum+$cantEmpresasTCSAcum;

                  $partMesTCP=0;
                  $partMesTCS=0;
                  if($totalMes>0){
                    $partMesTCP=($cantEmpresasTCP/$totalMes)*100;                    
                    $partMesTCS=($cantEmpresasTCS/$totalMes)*100;                    
                  }

                  $partAcumTCP=0;
                  $partAcumTCS=0;
                  if($totalAcumulado>0){
                    $partAcumTCP=($cantEmpresasTCPAcum/$totalAcumulado)*100;                    
                    $partAcumTCS=($cantEmpresasTCSAcum/$totalAcumulado)*100;                    
                  }

                  $urlDetalle="rptCertificadosDetalle.php?vista=$vista&codUnidad=0&mes=$mesTemporal&anio=$anioTemporal&norma=&iaf=0&certificador=0";
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-center">Totales</th>
                    <th class="table-warning text-center"><a href="<?=$urlDetalle;?>&codArea=39&acumulado=0" target="_blank"><?=($cantEmpresasTCP==0)?"-":formatNumberInt($cantEmpresasTCP);?></a></th>
                    <th class="table-primary text-center"><a href="<?=$urlDetalle;?>&codArea=39&acumulado=1" target="_blank"><?=($cantEmpresasTCPAcum==0)?"-":formatNumberInt($cantEmpresasTCPAcum);?></a></th>
                    <th class="table-danger text-center"><?=($partMesTCP==0)?"-":formatNumberInt($partMesTCP);?></th>
                    <th class="table-success text-center"><?=($partAcumTCP==0)?"-":formatNumberInt($partAcumTCP);?></th>

                    <th class="table-warning text-center"><a href="<?=$urlDetalle;?>&codArea=38&acumulado=0" target="_blank"><?=($cantEmpresasTCS==0)?"-":formatNumberInt($cantEmpresasTCS);?></a></th>
                    <th class="table-primary text-center"><a href="<?=$urlDetalle;?>&codArea=38&acumulado=1" target="_blank"><?=($cantEmpresasTCSAcum==0)?"-":formatNumberInt($cantEmpresasTCSAcum);?></a></th>
                    <th class="table-danger text-center"><?=($partMesTCS==0)?"-":formatNumberInt($partMesTCS);?></th>
                    <th class="table-success text-center"><?=($partAcumTCS==0)?"-":formatNumberInt($partAcumTCS);?></th>

                    <th class="table-warning text-center"><?=formatNumberInt($totalMesUnidad);?></th>
                    <th class="table-primary text-center"><?=formatNumberInt($totalAcumUnidad);?></th>
                    <th class="table-danger text-center"><?=formatNumberInt(100);?></th>
                    <th class="table-success text-center"><?=formatNumberInt(100);?></th>
                  </tr>
                </tfoot>
              </table>
