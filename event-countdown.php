<?php
/*
Plugin Name: Event Countdown Shortcode
Plugin URI:  https://torbenb.info/download
Description: Zeigt einen Countdown zu einem bestimmten Event per Shortcode [event_countdown] an und ermöglicht die Verwaltung des Events im Admin-Bereich.
Version:     1.2
Author:      TorbenB
Author URI:  https://torbenb.info
*/

// Shortcode-Handler-Funktion
function event_countdown_shortcode($atts) {
    // Holen des gespeicherten Event-Datums und -Namens
    $event_date_str = get_option('event_countdown_date');
    $event_name = get_option('event_countdown_name', 'Mein Event');

    if (!$event_date_str) {
        return "Bitte setzen Sie ein Datum für das Event im Admin-Bereich.";
    }

    // Event-Datum im deutschen Format in Unix-Zeitstempel konvertieren
    $event_date = DateTime::createFromFormat('d.m.Y H:i:s', $event_date_str);
    if (!$event_date) {
        return "Das Event-Datum hat ein ungültiges Format. Bitte geben Sie das Datum im Format TT.MM.JJJJ HH:MM:SS an.";
    }

    $event_timestamp = $event_date->getTimestamp();
    $current_timestamp = time();

    // Berechne den Unterschied in Sekunden
    $time_diff = $event_timestamp - $current_timestamp;

    if ($time_diff > 0) {
        // Tage, Stunden, Minuten und Sekunden berechnen
        $days = floor($time_diff / (60 * 60 * 24));
        $hours = floor(($time_diff % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($time_diff % (60 * 60)) / 60);
        $seconds = $time_diff % 60;

        // Countdown anzeigen
        $output = "Noch verbleibende Zeit bis '<strong>{$event_name}</strong>': ";
        $output .= "{$days} Tage, {$hours} Stunden, {$minutes} Minuten, {$seconds} Sekunden";

        // Countdown zurückgeben
        return $output;
    } else {
        // Falls das Datum überschritten ist
        return "Das Event '<strong>{$event_name}</strong>' hat bereits stattgefunden.";
    }
}

// Shortcode registrieren
add_shortcode('event_countdown', 'event_countdown_shortcode');

// Admin-Menü-Einstellungen hinzufügen
function event_countdown_menu() {
    add_menu_page(
        'Event Countdown Einstellungen',
        'Event Countdown',
        'manage_options',
        'event-countdown',
        'event_countdown_options_page',
        'dashicons-calendar-alt',
        20
    );
}
add_action('admin_menu', 'event_countdown_menu');

// Admin-Einstellungsseite rendern
function event_countdown_options_page() {
    ?>
    <div class="wrap">
        <h1>Event Countdown Einstellungen</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('event_countdown_options');
            do_settings_sections('event-countdown');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Einstellungen registrieren
function event_countdown_settings_init() {
    register_setting('event_countdown_options', 'event_countdown_date');
    register_setting('event_countdown_options', 'event_countdown_name');

    add_settings_section(
        'event_countdown_section',
        'Event Datum, Uhrzeit und Name',
        'event_countdown_section_callback',
        'event-countdown'
    );

    add_settings_field(
        'event_countdown_date',
        'Event Datum (TT.MM.JJJJ HH:MM:SS)',
        'event_countdown_date_render',
        'event-countdown',
        'event_countdown_section'
    );

    add_settings_field(
        'event_countdown_name',
        'Event Name',
        'event_countdown_name_render',
        'event-countdown',
        'event_countdown_section'
    );
}
add_action('admin_init', 'event_countdown_settings_init');

function event_countdown_section_callback() {
    echo 'Bitte geben Sie das Datum, die Uhrzeit und den Namen für das Event ein.';
}

function event_countdown_date_render() {
    $event_date = get_option('event_countdown_date', '');
    echo "<input type='text' name='event_countdown_date' value='" . esc_attr($event_date) . "' size='25'>";
}

function event_countdown_name_render() {
    $event_name = get_option('event_countdown_name', 'Mein Event');
    echo "<input type='text' name='event_countdown_name' value='" . esc_attr($event_name) . "' size='25'>";
}
