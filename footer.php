<?php

/**
 * The template for displaying the footer
 * @package Eura
 */

// Footer Content
// eura_theme_footer_content();
// Back To Top
eura_footer_back_to_top();

wp_footer();
?>

<footer class="footer" id="footer">
  <div class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <figure>
            <a href="<?= home_url(); ?>">
              <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/sorsa-motors.svg" alt="Logo">
            </a>
          </figure>
          <p class="text-white">Somos un grupo empresarial familiar con casi 30 años en el sector automotriz, comprometidos con el desarrollo sotenible.</p>
        </div>
        <div class="col-md-3">
          <ul class="list-slugs">
            <li class="list-slugs__item">
              <a href="https://concesionariahonda.sorsa.pe/sorsa-motors/" class="list-slugs__link">Cultura SORSA</a>
            </li>            
            <li class="list-slugs__item">
              <a href="#0" class="list-slugs__link">Motos Honda</a>
            </li>
            <li class="list-slugs__item">
              <a href="#0" class="list-slugs__link">Motokar Honda</a>
            </li>
          </ul>
        </div>
        <div class="col-md-3">
          <ul class="list-slugs">
            <li class="list-slugs__item">
              <a href="#0" class="list-slugs__link">Encuentra tu repuesto</a>
            </li>
            <li class="list-slugs__item">
              <a href="#0" class="list-slugs__link">Servicio técnico automotriz</a>
            </li>
            <li class="list-slugs__item">
              <a href="#0" class="list-slugs__link">Comunidad Motera</a>
            </li>
          </ul>
        </div>

        <div class="col-md-3">
          <ul class="list-slugs ps-md-0">
            <li class="list-slugs__item">
              <a href="#0" class="list-slugs__link">Términos y condiciones</a>
            </li>
          </ul>
          <p class="text-white mb-1">Si deseas recibir más información dejanos tu email</p>
          <?= do_shortcode('[contact-form-7 id="2500cac" title="Deseo más informacion"]'); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="container">
      <div class="row">
        <div class="col-12 text-start">
          <p class="text-white">Copyright <?= date("Y") ?> Sorsa Motors. Todos los derechos reservados</p>
        </div>
      </div>
    </div>
  </div>
</footer>
</body>

</html>