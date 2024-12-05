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

<?php
$settings = pods('ajustes_del_tema');
$footer_col1 = $settings->field('footer_enlaces_columna_1');
$footer_col2 = $settings->field('footer_enlaces_columna_2');
$footer_copyright = $settings->field('footer_copyright');
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
          <p class="text-white">Somos un grupo empresarial familiar con más de 25 años en el sector automotriz, comprometidos con el desarrollo sostenible</p>
        </div>
        <div class="col-md-3 col-slugs">
          <?php if ($footer_col1): ?>
            <?= wp_kses_post($footer_col1) ?>
          <?php endif; ?>
        </div>
        <div class="col-md-3 col-slugs">
          <?php if ($footer_col2): ?>
            <?= wp_kses_post($footer_col2) ?>
          <?php endif; ?>
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
          <?php if ($footer_copyright): ?>
            <?= wp_kses_post($footer_copyright) ?>
          <?php else: ?>
            <p class="text-white">Copyright <?= date("Y") ?> Sorsa Motors. Todos los derechos reservados</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</footer>
<div id="modal-buscador" class="modal-buscador">
</div>
</body>

</html>