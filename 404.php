<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _s
 */

get_header();
?>

<section class="section error-404 not-found">

    <div class="error content">
        <div class="error__wrapper">
            <h1 class="has-text-white title-color">Error 404</h1>
            <h3 class="has-text-white title-color"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', '_s' ); ?></h3>
            <p class="has-text-white is-marginless subtitle-color"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the navigation links', 'oil-baron' ); ?></p>
			<h2 class="spacer has-text-white vs-color ">OR</h2>
			<? echo "<a class='button site-button is-medium' href=\"javascript:history.go(-1)\">go back</a>";  ?>
        </div>
    </div>

</section><!-- .error-404 -->

<?php
get_footer();
