@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Bitacora</h1>
@stop

@section('content')
    @section('plugins.PluginName', true)
    @livewire('security.logs-index')
@stop

@section('css')
    
@stop

@section('js')
    
@stop