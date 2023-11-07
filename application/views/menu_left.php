<div class="menu-space">
    <div class="content">
        <ul class="cl-vnavigation">
            <li><a href="#"><i class="fas fa-users"></i><span>Clientes</span></a>
                <ul class="sub-menu">
                    <li class=""><a href="<?= base_url('clientes/get_clientes'); ?>">Todos</a></li>
                    <li class=""><a href="<?= base_url('clientes/customer_new'); ?>">Agregar cliente</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fas fa-users"></i><span>Microcrédito</span></a>
                <ul class="sub-menu">
                    <li class=""><a href="<?= base_url('muffin/customers_muffin_all'); ?>">Data Moffin</a></li>
                    <li class=""><a href="<?= base_url('clientes/customer_new'); ?>">Data Quash</a></li>
                </ul>
            </li>
            <li><a href="<?= base_url('clientes/get_clientes'); ?>"><i class="fas fa-users"></i><span>opcion</span></a></li>
            
            <li><a href="#"><i class="fas fa-cog"></i><span> opcion</span></a>
                <ul class="sub-menu">
                    <li class=""><a href="<?= base_url('clientes/get_clientes'); ?>">opcion</a></li>
                    <li class=""><a href="<?= base_url('listas/mostrar_listas'); ?>">opcion</a></li>
                    <li class=""><a href="<?= base_url('listas/contenido_listas'); ?>">opcion</a></li>
                    <li class=""><a href="<?= base_url('listas/contenido_oculto'); ?>">opcion</a></li>

                    <?php if ($entidad == 1500) {
                        ?>
                        <li class=""><a href="<?= base_url('usuarios/mostrar_usuarios'); ?>">opcion</a></li>
                        <li class=""><a href="<?= base_url('fuentes/mostrar_fuentes'); ?>">opcion</a></li>
                        <?php
                    } else {

                    }
                    ?>
                </ul>
            </li>
            
<?php
$entidad = $this->session->userdata('entidad');
if ($entidad == '1500') {
    ?>
                <li><a href="<?= base_url('bitacora/contenido_bitacora'); ?>"><i class="fas fas fa-chart-line"></i><span> opcion</span></a>

                </li>
<?php } else {
    
} ?>
            <li><a href="<?= base_url('listas/paises'); ?>"><i class="fa fa-map-marker"></i><span> opcion</span></a>

            <li><a href="<?= base_url('login/cerrarlogin'); ?>"><i class="fas fa-sign-out-alt"></i><span> Salir</span></a>

            </li>




        </ul>
    </div>
</div>
<div class="search-field collapse-button">
    <!-- Seccion de envio de Correo electronico -->
    <a class="form-control search" href="mailto:abreton@ubcubo.com?Subject=Reporte%20de%20problema%20">Reportar un problema</a>
    <button id="sidebar-collapse" class="btn btn-default"><i class="fa fa-angle-left"></i>
    </button>
</div>
