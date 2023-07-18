<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
 
class UsersController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::statement('drop table if exists php_users');

        DB::statement('create table php_users (id int auto_increment primary key, name text, age int8)');
        
        DB::unprepared("insert into php_users (name) values ('张三'),('Lili'), (10)");

        $users = DB::select('select * from php_users');
        \print_r($users);

        $users = DB::select('select * from php_users where id > ?', [1]);
        \print_r($users);

        $users = DB::connection()->select('select * from php_users');
        \print_r($users);

        $users = DB::connection('oscardb')->select('select * from php_users');
        \print_r($users);

        $id = DB::connection('oscardb')->table('php_users')->insertGetId(
            ['name' => 'john@example.com'], 'id'
        );

        \print_r($id);

        DB::insert('insert into php_users (name) values (?)', ['Marc']);
        $users = DB::select('select * from php_users');
        \print_r($users);


        $affected = DB::update(
            'update php_users set name = ? where id = 1',
            ['Anita']
        );

        \print_r("\n affected:".$affected);

        $deleted = DB::delete('delete from php_users where id = 1');

        \print_r("\n deleted:".$deleted);

        DB::transaction(function () {
            DB::update('update php_users set name = ? where id = 2', ['李四']);
         
            DB::delete('delete from php_posts');
            DB::rollBack();
        }, 2);

        $users = DB::select('select * from php_users where id = 2');
        \print_r($users);
 
        return view('users_index', ['users' => $users]);
    }
}