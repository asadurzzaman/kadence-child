<?php
/**
 * Template Name: Checkout Page
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */
namespace Kadence;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<html <?php language_attributes(); ?> class="no-js" <?php kadence()->print_microdata( 'html' ); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<div class="content-container site-container">
		<div id="primary" class="site-content">
			<div id="content" role="main">
				
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->
	</div>

<?php wp_footer(); ?>
</body>
</html>
