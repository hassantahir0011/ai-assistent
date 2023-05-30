@extends('layouts.popup_window_parent')

@section('last_scripts')
    <script type="text/javascript">

            window.opener.channelPopupCallback('Successfully logged In.'); //Call callback function
            window.close(); // Close the current popup

    </script>
@endsection