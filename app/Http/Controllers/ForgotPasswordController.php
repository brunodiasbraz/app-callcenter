<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // Carregar o formulário recuperar senha
    public function showForgotPassword()
    {
        // Carregar a VIEW
        return view('login.forgotPassword');
    }

    // Receber dados do formulário recuperar senha
    public function submitForgotPassword(Request $request)
    {
        // Validar o formulário
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Necessário enviar e-mail válido.'
        ]);

        // Verificar se existe usuário no banco de dados com o e-mail
        $user = User::where('email', $request->email)->first();

        if (!$user) {

            // Salvar log
            Log::warning('Tentativa recuperar senha com e-mail não cadastrado.', ['email' => $request->email]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'E-mail não encontrado!');
        }

        try {
            // Salvar o token recuperar senha e enviar e-mail
            $status = Password::sendResetLink(
                $request->only('email')
            );

            // Salvar log
            Log::info('Recuperar senha', ['resposta' => $status, 'email' => $request->email]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('login.index')->with('success', 'Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!');
        } catch (Exception $e) {

            // Salvar log
            Log::warning('Erro recuperar senha.', ['error' => $e->getMessage(), 'email' => $request->email]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Erro: Tente mais tarde!');
        }
    }

    // Carregar o formulário atualizar senha
    public function showResetPassword(Request $request)
    {

        // Carregar a VIEW
        return view('login.resetPassword', ['token' => $request->token]);
    }


    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            $status = Password::reset(

                $request->only('email', 'password', 'password_confirmation', 'token'),

                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ]);

                    $user->save();
                }
            );

            // Salvar log
            if ($status === Password::PASSWORD_RESET) {
                Log::info('Senha atualizada.', ['resposta' => $status, 'email' => $request->email]);
            } else {
                Log::info('Senha não atualizada.', ['resposta' => $status, 'email' => $request->email]);
            }

            // Redirecionar o usuário, enviar a mensagem de erro
            return $status === Password::PASSWORD_RESET ? redirect()->route('login.index')->with('success', 'Senha atualizada com sucesso!') : /*back()->withInput()->with('error', __($status))*/ redirect()->route('login.index')->with('error', __($status));
        } catch (Exception $e) {

            // Salvar log
            Log::warning('Erro atualizar senha.', ['email' => $request->email, 'error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Erro: Tente mais tarde!');
        }
    }
}
