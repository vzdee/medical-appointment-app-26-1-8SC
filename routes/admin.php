<?php 
  use App\Http\Controllers\Admin\PatientController;
  use App\Http\Controllers\Admin\UserController;
  use Illuminate\Support\Facades\Route;
  use App\Http\Controllers\Admin\RoleController;


  Route::get('/', function(){
    return view('admin.dashboard');
  })->name('dashboard');

  //Gestion de roles
  Route::resource('roles', RoleController::class);

  //userscontroller
  Route::resource('users', UserController::class);

  //patientcontroller
  Route::resource('patients', PatientController::class);
?>