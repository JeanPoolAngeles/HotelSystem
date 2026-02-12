<div class="box box-info padding-1">
    <div class="box-body row">
        <div class="form-group col-md-2">
            {{ Form::label('dni') }}
            {{ Form::text('dni', $empleado->dni ?? '', ['class' => 'form-control' . ($errors->has('dni') ? ' is-invalid' : ''), 'placeholder' => 'DNI', 'id' => 'dni']) }}
            {!! $errors->first('dni', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-8">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $empleado->nombre ?? '', ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre', 'id' => 'nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('telefono') }}
            {{ Form::text('telefono', $empleado->telefono ?? '', ['class' => 'form-control' . ($errors->has('telefono') ? ' is-invalid' : ''), 'placeholder' => 'Teléfono', 'id' => 'telefono']) }}
            {!! $errors->first('telefono', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('correo') }}
            {{ Form::text('correo', $empleado->correo ?? '', ['class' => 'form-control' . ($errors->has('correo') ? ' is-invalid' : ''), 'placeholder' => 'Correo', 'id' => 'correo']) }}
            {!! $errors->first('correo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-3">
            {{ Form::label('sueldo') }}
            {{ Form::number('correo', $empleado->correo ?? '', ['class' => 'form-control' . ($errors->has('correo') ? ' is-invalid' : ''), 'placeholder' => 'Correo', 'id' => 'correo']) }}
          
            {!! $errors->first('sueldo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-5">
            {{ Form::label('direccion') }}
            {{ Form::textarea('direccion', $empleado->direccion ?? '', ['class' => 'form-control' . ($errors->has('direccion') ? ' is-invalid' : ''), 'placeholder' => 'Dirección', 'rows' => 3, 'id' => 'direccion']) }}
            {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-3">
            {{ Form::label('rol') }}
            {{ Form::select('rol', ['mozo' => 'Mozo', 'cocinero' => 'Cocinero', 'cajero' => 'Cajero', 'administrador' => 'Administrador'], $empleado->rol ?? '', ['class' => 'form-control' . ($errors->has('rol') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona un rol', 'id' => 'rol']) }}
            {!! $errors->first('rol', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="box-footer mt20 text-right">
        <a href="{{ route('admin.empleados.index') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('dni').readOnly = true;
        document.getElementById('nombre').readOnly = true;
    });
</script>
