<?php

use Test\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

//refresca la base de datos entre pruebas
uses(Tests\TestCase::class, RefreshDatabase::class);

test("Un usuario no puede eleminarse a si mismo", function (){
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]); //crea un usuario de prueba
   
    $this->actingAs($user, 'web'); //inicia sesion como el usuario creado desde el guard web
    $response = $this->delete(route('admin.users.destroy', $user)); //guardamos la respuesta de la solicitud de eliminación del usuario
    $response->assertStatus(403); //verifica que el usuario no pueda eliminarse a si mismo
    $this->assertDatabaseHas('users', ['id' => $user->id]);
});
