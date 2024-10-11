<?php
/*
Plugin Name: Event Countdown Shortcode
Plugin URI:  https://example.com
Description: Zeigt einen Countdown zu einem bestimmten Event per Shortcode [event_countdown date="YYYY-MM-DD HH:MM:SS"] an.
Version:     1.0
Author:      Dein Name
Author URI:  https://example.com
License:     GPLv2 or later
*/

function event_countdown_shortcode($atts) {
    // Attribute mit Standardwerten festlegen
    $atts = shortcode_atts(array(
        'date' => '2024-12-31 23:59:59', // Standard-Eventdatum
    ), $atts, 'event_countdown');

    // Datum des Events
    $event_date = strtotime($atts['date']);
    $current_date = time();

    // Berechne den Unterschied in Sekunden
    $time_diff = $event_date - $current_date;

    if ($time_diff > 0) {
        // Tage, Stunden, Minuten und Sekunden berechnen
        $days = floor($time_diff / (60 * 60 * 24));
        $hours = floor(($time_diff % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($time_diff % (60 * 60)) / 60);
        $seconds = $time_diff % 60;

        // Countdown anzeigen
        $output = "<div class='event-countdown'>";
        $output .= "<p>Verbleibende Zeit bis zum Event:</p>";
        $output .= "<p><strong>{$days}</strong> Tage, <strong>{$hours}</strong> Stunden, ";
        $output .= "<strong>{$minutes}</strong> Minuten, <strong>{$seconds}</strong> Sekunden</p>";
        $output .= "</div>";

        // Countdown zurückgeben
        return $output;
    } else {
        // Falls das Datum überschritten ist
        return "<p>Das Event hat bereits stattgefunden.</p>";
    }
}

// Shortcode registrieren
add_shortcode('event_countdown', 'event_countdown_shortcode');

// CSS für Countdown (optional)
function event_countdown_styles() {
    echo "
    <style>
    .event-countdown {
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 20px 0;
    }
    .event-countdown p {
        font-size: 18px;
        margin: 5px 0;
    }
    .event-countdown strong {
        font-size: 24px;
        color: #FF0000;
    }
    </style>
    ";
}
add_action('wp_head', 'event_countdown_styles');