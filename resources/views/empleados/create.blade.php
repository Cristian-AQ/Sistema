@extends('layouts.app')

@section('content')
<div class="container">
@if (count($errors)>0)
<div class="alert alert-danger" role="alert">
    <url>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
    </ul>
</div>
@endif
Seccion para crear empleados
<form method="post" action="{{url('/empleados')}}" class="form-horizontal" enctype="multipart/form-data">
{{ csrf_field() }}
@include('empleados.form',['Modo'=>'crear'])//para distinguir formulario

</form>
</div>
@endsection

