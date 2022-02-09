<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Usuarios;
class DatabaseSeeder extends Seeder

{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
    
        Usuarios::insert (

            [
                'Usuario' => 'docente' , 
                'Contrasena' => bcrypt('123456'),
            'Email' => 'doc@gmail.com',
             'Estado' =>'A',
            'Nombres' => 'Presta',
            'Apellidos' => 'Jota',
            'Documento' => 39111232,
            'EsSuperAdministrador' => 'N',
            ]
        
          );
    }
}
