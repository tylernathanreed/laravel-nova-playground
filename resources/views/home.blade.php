@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- item template -->
    <p>(You can double click on an item to turn it into a folder.)</p>

    <!-- the demo root element -->
    <treeview tag="ul" class="treeview" :items="tree.items"></treeview>

@endsection
