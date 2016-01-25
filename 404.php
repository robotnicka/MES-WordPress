<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package mindseyesociety
 */

get_header(); ?>

<main id="main" class="content__main" role="main">

	<section class="error-404 not-found">
		<header class="page__header">
			<h1 class="page__title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'mindseyesociety' ); ?></h1>
		</header><!-- .page__header -->

		<div class="page__content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'mindseyesociety' ); ?></p>

			<?php get_search_form(); ?>

			<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

		</div><!-- .page__content -->
	</section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();
