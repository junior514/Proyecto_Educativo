@extends('layouts.app')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-end">

        <div class="col-lg-3 col-md-5 col-sm-6 col-12">
            <div class="row">
                <div class="col-12 text-center">
                    <img src="{{ asset('dist/img/logo_paulmuller.jpeg') }}" width="120px">
                </div>
            </div>
               
            <div class="card mt-2">
                <div class="card-header text-center pt-4">
                    <h3>{{ __('Ingresar al sistema') }}</h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="nroDoc">{{ __('N° Documento') }}</label>
                                <input id="nroDoc" type="text" class="form-control @error('nroDoc') is-invalid @enderror" name="nroDoc" value="{{ old('nroDoc') }}" required autocomplete="nroDoc" autofocus>

                                @error('nroDoc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="password">{{ __('Contraseña') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row mb-0">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Ingresar') }}
                                </button>
                            </div>
                            <div class="col-12">
                                 @if (Route::has('password.request'))
                                    <a class="btn btn-link" style="text-decoration:none" href="{{ route('password.request') }}">
                                        {{ __('¿Olvidaste tu contraseña?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
