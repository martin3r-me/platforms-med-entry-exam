# Platform Einstellungsuntersuchung

Modul für Einstellungsuntersuchungen bei neuen Mitarbeitern.

## Übersicht

Dieses Modul verwaltet Einstellungsuntersuchungen:
- Service Provider mit Modul-Registrierung
- Config-Datei mit Navigation und Sidebar
- Routes (Dashboard + Test-Seite)
- Livewire Components (Dashboard, Sidebar, Test)
- Views mit beiden Sidebars (links & rechts)

## Struktur

```
med-entry-exam/
├── composer.json              # Package-Definition
├── config/
│   └── med-entry-exam.php    # Modul-Konfiguration
├── database/
│   └── migrations/            # Migrationen (optional)
├── resources/
│   └── views/
│       └── livewire/
│           ├── dashboard.blade.php    # Dashboard-View
│           ├── test.blade.php         # Test-Seite
│           └── sidebar.blade.php      # Sidebar-View
├── routes/
│   └── web.php                # Web-Routes
├── src/
│   ├── MedEntryExamServiceProvider.php  # Service Provider
│   └── Livewire/
│       ├── Dashboard.php       # Dashboard Component
│       ├── Test.php           # Test Component
│       └── Sidebar.php        # Sidebar Component
└── README.md                   # Diese Datei
```

## Wichtige Komponenten

### Service Provider

Der `MedEntryExamServiceProvider` ist das Herzstück des Moduls:

1. **register()**: Config wird hier geladen (Laravel Best Practice)
2. **boot()**:
   - Modul wird bei PlatformCore registriert
   - Routes werden geladen (nur wenn Modul aktiv)
   - Views und Livewire-Komponenten werden registriert

### Config-Datei

Die Config (`config/med-entry-exam.php`) definiert:
- **routing**: Route-Modus (path/subdomain) und Prefix
- **navigation**: Hauptnavigation (Icon, Route, Order)
- **sidebar**: Sidebar-Struktur für das Modul

### Routes

- `/med-entry-exam` → Dashboard
- `/med-entry-exam/test` → Test-Seite

### Livewire Components

- **Dashboard**: Hauptübersicht
- **Test**: Test-Seite für Entwicklung
- **Sidebar**: Modul-spezifische Sidebar

## Composer registrieren

Füge das Modul zur Hauptanwendung hinzu:

**In `composer.json` der Hauptanwendung:**
```json
{
  "require": {
    "martin3r/platforms-med-entry-exam": "dev-main"
  },
  "repositories": [
    {
      "type": "path",
      "url": "../platform/modules/med-entry-exam"
    }
  ]
}
```

Dann:
```bash
composer update
```

### Config publizieren (optional)

```bash
php artisan vendor:publish --tag=config --provider="Platform\MedEntryExam\MedEntryExamServiceProvider"
```
