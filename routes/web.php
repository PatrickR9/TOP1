<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\BibleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MediaController;
use App\Http\Middleware\IsEditAuthorised;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserroleController;
use App\Http\Controllers\UsersiteController;
use App\Http\Controllers\LocalAuthController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\OrganisationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

# Local Auth
Route::get('/local-auth', [LocalAuthController::class, 'selectUserForm'])->name('local.auth');
Route::post('/local-auth', [LocalAuthController::class, 'login']);

# Keycloak SSO
Route::get('/', [LoginController::class, 'redirectToProvider']);
Route::get('/login', [LoginController::class, 'redirectToProvider'])->name('login');
Route::get('/callback', [LoginController::class, 'handleProviderCallback']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/image/{mediaId}', [MediaController::class, 'showImage'])->name('image.show');

Route::middleware(['auth'])->group(function () {
    # TEST
    Route::get('/redir', [EditorController::class, 'redirectExtern']);

    # ADMIN AREA
    Route::middleware([IsAdmin::class])->group(function () {
        Route::get('/users', [ManagementController::class, 'users']);
        Route::get('/user_roles', [UserroleController::class, 'index']);
        Route::match(['get', 'post'], '/user/{id}', [ManagementController::class, 'user']);
        Route::get('/aboversum', [ManagementController::class, 'aboversum']);
        Route::get('/authors', [ManagementController::class, 'authors']);
        Route::match(['get', 'post'],'/editorials', [ManagementController::class, 'editorials']);
        Route::match(['get', 'post'], '/organisations', [ManagementController::class, 'organisations']);
        Route::match(['get', 'post'], '/organisation/{id}', [ManagementController::class, 'organisation']);
    });

    # EDITOR AREA
    Route::middleware([IsEditAuthorised::class])->group(function () {
    # SITE EDITOR
        Route::get('/contents', [ManagementController::class, 'contents']);
        Route::get('/content/create', [UsersiteController::class, 'create'])->name('content.create');
        Route::get('/content/{id}/edit', [UsersiteController::class, 'edit'])->name('content.edit');
        Route::get('/content/{id}/content', [UsersiteController::class, 'editContent'])->name('content.content');
        Route::get('/content/{id}/materials', [UsersiteController::class, 'editContentMaterials'])->name('content.materials');
        Route::get('/content/{id}/properties', [UsersiteController::class, 'editContentProperties'])->name('content.properties');
        Route::get('/content/{id}/contributioncheck', [UsersiteController::class, 'contributionCheck'])->name('content.contributioncheck');
        Route::get('/content/{id}/settings', [UsersiteController::class, 'settings'])->name('content.settings');
        Route::get('/sites', [ManagementController::class, 'sites']);
        Route::get('/site/{id}', [UsersiteController::class, 'showSite']);
// to delete        Route::post('/update_content', [UsersiteController::class, 'updateContent']);
        Route::post('/dc_insert', [EditorController::class, 'dComponentInsert']);
        Route::post('/site_cmenu', [EditorController::class, 'siteCmenu']);
        Route::get('/bible', [BibleController::class, 'index']);
//        Route::post('/site_update', [UsersiteController::class, 'update']);
    });

    # PERSONAL DATA
    Route::get('/profil/personal_data', [PersonController::class, 'show'])->name('person_data.show');
    
    # DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

}); ## END OF AUTH

# DYNAMIC SITES FOR EVERBODY
Route::get('/{level1}', [UsersiteController::class, 'index']);
Route::get('/{level1}/{level2}', [UsersiteController::class, 'index']);
Route::get('/{level1}/{level2}/{level3}', [UsersiteController::class, 'index']);
Route::get('/{level1}/{level2}/{level3}/{level4}', [UsersiteController::class, 'index']);
