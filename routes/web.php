<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');

    DB::statement('drop table if exists php_users');

    DB::statement('create table php_users (id int auto_increment primary key, name text, age int8)');
    

    DB::unprepared("insert into php_users (name, age) values ('张三2', 10),('Lili2', 11), (10 ,11)");

    $users = DB::select('select * from php_users');
    var_dump($users);
});

