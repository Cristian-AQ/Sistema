@extends('layouts.app')

@section('content')
<div class="container">
<form action="{{url('/empleados/'.$empleado->id)}}" method="post" action="" enctype="multipart/form-data">//enctype para realizar la edicion
{{csrf_field()}}
{{method_field('PATCH')}}//permite acceder al update
@include('empleados.form',['Modo'=>'editar'])

</form>
</div>
@endsection