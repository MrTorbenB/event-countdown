<?php
/**
 * Plugin Name: Event Countdown
 * Plugin URI:  https://github.com/MrTorbenB/event-countdown
 * Description: Accessible live event countdowns with shortcode attributes and configurable defaults.
 * Version:     2.0.0
 * Requires at least: 6.4
 * Requires PHP: 7.4
 * Author:      TorbenB
 * Author URI:  https://torbenb.info/
 * License:     GPL-3.0-or-later
 * Text Domain: torbenb-event-countdown
 */

defined( 'ABSPATH' ) || exit;

function torbenb_event_sanitize_date( $value ): string {
	$value = sanitize_text_field( (string) $value );
	$date  = DateTimeImmutable::createFromFormat( 'Y-m-d\TH:i', $value, wp_timezone() );
	return $date ? $value : '';
}

function torbenb_event_register_settings(): void {
	register_setting( 'torbenb_event_settings', 'torbenb_event_date', array( 'type' => 'string', 'sanitize_callback' => 'torbenb_event_sanitize_date', 'default' => '' ) );
	register_setting( 'torbenb_event_settings', 'torbenb_event_name', array( 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field', 'default' => '' ) );
}
add_action( 'admin_init', 'torbenb_event_register_settings' );

function torbenb_event_admin_menu(): void {
	add_options_page( 'Event Countdown', 'Event Countdown', 'manage_options', 'torbenb-event-countdown', 'torbenb_event_settings_page' );
}
add_action( 'admin_menu', 'torbenb_event_admin_menu' );

function torbenb_event_settings_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) return;
	?>
	<div class="wrap"><h1><?php esc_html_e( 'Event Countdown', 'torbenb-event-countdown' ); ?></h1><form method="post" action="options.php">
	<?php settings_fields( 'torbenb_event_settings' ); ?>
	<table class="form-table"><tr><th><label for="torbenb_event_name"><?php esc_html_e( 'Default event name', 'torbenb-event-countdown' ); ?></label></th><td><input class="regular-text" id="torbenb_event_name" name="torbenb_event_name" value="<?php echo esc_attr( get_option( 'torbenb_event_name', '' ) ); ?>"></td></tr>
	<tr><th><label for="torbenb_event_date"><?php esc_html_e( 'Default date', 'torbenb-event-countdown' ); ?></label></th><td><input type="datetime-local" id="torbenb_event_date" name="torbenb_event_date" value="<?php echo esc_attr( get_option( 'torbenb_event_date', '' ) ); ?>"><p class="description"><?php esc_html_e( 'Uses the timezone configured in WordPress.', 'torbenb-event-countdown' ); ?></p></td></tr></table><?php submit_button(); ?></form></div>
	<?php
}

function torbenb_event_countdown_shortcode( $atts ): string {
	$atts = shortcode_atts(
		array(
			'date'    => get_option( 'torbenb_event_date', '' ),
			'name'    => get_option( 'torbenb_event_name', __( 'Event', 'torbenb-event-countdown' ) ),
			'expired' => __( 'This event has started.', 'torbenb-event-countdown' ),
			'class'   => '',
		),
		$atts,
		'event_countdown'
	);
	$date_string = sanitize_text_field( (string) $atts['date'] );
	$date = DateTimeImmutable::createFromFormat( 'Y-m-d\TH:i', $date_string, wp_timezone() );
	if ( ! $date ) {
		return current_user_can( 'manage_options' ) ? '<span class="event-countdown event-countdown--error">' . esc_html__( 'Set a valid event date in ISO format, for example 2027-12-31T18:00.', 'torbenb-event-countdown' ) . '</span>' : '';
	}

	wp_enqueue_script( 'torbenb-event-countdown', plugins_url( 'assets/event-countdown.js', __FILE__ ), array(), '2.0.0', true );
	wp_enqueue_style( 'torbenb-event-countdown', plugins_url( 'assets/event-countdown.css', __FILE__ ), array(), '2.0.0' );
	$classes = trim( 'event-countdown ' . sanitize_html_class( (string) $atts['class'] ) );

	return sprintf(
		'<section class="%1$s" data-event-countdown data-target="%2$s" data-expired="%3$s"><h3 class="event-countdown__name">%4$s</h3><div class="event-countdown__timer" role="timer" aria-live="off"><span><strong data-days>0</strong><small>%5$s</small></span><span><strong data-hours>00</strong><small>%6$s</small></span><span><strong data-minutes>00</strong><small>%7$s</small></span><span><strong data-seconds>00</strong><small>%8$s</small></span></div></section>',
		esc_attr( $classes ), esc_attr( $date->format( DATE_ATOM ) ), esc_attr( sanitize_text_field( (string) $atts['expired'] ) ), esc_html( sanitize_text_field( (string) $atts['name'] ) ), esc_html__( 'Days', 'torbenb-event-countdown' ), esc_html__( 'Hours', 'torbenb-event-countdown' ), esc_html__( 'Minutes', 'torbenb-event-countdown' ), esc_html__( 'Seconds', 'torbenb-event-countdown' )
	);
}
add_shortcode( 'event_countdown', 'torbenb_event_countdown_shortcode' );
