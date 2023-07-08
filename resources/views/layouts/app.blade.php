@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush


@extends('layouts.base_layout')

@section('base_layout_content')
    
    <main class="">
        @include('layouts.inc.sidebar')

        <div class="layout-content">
            @include('layouts.inc.navbar')
            {{ $slot }}
        </div>
    </main>

@endsection

@push('script')
<script>    
    
</script>
@endpush