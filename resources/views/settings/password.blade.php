@extends('layouts.app')

@section('content')
<flux:container>
    <x-settings.layout>
        <x-slot name="heading">{{ __('Password') }}</x-slot>
        <x-slot name="subheading">{{ __('Change your password') }}</x-slot>

        <div>
            <p class="text-sm text-gray-600">This is a placeholder password settings page.</p>
        </div>
    </x-settings.layout>
</flux:container>
@endsection
