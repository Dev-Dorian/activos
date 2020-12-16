@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
          <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
              {{csrf_field()}}      
            <div class="card-body">
              <h1>Acceder</h1>
              <p class="text-muted">Control de acceso al sistema</p>
                <!--  sirve para enviar le mensaje de iniciar sesion en caso de que lo haga por URL -->
              @if(session()->has('flash'))
                  <div class="alert alert-info">{{ session('flash') }}</div>
              @endif

              <div class="form-group mb-3{{$errors->has('usuario' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                              <!-- metodo old lo mantiene -->
                <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="row">
                <div class="col-6">
                <button type="submit" class="btn btn-primary px-4">Acceder</button>
                 <!-- <button type="button" class="btn btn-primary px-4">Acceder</button>
                 -->
                </div>
                <div class="col-6">
                  <!--<button type="submit" class="btn btn-link px-0">Registrarse</button>
                  <button type="submit" class="btn btn-primary px-4">Registrarse</button>-->
                  <a class="btn btn-primary px-4" href="{{ route('register') }}">Registrarse</a>
                  
                </div>
              </div>
            </div>
            </form>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <h2>Sistema de Activos Fijos</h2>
                <p>Sistema de activos, Depreciaciónes desarrollado en PHP utilizando el Framework Laravel y Vue Js.</p>
                <!--<a href="https://www.udemy.com/user/juan-carlos-arcila-diaz/" target="_blank" class="btn btn-primary active mt-3">Ver el curso!</a>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

<?php

date_default_timezone_set('America/Costa_Rica');
// Conexão com o banco
try {
	$pdo = new PDO("mysql:dbname=dbsistemalaravel;host=localhost", "root", "");
} catch (PDOException $e) {
	echo "ERRO: " . $e->getMessage();
	exit();
}

$ip = $_SERVER['REMOTE_ADDR']; 
// Horário
//$hora = date('H:i:s');
//$hora = date('d/m/Y H:i:s');

$hora = date('Y-m-d H:i:s');

// Adiciona os dados ao banco de dados
$sql = $pdo->prepare("INSERT INTO bitacora_accesos (ip, hora) VALUES (:ip, :hora)");
$sql->bindValue(":ip", $ip);
$sql->bindValue(":hora", $hora);
//$sql = $pdo->prepare("DELETE FROM bitacora_accesos WHERE id=(SELECT MAX(id) FROM bitacora_accesos)");
$sql->execute();

//$sql = "SELECT MAX(id) FROM bitacora_accesos";
//$sql = $pdo->prepare($sql);
//$sql->bindValue(":hora", date('H:i:s', strtotime("-2 minutes")));
//$sql->execute();

// Deleta os dados do banco de dados
//$sql = $pdo->prepare("DELETE FROM bitacora_accesos WHERE id=(SELECT MAX(id) FROM bitacora_accesos)");
//$sql->bindValue(":hora", date('H:i:s', strtotime("-2 minutes")));
//$sql->execute();
// Seleciona dados no banco de dados
//$sql = "SELECT * FROM bitacora_accesos WHERE hora > :hora GROUP BY ip";
//$sql = $pdo->prepare($sql);
//$sql->bindValue(":hora", date('H:i:s', strtotime("-2 minutes")));
//$sql->execute();
//$contagem = $sql->rowCount();

?>