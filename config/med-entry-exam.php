<?php

/**
 * Einstellungsuntersuchung Configuration
 *
 * Diese Config-Datei definiert die Konfiguration für das Modul.
 *
 * @see Platform\Core\PlatformCore::registerModule() für Details zur Modul-Registrierung
 */

return [
    /**
     * Routing-Konfiguration
     *
     * 'mode': 'path' = /med-entry-exam/... (Standard)
     *         'subdomain' = med-entry-exam.domain.com/... (Alternative)
     * 'prefix': URL-Präfix für alle Routes
     */
    'routing' => [
        'mode' => env('MED_ENTRY_EXAM_MODE', 'path'),
        'prefix' => 'med-entry-exam',
    ],

    /**
     * Guard für Authentication
     * Standard: 'web'
     */
    'guard' => 'web',

    /**
     * Navigation-Konfiguration
     *
     * Definiert, wie das Modul in der Hauptnavigation erscheint.
     * 'route': Route-Name für den Link
     * 'icon': Heroicon-Name (ohne heroicon-o- Präfix)
     * 'order': Sortier-Reihenfolge (niedrigere Zahlen = weiter oben)
     */
    'navigation' => [
        'route' => 'med-entry-exam.dashboard',
        'icon'  => 'heroicon-o-clipboard-document-check',
        'order' => 100,
    ],

    /**
     * Sidebar-Konfiguration
     *
     * Definiert die Sidebar-Struktur für das Modul.
     *
     * Struktur:
     * - 'group': Gruppenname (optional)
     * - 'items': Array von Sidebar-Items
     *   - 'label': Anzeige-Text
     *   - 'route': Route-Name
     *   - 'icon': Heroicon-Name
     *
     * Alternative: 'dynamic' für dynamische Listen (z.B. aus Datenbank)
     *   - 'model': Model-Klasse
     *   - 'team_based': true/false (nach Team filtern)
     *   - 'order_by': Sortier-Feld
     *   - 'route': Basis-Route (wird mit ID erweitert)
     *   - 'icon': Icon für alle Items
     *   - 'label_key': Feldname für Label
     */
    'sidebar' => [
        [
            'group' => 'Einstellungsuntersuchung',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'route' => 'med-entry-exam.dashboard',
                    'icon'  => 'heroicon-o-home',
                ],
                [
                    'label' => 'Test',
                    'route' => 'med-entry-exam.test',
                    'icon'  => 'heroicon-o-beaker',
                ],
            ],
        ],
    ],
];
