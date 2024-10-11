# Event Countdown Shortcode

**Contributors:** Dein Name  
**Tags:** countdown, event, shortcode, date  
**Requires at least:** 5.0  
**Tested up to:** 6.3  
**Stable tag:** 1.0  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

Ein einfaches WordPress-Plugin, das einen Countdown zu einem bestimmten Datum und einer bestimmten Uhrzeit anzeigt. Verwenden Sie den Shortcode `[event_countdown date="YYYY-MM-DD HH:MM:SS"]`, um die verbleibende Zeit bis zu einem Ereignis in deutscher Sprache anzuzeigen.

## Beschreibung

Das **Event Countdown Shortcode**-Plugin ermöglicht es Ihnen, einen Countdown zu einem bestimmten Datum und einer bestimmten Uhrzeit auf Ihrer Website anzuzeigen. Es ist einfach zu bedienen, und der Countdown wird automatisch aktualisiert, um die verbleibenden Tage, Stunden, Minuten und Sekunden anzuzeigen. Sobald das Datum erreicht ist, zeigt das Plugin eine Nachricht an, dass das Event bereits stattgefunden hat.

### Hauptfunktionen:
- Zeigt einen Countdown in Tagen, Stunden, Minuten und Sekunden an.
- Formatierte Ausgabe in deutscher Sprache.
- Einfacher Shortcode `[event_countdown date="YYYY-MM-DD HH:MM:SS"]`.
- Der Countdown wird automatisch aktualisiert.
- Zeigt eine Nachricht an, wenn das Ereignisdatum bereits vergangen ist.

## Installation

1. Lade den Ordner `event-countdown` in dein `wp-content/plugins` Verzeichnis hoch oder installiere das Plugin direkt über die WordPress Plugin-Bibliothek.
2. Aktiviere das Plugin über das Menü „Plugins“ in WordPress.
3. Füge den Shortcode `[event_countdown date="YYYY-MM-DD HH:MM:SS"]` in einen Beitrag oder eine Seite ein.

## Anleitung

### Shortcode verwenden

Verwenden Sie den Shortcode `[event_countdown]`, um den Countdown zu einem bestimmten Datum auf Ihrer Seite oder in einem Beitrag anzuzeigen. Sie können das Datum und die Uhrzeit des Events durch das `date`-Attribut festlegen.

**Beispiel:**

```plaintext
[event_countdown date="2024-12-31 23:59:59"]