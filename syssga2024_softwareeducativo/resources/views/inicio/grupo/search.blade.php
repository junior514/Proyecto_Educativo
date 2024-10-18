{!! Form::open([
    'url' => 'inicio/grupo',
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
            <select class="form-control form-control-sm selectpicker" name="st2" data-live-search="true">
                <option value="-1">Todos los docentes</option>
                @foreach($docentes as $d)
                    <option value="{{$d->idDocente}}" {{$d->idDocente == $st2 ? 'selected' : ''}} style="font-size: 0.85em">{{$d->nomDoc}}</option>
                @endforeach
            </select>
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
