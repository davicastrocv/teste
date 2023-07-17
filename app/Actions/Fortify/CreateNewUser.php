<?php

namespace App\Actions\Fortify;

use App\Models\FilialModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {


        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:users,email', 'email'],
            'filial' => ['required', 'integer'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();


        //BUSCA FILIAIS COM PERMISSÃO DE RECEBER ARQUIVOS
        $filiais = FilialModel::where('filRecArquivo', 1)->get();
        $enviaArquivos = array();
        foreach ($filiais as $f) {
            $enviaArquivos[] =  $f->filCodigo;
        }

        // $role = (in_array($input['filial'],$enviaArquivos))?'financeiro':'loja';//SETA VISUALIAÇÃO DE MENU
        if (in_array($input['filial'], $enviaArquivos)) {
            if ($input['filial'] == 103 or $input['filial'] == 101) {
                $role = 'financeiro';
            }else{
                $role = 'geral';
            }
        } else {
            $role = 'loja';
        }


        return User::create([
            'name' => $input['name'],
            'filCodigo' => $input['filial'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ])->assignRole($role);
    }
}
