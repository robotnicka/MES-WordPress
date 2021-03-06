<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mindseyesociety
 */
?>

<section class="no-results">

	<header class="page__header">
		<h1 class="page__title"><?php esc_html_e( 'Nothing Found', 'mindseyesociety' ); ?></h1>
	</header><!-- .page__header -->

	<div class="page__content">

		<?php if ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mindseyesociety' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mindseyesociety' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>

	</div><!-- .page__content -->
</section><!-- .no-results -->
