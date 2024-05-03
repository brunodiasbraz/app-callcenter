<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class TrunksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:index-trunks', ['only' => ['index']]);
        $this->middleware('permission:create-trunks', ['only' => ['create','store', 'edit']]);
        $this->middleware('permission:destroy-trunks', ['only' => ['destroy']]);

    }

    public function index(Request $request){

        $trunks = DB::connection('pgsql_asterisk')->select('SELECT * FROM public.ps_endpoint_id_ips;');

        Log::info('Listar Troncos.', ['action_user_id' => Auth::id()]);

        return view('trunks.index', [
            'menu' => 'trunks',
            'title' => $request->title,
            'name' => $request->name,
            'trunks' => $trunks,
        ]);
      }

}
