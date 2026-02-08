@extends('layouts.app')

@section('content')
<flux:container>
    <x-settings.layout>
        <x-slot name="heading">{{ __('Appearance') }}</x-slot>
        <x-slot name="subheading">{{ __('Theme and appearance settings') }}</x-slot>

        <div>
            <p class="text-sm text-gray-600">This is a placeholder appearance settings page.</p>
        </div>
    </x-settings.layout>
</flux:container>
@endsection
