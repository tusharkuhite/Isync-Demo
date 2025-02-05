<?php

use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\MenuController;
use App\Http\Controllers\admin\SystemEmailController;
use App\Http\Controllers\admin\ModuleController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\PaginationController;
use App\Http\Controllers\admin\MetaController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAuthentication;


Route::get('/', function () {
    return view('welcome');
});

/************************** Admin Routes ********************************/

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Public Admin Routes (No Authentication Required)
    Route::get('forgot-password', [LoginController::class, 'forgot_password'])->name('login.forgot_password');
    Route::post('forgot-password-action', [LoginController::class, 'forgot_password_action'])->name('forgot_password.action');
    Route::get('reset-password/{code}', [LoginController::class, 'reset_password'])->name('reset_password');
    Route::post('reset-password-action', [LoginController::class, 'reset_password_action'])->name('reset_password.action');
    Route::post('login/login_action', [LoginController::class, 'login_action'])->name('login.login_action');
    
    // Protected Routes (Require Authentication)
    Route::middleware([AdminAuthentication::class])->group(function () {
        
        Route::get('login', [LoginController::class, 'index'])->name('login');
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Admin Users
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('listing');
            Route::post('ajax_listing', [AdminController::class, 'ajax_listing'])->name('ajax_listing');
            Route::get('add', [AdminController::class, 'add'])->name('add');
            Route::post('store', [AdminController::class, 'store'])->name('store');
            Route::get('edit/{iAdminId}', [AdminController::class, 'edit'])->name('edit');
            Route::post('check_unique_email', [AdminController::class, 'check_unique_email'])->name('check_unique_email');
            Route::get('change_password/{iAdminId}', [AdminController::class, 'change_password'])->name('change_password');
            Route::post('change_password_action', [AdminController::class, 'change_password_action'])->name('change_password_action');
            Route::post('remove_attachment', [AdminController::class, 'remove_attachment'])->name('remove_attachment');
        });

        // Profile
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('{iAdminId}', [ProfileController::class, 'index'])->name('edit');
            Route::get('change_password/{iAdminId}', [ProfileController::class, 'change_password'])->name('change_password');
            Route::post('store', [ProfileController::class, 'store'])->name('store');
        });

        // Roles
        Route::prefix('role')->name('role.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('listing');
            Route::post('ajax_listing', [RoleController::class, 'ajax_listing'])->name('ajax_listing');
            Route::get('add', [RoleController::class, 'add'])->name('add');
            Route::post('store', [RoleController::class, 'store'])->name('store');
            Route::get('edit/{iUserId}', [RoleController::class, 'edit'])->name('edit');
        });

        // Pagination
        Route::resource('pagination', PaginationController::class)->except(['show', 'destroy']);

        // Permissions
        Route::prefix('permission')->name('permission.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('listing');
            Route::post('ajax_listing', [PermissionController::class, 'ajax_listing'])->name('ajax_listing');
            Route::get('add', [PermissionController::class, 'add'])->name('add');
            Route::post('store', [PermissionController::class, 'store'])->name('store');
            Route::get('edit/{iUserId}', [PermissionController::class, 'edit'])->name('edit');
            Route::post('get_module_by_role', [PermissionController::class, 'get_module_by_role'])->name('get_module_by_role');
            Route::post('get_user_by_role', [PermissionController::class, 'get_user_by_role'])->name('get_user_by_role');
        });

        // Menus
        Route::prefix('menu')->name('menu.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('listing');
            Route::post('ajax_listing', [MenuController::class, 'ajax_listing'])->name('ajax_listing');
            Route::get('add', [MenuController::class, 'add'])->name('add');
            Route::post('store', [MenuController::class, 'store'])->name('store');
            Route::get('edit/{iUserId}', [MenuController::class, 'edit'])->name('edit');
            Route::post('fetch_menu', [MenuController::class, 'fetch_menu'])->name('fetch_menu');
        });

        // Modules
        Route::prefix('module')->name('module.')->group(function () {
            Route::get('/', [ModuleController::class, 'index'])->name('listing');
            Route::post('ajax_listing', [ModuleController::class, 'ajax_listing'])->name('ajax_listing');
            Route::get('add', [ModuleController::class, 'add'])->name('add');
            Route::post('store', [ModuleController::class, 'store'])->name('store');
            Route::get('edit/{iUserId}', [ModuleController::class, 'edit'])->name('edit');
            Route::post('search', [ModuleController::class, 'search_module'])->name('search_module');
        });
        

        // System Emails
        Route::prefix('systememail')->name('systemEmail.')->group(function () {
            Route::get('/', [SystemEmailController::class, 'index'])->name('listing');
            Route::get('add', [SystemEmailController::class, 'add'])->name('add');
            Route::post('store', [SystemEmailController::class, 'store'])->name('store');
            Route::post('ajax_listing', [SystemEmailController::class, 'ajax_listing'])->name('ajax_listing');
            Route::get('edit/{iSystemEmailId}', [SystemEmailController::class, 'edit'])->name('edit');
        });

        // Settings
        Route::prefix('setting')->name('setting.')->group(function () {
            Route::get('listing', [SettingController::class, 'index'])->name('listing');
            Route::post('store', [SettingController::class, 'store'])->name('store');
            Route::get('{eConfigType}', [SettingController::class, 'edit'])->name('edit');
        });

        // Meta
        Route::prefix('meta')->name('meta.')->group(function () {
            Route::get('/', [MetaController::class, 'index'])->name('listing');
            Route::post('ajax_listing', [MetaController::class, 'ajax_listing'])->name('ajax_listing');
            Route::get('add', [MetaController::class, 'add'])->name('add');
            Route::post('store', [MetaController::class, 'store'])->name('store');
            Route::get('edit/{vUniqueCode}', [MetaController::class, 'edit'])->name('edit');
            Route::post('controller-method', [MetaController::class, 'get_method_by_controller'])->name('controller-method');
        });

    });
});

/************************** End of Admin Routes *************************/
