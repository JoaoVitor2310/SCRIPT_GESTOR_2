    <style>
        .nav-top a{
            color:#fff !important;
        }
    </style>
    <nav <?php if($gestor_class->get_options("mod_ligh") == "1"){  ?>style="background-color: <?= $gestor_class->get_options('color_menu_admin'); ?> !important;"<?php } ?> class="nav-top navbar sticky-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="">
          <img width="120" src="https://gestormaster.top/painel/img/logo-gestor-lite_dark_on.png" />
      </a>
      <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="?sair"> <i class="fa fa-power-off"></i> Sair</a>
        </li>
      </ul>
    </nav>
