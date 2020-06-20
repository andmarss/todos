@extends('layouts.app')

@section('title', 'Todo index')

@section('content')
    <div class="container">
        <todos v-bind:todos="`{{json_encode($todos->all())}}`"></todos>
    </div>
@stop