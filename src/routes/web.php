<?php

use Illuminate\Support\Facades\Route;
use Isync\Demo\Demo;



Route::get('/super-admin', [Demo::class, 'index']);
Route::post('/super-admin/create', [Demo::class, 'create'])->name('superadmin.create');
Route::post('/super-admin/table-fields', [Demo::class, 'table_fields'])->name('superadmin.get.table_fields');