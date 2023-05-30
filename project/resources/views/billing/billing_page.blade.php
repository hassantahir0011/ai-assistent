@extends('layouts.master')
@section('last_scripts')

    <script type="text/javascript">

    @if(isset($confirmation_url) && !empty($confirmation_url))
        window.top.location='{{ $confirmation_url }}';
    @endif
    </script>
@endsection
