<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{

    // Executar o construct quando instanciar a classe
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:index-course', ['only' => ['index']]);
        $this->middleware('permission:show-course', ['only' => ['show']]);
        $this->middleware('permission:create-course', ['only' => ['create','store']]);
        $this->middleware('permission:edit-course', ['only' => ['edit','update']]);
        $this->middleware('permission:destroy-course', ['only' => ['destroy']]);
    }

    // Listar os cursos
    public function index(Request $request)
    {

        // Recuperar os registros do banco dados
        $courses = Course::when($request->has('name'), function ($whenQuery) use ($request){
            $whenQuery->where('name', 'like', '%' . $request->name . '%');
        })
        ->orderByDesc('created_at')
        ->paginate(40)
        ->withQueryString();

        // Salvar log
        Log::info('Listar curso.', ['action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('courses.index', [
            'menu' => 'courses', 
            'courses' => $courses,
            'name' => $request->name,
        ]);
    }

    // Detalhes do curso
    public function show(Course $course)
    {

        // Salvar log
        Log::info('Visualizar curso.', ['id' => $course->id, 'action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('courses.show', ['menu' => 'courses', 'course' => $course]);
    }

    // Carregar o formulário cadastrar novo curso
    public function create()
    {

        // Salvar log
        Log::info('Carregar formulário cadastrar curso.', ['action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('courses.create', ['menu' => 'courses']);
    }

    // Cadastrar no banco de dados o novo curso
    public function store(CourseRequest $request)
    {

        // Validar o formulário
        $request->validated();

        // Marca o ponto inicial de uma transação
        DB::beginTransaction();

        try {

            // Cadastrar no banco de dados na tabela cursos os valores de todos os campos
            //$course = Course::create($request->all());
            $course = Course::create([
                'name' => $request->name,
                'price' => str_replace(',', '.', str_replace('.', '', $request->price)),
            ]);

            // Salvar log
            Log::info('Curso cadastrado.', ['id' => $course->id, $course, 'action_user_id' => Auth::id()]);

            // Operação é concluída com êxito
            DB::commit();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('course.show', ['course' => $course->id])->with('success', 'Curso cadastrado com sucesso!');
        } catch (Exception $e) {
            // Salvar log
            Log::warning('Curso não cadastrado.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

            // Operação não concluída com êxito
            DB::rollBack();

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('success', 'Curso não cadastrado!');
        }
    }

    // Carregar o formulário editar curso
    public function edit(Course $course)
    {

        // Salvar log
        Log::info('Carregar formulário editar curso.', ['id' => $course->id, 'action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('courses.edit', ['menu' => 'courses', 'course' => $course]);
    }

    // Editar no banco de dados o curso
    public function update(CourseRequest $request, Course $course)
    {

        // Validar o formulário
        $request->validated();

        // Marca o ponto inicial de uma transação
        DB::beginTransaction();

        try {

            // Editar as informações do registro no banco de dados
            $course->update([
                'name' => $request->name,
                'price' => str_replace(',', '.', str_replace('.', '', $request->price)),
            ]);

            // Salvar log
            Log::info('Curso editado.', ['id' => $course->id, 'action_user_id' => Auth::id()]);

            // Operação é concluída com êxito
            DB::commit();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('course.show', ['course' => $request->course])->with('success', 'Curso editado com sucesso!');

        } catch (Exception $e) {
            // Salvar log
            Log::warning('Curso não editado.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

            // Operação não concluída com êxito
            DB::rollBack();

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('success', 'Curso não editado!');
        }
    }

    // Excluir o curso do banco de dados
    public function destroy(Course $course)
    {
        try {
            // Excluir o registro do banco de dados
            $course->delete();

            // Salvar log
            Log::info('Apagar curso.', ['id' => $course->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('course.index')->with('success', 'Curso excluído com sucesso!');

        } catch (Exception $e) {

            // Salvar log
            Log::warning('Curso não apagado.', ['erro' => $e->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('course.index')->with('error', 'Curso não excluído!');

        }
    }
}
