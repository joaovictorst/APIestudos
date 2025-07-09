<?php

namespace Routes;

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\WorkspaceController;
use App\Controllers\VaultController;
use App\Controllers\ItemController;
use App\Controllers\SettingsController;
use App\Controllers\RoleController;
use App\Controllers\MemberController;

// Autenticação
Router::post('/api/register', AuthController::class . '@register');
Router::post('/api/login', AuthController::class . '@login');

// Workspaces
Router::get('/api/workspaces', WorkspaceController::class . '@index');   // Listar
Router::post('/api/workspaces', WorkspaceController::class . '@store');  // Criar

// Cofres
Router::get('/api/workspaces/{id}/vaults', VaultController::class . '@index'); // Listar cofres de um workspace
Router::post('/api/vaults', VaultController::class . '@store');              // Criar cofre

// Itens
Router::get('/api/vaults/{id}/items', ItemController::class . '@index'); // Listar itens de um cofre
Router::post('/api/items', ItemController::class . '@store');           // Criar item
Router::put('/api/items/{id}', ItemController::class . '@update');       // Atualizar item
Router::delete('/api/items/{id}', ItemController::class . '@destroy');   // Remover item

// Configurações do usuário
Router::get('/api/settings', SettingsController::class . '@show');
Router::put('/api/settings', SettingsController::class . '@update');

// Roles & Members
Router::get('/api/roles', RoleController::class . '@index');
Router::post('/api/roles', RoleController::class . '@store');
Router::put('/api/roles/{id}', RoleController::class . '@update');
Router::delete('/api/roles/{id}', RoleController::class . '@destroy');

Router::get('/api/members', MemberController::class . '@index');
Router::post('/api/members', MemberController::class . '@store');
Router::put('/api/members/{id}', MemberController::class . '@update');
Router::delete('/api/members/{id}', MemberController::class . '@destroy');
