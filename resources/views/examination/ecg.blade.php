@extends('examination.common')

@section('title', 'Điện Tim')

@php
    $type = 'ecg';
    $title = 'Khám Điện Tim';
    $services = \App\Models\Service::where('type', 'Điện tim')->get();
@endphp
