<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('filiais')->insert([

            array(
                'filCodigo' => '01',
                'filName' => 'Loja 01',
                'filApelido' => 'L 01',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '05',
                'filName' => 'Loja 05',
                'filApelido' => 'L 05',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '06',
                'filName' => 'Loja 06',
                'filApelido' => 'L 06',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '07',
                'filName' => 'Loja 07',
                'filApelido' => 'L 07',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '08',
                'filName' => 'Loja 08',
                'filApelido' => 'L 08',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '09',
                'filName' => 'Loja 09',
                'filApelido' => 'L 09',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '10',
                'filName' => 'Loja 10',
                'filApelido' => 'L 10',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '11',
                'filName' => 'Loja 11',
                'filApelido' => 'L 11',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '12',
                'filName' => 'Loja 12',
                'filApelido' => 'L 12',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '13',
                'filName' => 'Loja 13',
                'filApelido' => 'L 13',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '16',
                'filName' => 'Loja 16',
                'filApelido' => 'L 16',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '19',
                'filName' => 'Loja 19',
                'filApelido' => 'L 19',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '23',
                'filName' => 'Loja 23',
                'filApelido' => 'L 23',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '25',
                'filName' => 'Loja 25',
                'filApelido' => 'L 25',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '26',
                'filName' => 'Loja 26',
                'filApelido' => 'L 26',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '27',
                'filName' => 'Loja 27',
                'filApelido' => 'L 27',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '28',
                'filName' => 'Loja 28',
                'filApelido' => 'L 28',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '32',
                'filName' => 'Loja 32',
                'filApelido' => 'L 32',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '36',
                'filName' => 'Loja 36',
                'filApelido' => 'L 36',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '38',
                'filName' => 'Loja 38',
                'filApelido' => 'F 38',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '40',
                'filName' => 'Loja 40',
                'filApelido' => 'L 40',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '42',
                'filName' => 'Loja 42',
                'filApelido' => 'L 42',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '43',
                'filName' => 'Loja 43',
                'filApelido' => 'L 43',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '45',
                'filName' => 'Loja 45',
                'filApelido' => 'L 45',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '46',
                'filName' => 'Loja 46',
                'filApelido' => 'L 46',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '49',
                'filName' => 'Loja 49',
                'filApelido' => 'L 49',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '50',
                'filName' => 'Loja 50',
                'filApelido' => 'L 50',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '51',
                'filName' => 'Loja 51',
                'filApelido' => 'L 51',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '90',
                'filName' => 'E-commerce',
                'filApelido' => 'E 90',
                'filRecArquivo' => 0
            ),
            array(
                'filCodigo' => '101',
                'filName' => 'Financeiro',
                'filApelido' => 'Fi',
                'filRecArquivo' => 1
            ),
            array(
                'filCodigo' => '103',
                'filName' => 'Financeiro Contas a Pagar',
                'filApelido' => 'Fi CP',
                'filRecArquivo' => 1
            ),
            array(
                'filCodigo' => '102',
                'filName' => 'Sistemas',
                'filApelido' => 'SI',
                'filRecArquivo' => 0
            )
        ]);

       \DB::table('roles')->insert([
        array(
            'id' => 1,
            'name' => 'financeiro',
            'guard_name' => 'web'
        ),
        array(
            'id' => 2,
            'name' => 'loja',
            'guard_name' => 'web'
        ),
    ]);
        // DB::table('users')->insert([
        //     array(
        //         'id'=>1,
        //         'name' => 'Fernando Roberto',
        //         'email' => 'fernandomirassol@hotmail.com',
        //         'password' => bcrypt('123456789'),
        //         'filCodigo' => 102
        //     ),
        //     array(
        //         'id'=>2,
        //         'name' => 'Nicole',
        //         'email' => 'nicole@moveiscasaverde.com.br',
        //         'password' => bcrypt('123456789'),
        //         'filCodigo' => 101
        //     )
        // ]);






    }
}
