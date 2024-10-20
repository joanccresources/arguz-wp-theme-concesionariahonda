<?php
// Obtenemos el año actual
function shortcode_year()
{
  return date('Y');
}
add_shortcode('current_year', 'shortcode_year');
