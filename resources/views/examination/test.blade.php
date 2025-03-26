@extends('examination.common')

@section('title', 'Xét nghiệm')

@php
    $type = 'test';
    $title = 'Xét nghiệm';
    $services = \App\Models\Service::where('type', 'Xét nghiệm')->get();
@endphp
