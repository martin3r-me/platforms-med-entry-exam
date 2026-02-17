# LLM Guide für Einstellungsuntersuchung

Diese Datei ist speziell für **Large Language Models (LLMs)** geschrieben, um das Verständnis und die Arbeit mit diesem Modul zu erleichtern.

## Zweck dieses Moduls

Modul für Einstellungsuntersuchungen bei neuen Mitarbeitern.

## Architektur-Übersicht

### Service Provider Pattern

```
MedEntryExamServiceProvider
├── register()          # Config laden (Laravel Best Practice)
└── boot()              # Modul-Registrierung & Setup
    ├── PlatformCore::registerModule()  # Modul registrieren
    ├── ModuleRouter::group()            # Routes laden
    ├── loadMigrationsFrom()             # Migrationen
    ├── loadViewsFrom()                  # Views
    └── registerLivewireComponents()     # Livewire auto-registrieren
```

### Route Pattern

```
Route-Definition: Route::get('/', Dashboard::class)
    ↓
ModuleRouter::group() fügt automatisch hinzu:
    - Prefix: /med-entry-exam
    - Middleware: web, auth, etc.
    ↓
Finale Route: /med-entry-exam/
```

### Livewire Component Pattern

```
Datei: src/Livewire/Dashboard.php
    ↓
Auto-Registrierung via registerLivewireComponents()
    ↓
Alias: med-entry-exam.dashboard
    ↓
Verwendung: <livewire:med-entry-exam.dashboard />
```

## Code-Patterns

### 1. Service Provider

**Pattern:**
```php
public function register(): void {
    // Config laden (MUSS in register() sein!)
    $this->mergeConfigFrom(...);
}

public function boot(): void {
    // 1. Prüfen ob Config & DB vorhanden
    if (config()->has(...) && Schema::hasTable('modules')) {
        // 2. Modul registrieren
        PlatformCore::registerModule([...]);
    }

    // 3. Routes laden (nur wenn registriert)
    if (PlatformCore::getModule('...')) {
        ModuleRouter::group('...', function () {
            $this->loadRoutesFrom(...);
        });
    }

    // 4. Rest registrieren
    $this->loadMigrationsFrom(...);
    $this->loadViewsFrom(...);
    $this->registerLivewireComponents();
}
```

### 2. Livewire Component

**Pattern:**
```php
class Dashboard extends Component {
    public function render() {
        $user = Auth::user();
        $team = $user->currentTeam;

        // Daten laden
        $data = YourModel::where('team_id', $team->id)->get();

        return view('med-entry-exam::livewire.dashboard', [
            'data' => $data,
        ])->layout('platform::layouts.app');
    }
}
```

### 3. View mit Sidebars

**Pattern:**
```blade
<x-ui-page>
    <x-slot name="navbar">...</x-slot>
    <x-ui-page-container>...</x-ui-page-container>
    <x-slot name="sidebar">...</x-slot>
    <x-slot name="activity">...</x-slot>

    {{-- Modals IMMER innerhalb von x-ui-page! --}}
    <livewire:med-entry-exam.modal />
</x-ui-page>
```

### 4. Route-Definition

**Pattern:**
```php
Route::get('/', Dashboard::class)->name('med-entry-exam.dashboard');
Route::get('/entities', Entity\Index::class)->name('med-entry-exam.entities.index');
```

## UI-Komponenten

### Standard-Komponenten

- `x-ui-page` - Haupt-Container
- `x-ui-page-navbar` - Navbar
- `x-ui-page-container` - Hauptinhalt
- `x-ui-page-sidebar` - Sidebar (links/rechts)
- `x-ui-panel` - Panel-Container
- `x-ui-button` - Button
- `x-ui-input-text` - Text-Input
- `x-ui-input-select` - Select
- `x-ui-dashboard-tile` - Statistik-Tile

## Häufige Probleme & Lösungen

### Problem: Routes funktionieren nicht

**Lösung:**
1. Config publiziert? → `php artisan vendor:publish --tag=config`
2. Config-Cache geleert? → `php artisan config:clear`
3. Route-Cache geleert? → `php artisan route:clear`

### Problem: Livewire Component nicht gefunden

**Lösung:**
1. Service Provider registriert? → Prüfe `composer.json`
2. `composer dump-autoload` ausgeführt?
3. Klasse existiert? → Prüfe Namespace

### Problem: Multiple Root Elements Error

**Lösung:**
- Modals müssen **innerhalb** von `<x-ui-page>` sein!
- Nicht außerhalb!

### Problem: Config nicht gefunden

**Lösung:**
- `mergeConfigFrom` muss in `register()` sein, nicht `boot()`!
- Config-Datei muss existieren

## Referenzen

### Ähnliche Module zum Lernen

- **HCM** (`platform/modules/hcm`) - Komplexeres Beispiel
- **Planner** (`platform/modules/planner`) - Modals, erweiterte Features
- **Location** (`platform/modules/location`) - Aktuelles Beispiel

### Core-Klassen

- `Platform\Core\PlatformCore` - Modul-Registrierung
- `Platform\Core\Routing\ModuleRouter` - Route-Handling
- `Platform\ActivityLog\Traits\LogsActivity` - Activity Logging

## Wichtige Konzepte

### Team-basierte Daten

**IMMER** Team-Filterung verwenden:
```php
$user = Auth::user();
$team = $user->currentTeam;
$data = Model::where('team_id', $team->id)->get();
```

### UUIDs

**IMMER** UUIDs für Models verwenden:
```php
use Symfony\Component\Uid\UuidV7;

protected static function booted(): void {
    static::creating(function ($model) {
        if (empty($model->uuid)) {
            do {
                $uuid = UuidV7::generate();
            } while (self::where('uuid', $uuid)->exists());
            $model->uuid = $uuid;
        }
    });
}
```

### Activity Logging

**IMMER** `LogsActivity` Trait verwenden:
```php
use Platform\ActivityLog\Traits\LogsActivity;

class Model extends Model {
    use LogsActivity;
    // ...
}
```

## Nächste Schritte

Nach dem Erstellen des Basis-Moduls:

1. **Models hinzufügen** - In `src/Models/`
2. **Migrationen erstellen** - In `database/migrations/`
3. **Livewire Components erweitern** - Index, Show, Create, Edit
4. **Routes erweitern** - Für neue Views
5. **Policies erstellen** - Für Authorization
6. **Tests schreiben** - Für wichtige Funktionen
