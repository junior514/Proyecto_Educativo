{!! Form::open([
    'url' => 'inicio/grupo_docente',
    'method' => 'GET',
    'autocomplete' => 'off',
    'role' => 'search',
]) !!}
<div class="row">
    <div class="col-md-3 col-12">
        <div class="form-group">
            <input type="text" name="st" class="form-control form-control-sm" value="{{ $st }}" placeholder="Buscar ...">
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="form-group">
            <button type="submit" class="btn btn-default btn-sm text-white" style="background: #365c88">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>

{{ Form::close() }}
