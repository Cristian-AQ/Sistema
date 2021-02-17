<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['Empleados']=Empleados::paginate(5);
        //paginar la informacion en 5
        return view('empleados.index',$datos);//paso la info de Empleados a index
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //$datosEmpleado=request()->all();/* almacena todo lo q se envia al store en datosEmpleado */

        $campos=[
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
            'Foto' => 'required|max:10000|mines:jpeg,png,jpg',
        ];
        $Mensaje=["required" => 'El :attribute es requerido'];
        
        $this->validate($request,$campos,$Mensaje);
        
        $datosEmpleado=request()->except('_token');

        if($request->hasFile('Foto')){
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }
        Empleados::insert($datosEmpleado);

        //return response()->json($datosEmpleado);
        return redirect('empleados')->with('Mensaje','Empleado agregado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function show(Empleados $empleados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function edit($id)//para recibir solo el id
    {
        //
        $empleado=Empleados::findOrFail($id);//devuelve toda la info que corresponde a ese id

        return view('empleados.edit',compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)//recibe solo el id
    {
        //
        $campos=[
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
        ];

        if($request->hasFile('Foto')){

            $campos+=['Foto' => 'required|max:10000|mines:jpeg,png,jpg'];
        }
        $Mensaje=["required" => 'El :attribute es requerido'];
        
        $this->validate($request,$campos,$Mensaje);

        $datosEmpleado=request()->except(['_token','_method']);//lo q esta en () son datos q no se recepcionan
        
        if($request->hasFile('Foto')){
            $empleado=Empleados::findOrFail($id);
            
            Storage::delete('public/'.$empleado->Foto);
            
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }
        
        Empleados::where('id','=',$id)->update($datosEmpleado);
        
        //$empleado=Empleados::findOrFail($id);//devuelve toda la info que corresponde a ese id
        //return view('empleados.edit',compact('empleado'));
        return redirect('empleados')->with('Mensaje','Empleado modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)//para recibir solo el id
    {
        //
        $empleado=Empleados::findOrFail($id);
            
        if(Storage::delete('public/'.$empleado->Foto)){
           Empleados::destroy($id);
        }

        return redirect('empleados')->with('Mensaje','Empleado eliminado con exito');

    }
}
