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
<<<<<<< HEAD



Route::get('/',function(){
    dd('123');
});

/************************** admin Routes ********************************/

Route::get('/admin/login',[LoginController::class, 'index'])->name('admin.login');
Route::get('/admin/forgot-password',[LoginController::class, 'forgot_password'])->name('admin.login.forgot_password');
Route::post('/admin/forgot-password-action',[LoginController::class, 'forgot_password_action'])->name('admin.forgot_password.action');
Route::get('/admin/reset-password/{code}', [LoginController::class, 'reset_password'])->name('admin.reset_password');
Route::post('/admin/reset-password-action',[LoginController::class, 'reset_password_action'])->name('admin.reset_password.action');

Route::post('admin/login/login_action',[LoginController::class, 'login_action'])->name('admin.login.login_action');

Route::get('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

//dashboard
Route::get('admin/dashboard',[DashboardController::class, 'index'])->name('admin.dashboard');

//admin user
Route::get('admin/admin',[AdminController::class, 'index'])->name('admin.admin.listing');
Route::post('admin/admin/ajax_listing', [AdminController::class, 'ajax_listing'])->name('admin.admin.ajax_listing');
// --- add user profile details -->
Route::get('admin/admin/add',[AdminController::class, 'add'])->name('admin.admin.add');
Route::post('admin/admin/store',[AdminController::class, 'store'])->name('admin.admin.store');
Route::get('admin/admin/edit/{iAdminId}',[AdminController::class, 'edit'])->name('admin.admin.edit');
//header admin profile --->
Route::get('admin/profile/{iAdminId}',[ProfileController::class, 'index'])->name('admin.profile.edit');
Route::get('admin/profile/change_password/{iAdminId}',[ProfileController::class, 'change_password'])->name('admin.profile.change_password');
Route::post('admin/profile/store',[ProfileController::class, 'store'])->name('admin.profile.store');
// check unique email
Route::post('admin/admin/check_unique_email', [AdminController::class, 'check_unique_email'])->name('admin.admin.check_unique_email');

Route::get('admin/admin/change_password/{iAdminId}',[AdminController::class, 'change_password'])->name('admin.admin.change_password');
Route::post('admin/admin/change_password_action',[AdminController::class, 'change_password_action'])->name('admin.admin.change_password_action');
Route::post('admin/admin/remove_attachment',[AdminController::class, 'remove_attachment'])->name('admin.admin.remove_attachment');

// role
Route::get('admin/role',[RoleController::class, 'index'])->name('admin.role.listing');
Route::post('admin/role/ajax_listing', [RoleController::class, 'ajax_listing'])->name('admin.role.ajax_listing');
Route::get('admin/role/add',[RoleController::class, 'add'])->name('admin.role.add');
Route::post('admin/role/store',[RoleController::class, 'store'])->name('admin.role.store');
Route::get('admin/role/edit/{iUserId}',[RoleController::class, 'edit'])->name('admin.role.edit');

// pagination 
Route::get('admin/pagination',[PaginationController::class, 'index'])->name('admin.pagination.listing');
Route::post('admin/pagination/ajax_listing', [PaginationController::class, 'ajax_listing'])->name('admin.pagination.ajax_listing');
Route::get('admin/pagination/add',[PaginationController::class, 'add'])->name('admin.pagination.add');
Route::post('admin/pagination/store',[PaginationController::class, 'store'])->name('admin.pagination.store');
Route::get('admin/pagination/edit/{iUserId}',[PaginationController::class, 'edit'])->name('admin.pagination.edit');

// permission

Route::get('admin/permission',[PermissionController::class, 'index'])->name('admin.permission.listing');
Route::post('admin/permission/ajax_listing', [PermissionController::class, 'ajax_listing'])->name('admin.permission.ajax_listing');
Route::get('admin/permission/add',[PermissionController::class, 'add'])->name('admin.permission.add');
Route::post('admin/permission/store',[PermissionController::class, 'store'])->name('admin.permission.store');
Route::get('admin/permission/edit/{iUserId}',[PermissionController::class, 'edit'])->name('admin.permission.edit');
// permission modules
Route::post('admin/permission/get_module_by_role',[PermissionController::class, 'get_module_by_role'])->name('admin.permission.get_module_by_role');
// user by role
Route::post('admin/permission/get_user_by_role',[PermissionController::class, 'get_user_by_role'])->name('admin.permission.get_user_by_role');

// menu

Route::get('admin/menu',[MenuController::class, 'index'])->name('admin.menu.listing');
Route::post('admin/menu/ajax_listing', [MenuController::class, 'ajax_listing'])->name('admin.menu.ajax_listing');
Route::get('admin/menu/add',[MenuController::class, 'add'])->name('admin.menu.add');
Route::post('admin/menu/store',[MenuController::class, 'store'])->name('admin.menu.store');
Route::get('admin/menu/edit/{iUserId}',[MenuController::class, 'edit'])->name('admin.menu.edit');
Route::post('admin/menu/fetch_menu',[MenuController::class, 'fetch_menu'])->name('admin.menu.fetch_menu');

// module

Route::get('admin/module',[ModuleController::class, 'index'])->name('admin.module.listing');
Route::post('admin/module/ajax_listing', [ModuleController::class, 'ajax_listing'])->name('admin.module.ajax_listing');
Route::get('admin/module/add',[ModuleController::class, 'add'])->name('admin.module.add');
Route::post('admin/module/store',[ModuleController::class, 'store'])->name('admin.module.store');
Route::get('admin/module/edit/{iUserId}',[ModuleController::class, 'edit'])->name('admin.module.edit');
Route::post('admin/module/search',[ModuleController::class, 'search_module'])->name('admin.module.search_module');

//system_email
Route::get('admin/systememail',[SystemEmailController::class, 'index'])->name('admin.systemEmail.listing');
Route::get('admin/systememail/add',[SystemEmailController::class, 'add'])->name('admin.systemEmail.add');
Route::post('admin/systememail/store',[SystemEmailController::class, 'store'])->name('admin.systemEmail.store');
Route::post('admin/systememail/ajax_listing',[SystemEmailController::class, 'ajax_listing'])->name('admin.systemEmail.ajax_listing');
Route::get('admin/systememail/edit/{iSystemEmailId}',[SystemEmailController::class, 'edit'])->name('admin.systemEmail.edit');

//setting
Route::get('admin/setting/listing',[SettingController::class, 'index'])->name('admin.setting.listing');
Route::post('admin/setting/store',[SettingController::class, 'store'])->name('admin.setting.store');
Route::get('admin/setting/{eConfigType}',[SettingController::class, 'edit'])->name('admin.setting.edit');

//meta
Route::get('admin/meta',[MetaController::class, 'index'])->name('admin.meta.listing');
Route::post('admin/meta/ajax_listing', [MetaController::class, 'ajax_listing'])->name('admin.meta.ajax_listing');
Route::get('admin/meta/add',[MetaController::class, 'add'])->name('admin.meta.add');
Route::post('admin/meta/store',[MetaController::class, 'store'])->name('admin.meta.store');
Route::get('admin/meta/edit/{vUniqueCode}',[MetaController::class, 'edit'])->name('admin.meta.edit');
Route::post('get-method-by-controller',[MetaController::class, 'get_method_by_controller'])->name('get-method-by-controller');


/************************** End of admin Routes *************************/
=======
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
>>>>>>> 594515e (testing)
