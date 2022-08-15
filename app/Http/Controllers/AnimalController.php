<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\animal;
use App\Models\tipoanimal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class AnimalController extends Controller
{
    public function register(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:8',
        ]);
        User::create([
            'name' => $validData['name'],
            'email' => $validData['email'],
            'password' => Hash::make($validData['password']),
        ]);
        return response()->json(['message' => 'Usuario registrado'], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('name', 'password'))) {
            return response()->json(['message' => 'Credenciales invalidas'], 401);
        }
        //$user = User::all();
        $user = User::where('name', $request->name)->first();
        $token = $request->user()->createToken('auth_token')->plainTextToken;
        return response()->json(
            [
                'accesToken'=>$token,
                'tokenType'=>'Bearer',
            ],
            200
        );
    }

    public function showAnimal()
    {
        $animal = animal::where('eliminado', 1)->get();
        return response()->json($animal, 200);
    }

    public function showTipo()
    {
        $t = tipoanimal::where('eliminado', 1)->get();
        return response()->json($t, 200);
    }


    public function registerAnimal(Request $request)
    {
        $validData = $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'required|string|max:255',
            'id_tipo' => 'required',
        ]);
        animal::create([
            'nombre' => $validData['nombre'],
            'foto' => $validData['foto'],
            'id_tipo' => $validData['id_tipo'],
            'eliminado' => 1,
        ]);
        return response()->json(['message' => 'animal registrado'], 201);
    }

    public function buscaranimal($buscar)
    {
        $animal = DB::table('animals')
        ->join('tipoanimals', 'animals.id_tipo','=','tipoanimals.id' )
        ->select('animals.nombre', 'animals.foto', 'animals.nombre', 'tipoanimals.tipo as tipo')
        ->where('tipoanimals.tipo', $buscar)
       ->get();
        if (is_null($animal)) {
            return response()->json(['message' => 'tipo de animal no encontrado'], 404);
        }
        return response()->json($animal, 200); 
    } 

    public function destroyAnimal($id)
    {
        $animal = animal::find($id);
        if (is_null($animal)) {
            return response()->json(['message' => 'animal no encontrado'], 404);
        }
        $animal->eliminado = 0;
        $animal->save();
        return response()->json(['message' => 'eliminado'], 200);
    }

    public function reporte()
    {
       
        $e=DB::table('animals')
        ->join('tipoanimals', 'animals.id_tipo','=','tipoanimals.id' )
        ->select('animals.*', 'tipoanimals.tipo as tipo')
        ->where('animals.eliminado',1)->get();
        
         return PDF::loadView('welcome', compact('e'))
        ->dowload('archivo.pdf');
    } 
}
