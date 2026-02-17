<?php

/**
 * Einstellungsuntersuchung Web Routes
 *
 * Diese Datei definiert alle Web-Routes für das Modul.
 *
 * WICHTIG FÜR LLMs:
 * - Routes werden automatisch mit dem Modul-Prefix versehen (aus Config)
 * - Middleware wird automatisch hinzugefügt (web, auth, etc.)
 * - Route-Namen sollten mit dem Modul-Prefix beginnen
 *
 * BEISPIEL:
 * Route::get('/', Dashboard::class)->name('med-entry-exam.dashboard');
 *
 * Wird zu: /med-entry-exam/ (wenn prefix = 'med-entry-exam')
 *
 * @see Platform\Core\Routing\ModuleRouter für Details
 */

use Platform\MedEntryExam\Livewire\Dashboard;
use Platform\MedEntryExam\Livewire\Test;
use Platform\MedEntryExam\Livewire\Sidebar;

/**
 * Dashboard Route
 *
 * Hauptübersicht des Moduls
 */
Route::get('/', Dashboard::class)->name('med-entry-exam.dashboard');

/**
 * Test Route
 *
 * Test-Seite für Entwicklung und Demonstration
 */
Route::get('/test', Test::class)->name('med-entry-exam.test');

/**
 * Weitere Routes hinzufügen:
 *
 * Route::get('/entities', Entity\Index::class)->name('med-entry-exam.entities.index');
 * Route::get('/entities/{entity}', Entity\Show::class)->name('med-entry-exam.entities.show');
 */
