<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package mindseyesociety
 */


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 *
 * @return string The filtered title.
 */
function mindseyesociety_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'mindseyesociety' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'mindseyesociety_wp_title', 10, 2 );


/**
 * Filters classes for menu items.
 * @param  array $classes The classes array.
 * @return array
 */
function mindseyesociety_menu_classes( array $classes ) {
	return array_map( function( $class ) {

		if ( 'menu-item' === $class ) {
			$class = 'nav__item';
		} elseif ( 'menu-item-has-children' === $class ) {
			$class = 'nav__item--children';
		} else {
			$class = str_replace( 'menu-item-type-', 'nav__item--', $class ); // Type.
			$class = preg_replace( '/^menu-item-(\d+)$/', 'nav__item--$1', $class );
		}

		return $class;

	}, $classes );
}
add_filter( 'nav_menu_css_class', 'mindseyesociety_menu_classes' );


/**
 * Filters menu HTML to alter submenu class.
 * @param  string $nav_menu HTML menu.
 * @return string
 */
function mindseyesociety_menu_html( $nav_menu ) {
	$nav_menu = str_replace( 'class="sub-menu"', 'class="nav__submenu"', $nav_menu );
	return $nav_menu;
}
add_filter( 'wp_nav_menu', 'mindseyesociety_menu_html' );


/**
 * Adds class to menu links.
 * @param  array  $attributes Attributes.
 * @param  object $item       Post object.
 * @return array
 */
function mindseyesociety_menu_link_classes( array $attributes, $item ) {
	$attributes['class'] = 'nav__link';

	if ( isset( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
		unset( $attributes['href'] );
	}

	return $attributes;
}
add_filter( 'nav_menu_link_attributes', 'mindseyesociety_menu_link_classes', 10, 2 );


/**
 * Alters post classes.
 * @param  array $classes Classes.
 * @return array
 */
function mindseyesociety_post_classes( array $classes ) {
	$classes[] = 'entry';
	unset( $classes['hentry'] );
	return $classes;
}
add_filter( 'post_class', 'mindseyesociety_post_classes' );


/**
 * Adds class to pagination links.
 * @param  string $attr Attributes.
 * @return string
 */
function mindseyesociety_posts_link_class( $attr ) {
	return $attr . ' class="pagination__link"';
}
add_filter( 'previous_posts_link_attributes', 'mindseyesociety_posts_link_class' );
add_filter( 'next_posts_link_attributes', 'mindseyesociety_posts_link_class' );


/**
 * Removes W3TC dashboard for non-super admins.
 * @return void
 */
function mindseyesociety_remove_w3tc() {
	if ( ! current_user_can( 'manage_network' ) ) {
		remove_menu_page( 'w3tc_dashboard' );
	}
}
add_action( 'admin_menu', 'mindseyesociety_remove_w3tc', 11 );


/**
 * Makes search run across entire network.
 * @param  WP_Query $query The query object.
 * @return void
 */
function mindseyesociety_search_multisite( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search ) {
		$query->set( 'multisite', 1 );
	}
}
add_action( 'pre_get_posts', 'mindseyesociety_search_multisite' );


/**
 * Fixes sender from WordPress.
 * @param  mixed $params Sent object.
 * @return void
 */
function mindseyesociety_fix_mail( $params ) {
	if ( true !== filter_var( $params->Sender, FILTER_VALIDATE_EMAIL ) ) {
		$params->Sender = $params->From;
	}
}
add_action( 'phpmailer_init', 'mindseyesociety_fix_mail' );
