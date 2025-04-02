@extends('layouts.master')
@section('title')
    Dashboard |
@endsection

@section('content')
    <x-date-component/>
    <x-sale-in-turn-component :restaurants="$restaurants"/>
    <x-sales-total-day-component :restaurants="$restaurants" />
    <x-all-sales-component />
@endsection
