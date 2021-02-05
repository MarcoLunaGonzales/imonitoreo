<!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo"></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
            <?php 
              require_once 'conexion.php';
              $dbh = new Conexion();
              $fechaMayoresX="";
              $sqlFechaMayores="SELECT max(p.fecha)as fecha from po_mayores p";
              $stmtMayores= $dbh->prepare($sqlFechaMayores);
              $stmtMayores->execute();
              $stmtMayores->bindColumn('fecha', $fechaMayores);
              while ($rowMayores = $stmtMayores->fetch(PDO::FETCH_ASSOC)) {
                $fechaMayoresX=$rowMayores["fecha"];
              }
              
              $globalNombreGestion=$_SESSION['globalNombreGestion'];
              $globalNombreUnidad=$_SESSION['globalNombreUnidad'];
              $globalNombreArea=$_SESSION['globalNombreArea'];
              $fechaSistema=date("d/m/Y");
              $horaSistema=date("H:i");
            ?>
            <h6>Gestión Trabajo: </h6>&nbsp;<h4 class="text-danger font-weight-bold">[<?=$globalNombreGestion;?>]</h4>&nbsp;&nbsp;&nbsp;<h6>Unidad: </h6>&nbsp;<h4 class="text-danger font-weight-bold">[ <?=$globalNombreUnidad;?> ]</h4> &nbsp;&nbsp; <h6>Area: </h6>&nbsp;<h4 class="text-danger font-weight-bold">[ <?=$globalNombreArea;?> ]</h4>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <h6 class="small font-weight-bold">Actualización Mayores: [<span class="text-primary font-weight-bold"><?=$fechaMayores;?></span>]</h6>
          
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <!--li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <span class="notification">1</span>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">RCB no registro la ejecucion del mes en curso</a>
                </div>
              </li-->
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="logout.php">Salir</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
<!-- End Navbar -->