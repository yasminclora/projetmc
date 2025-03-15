@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <!-- Section Informations personnelles -->
                    <div class="mt-4">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#personalInfo" aria-expanded="false" aria-controls="personalInfo">
                            Informations personnelles
                        </button>

                        <div class="collapse mt-3" id="personalInfo">
                            <div class="card card-body">
                                <p><strong>Nom :</strong> {{ Auth::user()->name }}</p>
                                <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
                                <!-- Ajoutez d'autres informations ici si nécessaire -->
                            </div>
                        </div>
                    </div>

                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection