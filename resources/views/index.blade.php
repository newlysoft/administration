@extends('admin::layout')
@section('content')
    <app>加载中...</app>
@endsection
@section('script')
    <script>
        window.Laravel = { "csrfToken": "{{ csrf_token() }}" }
    </script>
    <script type="text/javascript" src="http://localhost:8080/app.js"></script>
@endsection