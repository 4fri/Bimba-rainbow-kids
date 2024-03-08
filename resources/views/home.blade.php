@extends('layouts.app')

@section('content')
    <header class="py-3 px-4 m-md-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <h3>Welcome, {{ Auth::user()->name }}</h3>
                </li>
            </ol>
        </nav>
    </header>
@endsection
