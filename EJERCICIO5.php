<?php
require_once '../../../config/loader.php';

use Vendor\Utility\Html;
use Vendor\Utility\Form\DropDown;
use Vendor\Utility\Query\DepAndTown;

$objCtrProfile = new DepAndTown();
$arrayDepartment = $objCtrProfile->getAssocDepartamet();

?>
<!DOCTYPE html>
<html lang="es">

<?php
Html::headUser("Personalizar perfil");
?>
<body>

<?php
/*
       Aca va la barra superior
*/
include_once '../../home/navbar.php';
?>

<main>
    <section class="prz-info pt-4">
        <div class="container">
            <div class="row">
                <h4 class="title-one center">Personalización de perfil</h4>
                <div class="col s12">
                    <h6 class="center">Con la personalización de perfil podemos brindarle un mejor servicio</h6>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m5 offset-m1">
                    <div class="card-wrapper" data-aos="zoom-in-down">
                        <div class="cw-header">
                            <i class="material-icons">add_to_queue</i>
                            <h6 class="cw-title">Sugerencias</h6>
                        </div>
                        <div class="cw-content">
                            <div class="contact-item-content">
                                <p>
                                    Visualice contenido de acuerdo a sus preferencias mejorando su experiencia de
                                    navegación
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m5 offset-m1">
                    <div class="card-wrapper" data-aos="zoom-in-down">
                        <div class="cw-header">
                            <i class="material-icons">add_shopping_cart</i>
                            <h6 class="cw-title">Comprar / Vender</h6>
                        </div>
                        <div class="cw-content">
                            <div class="contact-item-content">
                                <p>Facilidad en el proceso para vender o comprar un producto</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4 class="title-one center mb-1">Empezar ahora!</h4>
                    <span class="expmore center"><i class="material-icons">expand_more</i></span>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <form action="../controller/profilepostctrl.php" method="post" id="customize-profile" class="form-wrapper mt-4"
                          data-aos="fade-up">
                        <h5 class="fw-title">Completa los datos</h5>
                        <div class="row">
                            <div class="col s12">
                                <div class="input-field">
                                    <?php
                                    echo DropDown::show("department", $arrayDepartment, "select-custom", "Seleccione su departamento", "", "");
                                    ?>
                                </div>
                            </div>
                            <div class="col s12">
                                <div class="input-field">
                                    <select id="town" name="town" class="select-custom">
                                        <option value="" disabled selected>Seleccione su municipio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col s12">
                                <div class="input-field">
                                    <input id="phone" type="tel" name="phone">
                                    <label for="phone">Teléfono</label>
                                </div>
                            </div>
                            <div class="col s12">
                                <div class="d-flex justify-content-center">
                                    <button class="btn-vc-rd waves-effect" type="submit">Continuar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</main>
<?php
/*
       aca va todo el footer de la pagina
*/
Html::importFooterIndex();
Html::importGeneralJs();
?>
<script src="../../../public/js/variecampo/load/loadtownprofile.js"></script>
<script src="../../../public/js/variecampo/profile-validate.js"></script>
</body>
</html>
