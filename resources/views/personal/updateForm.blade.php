@extends('plantilla.master')

@section('menu') 
  @include('menus.adm') 
@endsection 

@section('tituloPag') 
    MODIFICANDO PERSONAL
@endsection

@section('subtituloPag')
    COGNOS
@endsection

@section('contenido')
@if($errors->all())
    <div class="alert alert-warning" role="alert">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
</br>
<div class="col-md-2"></div>
<div class="col-md-8 col-sm-12 col-12">
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <form name="form" id="form" role="form" method="POST" action="{{ url('updatePersonal') }}">
            {{ csrf_field() }}
            @foreach ($persona as $ke => $p)
            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nombre *:</label>
                    <input class="form-control" name="nom" id="nom" placeholder="Nombre" type="text" value="{{ $p->nombre }}" required>
                    <input type="hidden" name="id_pe" id="id_pe" value="{{ $p->id_pe }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Apellidos *:</label>
                    <input class="form-control" name="ape" id="ape" placeholder="Apellidos" type="text" value="{{ $p->apellidos }}" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Carnet de Identidad:</label>
                    <input class="form-control" name="ci" id="ci" placeholder="C.I." type="text" value="{{ $p->ci }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Expedido en:</label>
                    <select class="form-control" name="depto" id="depto">
                        @foreach ($depto as $key => $d)
                            @if ($p->expedido == $d->id_dep)
                                <option value="{{ $d->id_dep }}" selected>{{ $d->nombre }}</option>
                            @else
                                <option value="{{ $d->id_dep }}">{{ $d->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Teléfono de Domicilio:</label>
                    <input class="form-control" name="td" id="td" placeholder="Teléfono" type="text" value="{{ $p->tel_dom }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Teléfono de Oficina:</label>
                    <input class="form-control" name="to" id="to" placeholder="Teléfono" type="text" value="{{ $p->tel_of }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Número de Celular *:</label>
                    <input class="form-control" name="cel" id="cel" placeholder="Celular" type="text" value="{{ $p->celular }}" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email *:</label>
                    <input class="form-control" name="email" id="email" placeholder="Email" type="text" value="{{ $p->email }}" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Cargo *:</label>
                    <select class="form-control" name="car" id="car" required>
                        @foreach ($cargo as $ke => $c)
                            @if ($p->id_ca == $c->id_ca)
                                <option value="{{ $c->id_ca }}" selected>{{ $c->nombre }}</option>
                            @else 
                                <option value="{{ $c->id_ca }}">{{ $c->nombre }}</option>   
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            @endforeach
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="guardar" id="guardar">MODIFICAR</button>
                <a href="{{ url('findPersonal') }}" class="btn btn-danger">CANCELAR</a>
            </div>
        </form>
    </div>
</div>
<div class=" col-md-2"></div>

@endsection

@section('extra')
$('#form input[type=text]').on('change invalid', function() {
    var campotexto = $(this).get(0);

    campotexto.setCustomValidity('');

    if (!campotexto.validity.valid) {
      campotexto.setCustomValidity('Esta información es requerida');  
    }
    else{
        $('#guardar').on('click', function(){
            $(this).attr('disabled',true);
        });
    }
});
@endsection