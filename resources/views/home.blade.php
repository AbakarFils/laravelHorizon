@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    <form action="{{route('resize')}}" method="post">
                        {{csrf_field()}}
                        <button class="btn btn-primary">redimentionner</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
