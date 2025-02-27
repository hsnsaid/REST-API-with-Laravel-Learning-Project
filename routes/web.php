<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/setup', function () {
    $cr=[
        'name'=>'admin',
        'email'=>'said@gmail.com',
        'password'=>'7H080255',
    ];
    if(!Auth::attempt($cr)){
        $user = User::create($cr);
        $user->name='admin';
        $user->email=$cr['email'];
        $user->password=$cr['password'];
        $user->save();
    }
    if(Auth::attempt($cr)){
        $user=Auth::user();
        $adminToken=$user->createToken('admin-token',['update','create','delete']);
        $updateToken=$user->createToken('update-token',['update','create']);
        $basicToken=$user->createToken('basic-token',['none']);
        return [
            'admin'=>$adminToken->plainTextToken,
            'update'=>$updateToken->plainTextToken,
            'basic'=>$basicToken->plainTextToken
        ];
    
    }
});
