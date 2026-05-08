<?php 
  use App\Http\Controllers\Admin\PatientController;
  use App\Http\Controllers\Admin\UserController;
  use Illuminate\Support\Facades\Route;
  use App\Http\Controllers\Admin\RoleController;
  use App\Http\Controllers\Admin\AppointmentController;
  use App\Http\Controllers\Admin\DoctorController;
  use App\Http\Controllers\Admin\CalendarController;

  Route::get('/', function(){
    return view('admin.dashboard');
  })->name('dashboard');

  //Gestion de roles
  Route::resource('roles', RoleController::class);

  //userscontroller
  Route::resource('users', UserController::class);

  //patientcontroller
  Route::resource('patients', PatientController::class);

  // Doctors
  Route::get('doctors/{doctor}/schedules', [DoctorController::class, 'schedules'])->name('doctors.schedules');
  Route::resource('doctors', DoctorController::class);

  // Gestión de citas
  Route::resource('appointments', AppointmentController::class);
 
  // Calendario
  Route::resource('calendar', CalendarController::class);
?>