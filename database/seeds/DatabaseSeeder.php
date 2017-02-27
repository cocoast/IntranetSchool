<?php
use App\Apoderado;
use App\Docente;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();

       factory(Apoderado::class)->times(50)->create();
       factory(Docente::class)->times(50)->create();

        //Model::reguard();
    }
}
