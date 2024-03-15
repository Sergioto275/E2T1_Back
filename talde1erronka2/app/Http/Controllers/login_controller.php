<?php

namespace App\Http\Controllers;
use App\Models\Login;

use Illuminate\Http\Request;

class login_controller extends Controller
{
    public function comprobarDatos(Request $request){
        $belajar = Login::all();
        $datos = $request->all();
        for($i=0;$i<count($belajar);$i++){
            if(password_verify($datos["pasahitza"],$belajar[$i]["pasahitza"])==true && $belajar[$i]["username"] === $datos["username"] ){
                return response()->json("Esta bien", 200);

            }
        }
        return response()->json("Error",404);

    }

    public function crearUsuarios(Request $request){
        $datos = $request->all();
        $pass_crypt = password_hash($datos["pasahitza"], PASSWORD_BCRYPT); 
        $data = ["username"=>$datos["username"],"pasahitza"=>$pass_crypt,"rola"=>$datos["rola"]];
        Login::insert($data);   
    }
}
