<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Support\Str;
//emails
use Illuminate\Support\Facades\Mail;
use App\Mail\MeuEmail;

class LoginController extends Controller
{
    public function login()
    {
        if (!(Auth::check())) {
            return view('login');
        }
        return redirect()->route('redirect');
    }

    public function process(Request $request)
    {
        if (!(Auth::check())) {
            $crendenciais = $request->validate([
                'username' => 'required|exists:users,username',
                'password' => 'required',
            ], [

                'username.required' => 'O nome de usuário é obrigatório',
                'username.exists' => 'Nome de usuário incorreto',
                'password.required' => 'A senha é obrigatória.',
            ]);

            $user = User::where('username', $request->username)->first();
            if ($user?->email_is_valid) {
                if (Auth::attempt($crendenciais)) {
                    return redirect()->route('redirect');
                }
                return redirect()->route('login')->with('errorLogin', 'Senha incorreta');;
            }

            return view('confirmEmail');
        }
        return redirect()->route('redirect');
    }


    public function register()
    {
        if (!(Auth::check())) {
            return view('register');
        }
        return redirect()->route('redirect');
    }


    public function registerDado(Request $request)
    {
        if (!(Auth::check())) {



            $messages = [
                // Mensagens para o campo 'username'
                'username.required' => 'O nome de usuário é obrigatório. Por favor, preencha este campo.',
                'username.max' => 'O nome de usuário não pode ter mais de 17 caracteres.',
                'username.string' => 'O nome de usuário deve ser um texto válido.',
                'username.unique' => 'Este nome de usuário já está em uso. Por favor, escolha outro.',
                'username.regex' => 'O username deve conter apenas letras minúsculas, números e sem espaços.',

                // Mensagens para o campo 'nome'
                'nome.required' => 'O campo Nome é obrigatório. Não pode estar vazio.',
                'nome.max' => 'O nome não pode ter mais de 32 caracteres.',
                'nome.string' => 'O nome deve ser um texto válido.',

                // Mensagens para o campo 'email'
                'email.required' => 'O campo E-mail é obrigatório.',
                'email.email' => 'O formato do E-mail é inválido. Digite um endereço de e-mail correto.',
                'email.unique' => 'Este e-mail já está cadastrado em nosso sistema.',

                // Mensagens para o campo 'password'
                'password.required' => 'A senha é obrigatória. Você precisa definir uma.',
            ];



            $request->validate([
                'username' => 'required|max:17|string|unique:users|regex:/^[a-z0-9_]+$/',
                'nome' => 'required|max:32|string',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ], $messages);

            if ($request->confirmPassword == $request->password) {
                $token = Str::random(60);
                User::create([
                    'username' => $request->username,
                    'nome' => $request->nome,
                    'email' => $request->email,
                    'password' => $request->password,
                    'tokenEmailValidation' => $token,
                ]);

                $dados = [
                    'nome' => $request->nome,
                    'username' => $request->username,
                    'tokenEmailValidation' => $token
                ];


                Mail::to($request->email)->send(new MeuEmail($dados));
            } else {
                return redirect()->route('register')->with('error', 'as senhas tem que ser iguais');
            }
        }
        return view('confirmEmail');
    }



    public function verificarEmail($token, $username)
    {
        if (!(Auth::check())) {
            $user = User::where('username', $username)
                ->where('tokenEmailValidation', $token)
                ->first();
            $perfil = Perfil::where('user_id', $user->id)->first();


            if (!($perfil)) {
                $user->update([
                    'email_is_valid' => 1
                ]);

                Perfil::create([
                    'user_id' => $user->id
                ]);
                return redirect()->route('redirect');
            } else {
                dd('você ja é verificado');
            }
        }
        return redirect()->route('redirect');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');
        }

        return redirect()->route('login');
    }
}
