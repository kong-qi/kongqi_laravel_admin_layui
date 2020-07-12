@extends('customErros.minimal')

@section('title', __($msg ?: 'Forbidden'))
@section('code', $code)
@section('message', __($msg ?: 'Forbidden'))
