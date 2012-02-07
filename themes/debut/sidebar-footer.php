<?php  
/**
 * The footbar template sidebar. Three widgets displayed above the footer text.
 *
 * @package    WordPress
 * @subpackage Debut
 * @since      1.0
 */
?>

<ul id="footbar">

  <li class="column"><?php dynamic_sidebar( 'footbar-column-1' ); ?></li>

  <li class="column"><?php dynamic_sidebar( 'footbar-column-2' ); ?></li>

  <li class="column"><?php dynamic_sidebar( 'footbar-column-3' ); ?></li>

</ul><!-- footbar -->

<div class="clearfix"><!-- nothing to see here --></div>

