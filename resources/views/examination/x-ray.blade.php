@extends('examination.common')

@section('title', 'X-quang')

@php
    $type = 'x-ray';
    $title = 'Khám X-quang';
    $services = \App\Models\Service::where('type', 'X-quang')->get();
@endphp
