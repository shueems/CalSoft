<?php
include_once '../../config/loader.php';

use Module\Home\Controller\MainCtrl;
use Module\Users\Entity\UserSession;

$objCtrlMain = new MainCtrl();
$objSession = new UserSession();

$arrayCategories = $objCtrlMain->getAllCategories();
$session = false;

if(isset($_SESSION['cod'])){
	$session = true;
}

/*echo "<pre>";
print_r($arrayCategories);
echo "</pre>";*/

?>
<header id="header-menu">
	<?php
    /*
    visualizacion del menu
    */
	$i = 1;
	foreach ($arrayCategories as $index => $value) {
		$xhtml = "<ul class=\"subcategory-menu sub-sidenav\" id=\"subcategory-menu-{$i}\">\n";
		$xhtml .= "<li><a href=\"#\" class=\"back waves-effect\"><i class=\"material-icons\">arrow_back</i> Atrás</a></li>\n";
		$xhtml .= "<li><div class=\"divider\"></div></li>\n";
		$xhtml .= "<li><a class=\"subheader subcategory-title truncate\">{$value['nombre']}</a></li>\n";
		foreach ($value as $index1 => $value1) {
			if($index1 == "hijos"){
				foreach ($value1 as $index2 => $value2) {
					$xhtml .= "<li><a href=\"#\" class=\"waves-effect\">{$value2['nombre']}</a></li>\n";
				}
			}
		}
		$xhtml .= "</ul>\n";
		$i++;
		echo $xhtml;
	}
	?>
    <!-- Mobile menu -->
    <ul class="mobile-class-menu sidenav" id="mobile-menu" data-target="accordion-menu">
		<?php
		if($session){
			?>
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="../../public/images/ecommerce/bgsidenav.jpg">
                    </div>
                    <a href="#"><img class="circle" src="https://picsum.photos/500/300?image=838"></a>
                    <a href="#">
                        <span class="white-text name pb-3 truncate"><?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?></span>
                    </a>
                </div>
            </li>
            <li><a href="#" class="waves-effect"><i class="material-icons">person_outline</i> Mi cuenta</a></li>
            <li><a href="#" class="waves-effect"><i class="material-icons">settings</i> Configuración</a></li>
            <li><a href="contact.php" class="waves-effect"><i class="material-icons">textsms</i> Enviar sugerencias</a>
            </li>
            <li><a href="logout.php" class="waves-effect"><i class="material-icons">power_settings_new</i>
                    Salir</a></li>
			<?php
		}else{
			echo "<li><a href=\"../users/view/registration.php\" class=\"waves-effect\"><i class=\"material-icons\">person</i> Registrarme</a></li>\n
        <li><a href=\"../users/view/login.php\" class=\"waves-effect\"><i class=\"material-icons\">forward</i> Iniciar sesión</a></li>\n
        <li><a href=\"contact.php\" class=\"waves-effect\"><i class=\"material-icons\">textsms</i> Enviar sugerencias</a></li>";
		}
		?>
        <!--<li><a href="#" class="waves-effect"><span class="icon-facebook"></span> Facebook</a></li>
        <li><a href="#" class="waves-effect"><span class="icon-google"></span> Google</a></li>-->
        <li>
            <div class="divider"></div>
        </li>
        <li><a class="subheader">Menú</a></li>
        <li><a href="../publish/categoryanddescription.php" class="waves-effect"><i class="material-icons left">local_shipping</i>
                Vender</a></li>
        <li>
            <a href="#" class="waves-effect">
                <i class="material-icons">list</i> Categorías <i class="material-icons icon-right">chevron_right</i>
            </a>
            <ul>
				<?php
				$i = 1;
				foreach ($arrayCategories as $index => $value) {
					$xhtml = "<li>";
					$xhtml .= "<a href=\"#\" class=\"waves-effect\" data-target=\"subcategory-menu-{$i}\">{$value['nombre']}</a>";
					$xhtml .= "</li>\n";
					$i++;
					echo $xhtml;
				}
				?>
            </ul>
        </li>
    </ul>

    <!-- Dropdown user options -->
    <ul id="user-options" class="dropdown-content custom-dropdown active-hover">
        <?php
        if ($session) {
            ?>
            <li><span class="user-name"><?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?></span></li>
            <li>
                <div class="divider"></div>
            </li>
            <li><a href="#"><i class="material-icons mr-3">person_outline</i> Mi cuenta</a></li>
            <li><a href="#"><i class="material-icons mr-3">settings</i> Configuración</a></li>
            <li><a href="contact.php"><i class="material-icons mr-3">textsms</i> Enviar sugerencias</a></li>
            <li><a href="logout.php"><i class="material-icons mr-3">power_settings_new</i> Salir</a></li>
			<?php
		}else{
			?>
            <li>
                <a href="../users/view/registration.php"><i class="material-icons mr-3">person</i> Registrarme</a>
            </li>
            <li><a href="../users/view/login.php"><i class="material-icons mr-3">forward</i> Iniciar sesión</a></li>
            <li><a href="contact.php"><i class="material-icons mr-3">textsms</i> Enviar sugerencias</a></li>
			<?php
		}
		?>
        <!--<li class="divider" tabindex="-1"></li>
        <li class="lock-hover"><span class="text-muted">Acceder con</span></li>
        <li class="lock-hover pb-3">
            <div class="social-login d-flex justify-content-center">
                <a href="#" class="fb tooltipped" data-position="bottom" data-tooltip="Facebook"><span
                            class="icon-facebook"></span></a>
                <a href="#" class="g tooltipped" data-position="bottom" data-tooltip="Google"><span
                            class="icon-google"></span></a>
            </div>
        </li>-->
    </ul>

    <!-- Subcategories -->
	<?php
	$i = 1;
	foreach ($arrayCategories as $index => $value) {
		$xhtml = "<ul id=\"subcategory-{$i}\" class=\"dropdown-content subcategory\">\n";
		$xhtml .= "<li>";
		foreach ($value as $index1 => $value1) {
			if($index1 == "hijos"){
				foreach ($value1 as $index2 => $value2) {
					$xhtml .= "<a href=\"#\">{$value2['nombre']}</a>\n";
				}
			}
		}
		$xhtml .= "</li>";
		$xhtml .= "</ul>\n";
		$i++;
		echo $xhtml;
	}
	?>
    <!-- Categories -->
    <ul id="category" class="dropdown-content custom-dropdown">
        <li>
            <ul class="custom-dropdown-menu">
				<?php
				$i = 1;
				foreach ($arrayCategories as $index => $value) {
					$xhtml = "<li>";
					$xhtml .= "<a class=\"subcategory-dropdown\" href=\"#\" data-target=\"subcategory-{$i}\">{$value['nombre']}";
					$xhtml .= "<i class=\"material-icons right\">chevron_right</i>";
					$xhtml .= "</a>";
					$xhtml .= "</li>\n";
					$i++;
					echo $xhtml;
				}
				?>
            </ul>
        </li>
    </ul>

    <!--  Menu options -->
    <div class="navbar-fixed">
        <nav class="menu">
            <div class="menu-container">
                <div class="row">
                    <div class="col s8 m4 l4 xl3">
                        <div class="icon hide-on-large-only">
                            <a href="#" data-target="mobile-menu" class="sidenav-trigger" id="menu-icon">
                                <i class="material-icons">menu</i>
                            </a>
                        </div>
						<?php
						$link = '/ecommerce/module/home/menu.php';
						$currentLink = $_SERVER['SCRIPT_NAME'];//obtiene la ruta desde la raiz del proyecto, incluyendo el archivo actual
						if($link == $currentLink){
							echo '<a href="index.php" class="logo">ecommerce</a>';
						}else{
							echo '<a href="../home" class="logo">ecommerce</a>';
						}
						?>
                        <ul class="right hide-on-med-and-down">
                            <li>
                                <a class="category-dropdown font-weight-light" href="#" data-target="category"
                                   id="category">
                                    <i class="material-icons left">list</i>&nbsp;Categorías
                                    <i class="material-icons right">arrow_drop_down</i>
                                </a>
                            </li>
                        </ul>
                        <div class="mobile-search-wrapper hide-on-med-and-up">
                            <form method="GET">
                                <div class="input-field">
                                    <input id="mobile-search-input" type="search"
                                           placeholder="Buscar productos..." name="search" required autocomplete="off">
                                </div>
                                <i class="material-icons icon-left">search</i>
                                <i class="material-icons icon-right hide-sb">close</i>
                            </form>
                        </div>
                    </div>
					<?php
					if($session){
						echo '<div class="col m7 l5 xl6">';
					}else{
						echo '<div class="col m8 l5 xl6">';
					}
					?>
                    <div class="form-search hide-on-small-only">
                        <form class="form-inline valign-wrapper" method="GET">
                            <div class="input-field">
                                <input class="form-control" type="search"
                                       placeholder="Buscar productos..."
                                       id="search-input" name="search" required autocomplete="off">
                            </div>
                            <button class="btn waves-effect waves-light" type="submit" id="search-btn">
                                <i class="material-icons">search</i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col s4 m1 l3 pr-0">
                    <div class="icon hide-on-med-and-up">
                        <div class="mobile-btn-search waves-effect waves-light right">
                            <i class="material-icons psr-tn-2">search</i>
                        </div>
                    </div>
                    <ul class="float-l-right">
                        <li class="hide-on-med-and-down"><a href="../publish/categoryanddescription.php"
                                                            class="font-weight-light">
                                <i class="material-icons left">local_shipping</i>&nbsp;Vender</a>
                        </li>
						<?php
						if($session){
							?>
                            <li>
                                <a href="#" class="waves-effect waves-light tooltipped" data-position="bottom"
                                   data-tooltip="Notificaciones">
                                    <i class="material-icons left psr-tn-2">notifications_none</i>
                                </a>
                            </li>
							<?php
						}
						?>
                        <!-- User options -->
                        <li class="hide-on-med-and-down">
                            <a class="user-options font-weight-light" href="#" data-target="user-options"
                               id="user-options">
								<?php
								if($session){
									echo '<img src="../../public/images/ecommerce/profile1.jpg" class="user-photo left">';
								}else{
									echo "<i class=\"material-icons left\">account_circle</i>";
								}
								?>
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>