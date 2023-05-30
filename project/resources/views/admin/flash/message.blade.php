{{--Toatr Notifications--}}


    @section('scripts')
        @if (Session::has('flash_notification.message'))
                {!! Toastr(Session::get('flash_notification.message'),Session::get('flash_notification.level')) !!}
        @endif

        @if (Session::has('flash_notification'))

            @foreach (session('flash_notification', collect())->toArray() as $message)
                @if ($message['overlay'])
                    @include('flash::modal', [
                        'modalClass' => 'flash-modal',
                        'title'      => $message['title'],
                        'body'       => $message['message']
                    ])
                @else

            {!! Toastr($message['message'],$message['level']) !!}
                @endif
                    @endforeach
        @endif



        @if (Session::has('success'))

            {!! Toastr(Session::get('success'),'success') !!}
        @endif
        @if (Session::has('msg'))

            {!! Toastr(Session::get('msg'),'success') !!}
        @endif
        @if (Session::has('error'))

            {!! Toastr(Session::get('error')).
             alert("Hello") !!}
        @endif

        @if(count($errors)>0)
            @foreach($errors->all() as $error)
                {!! Toastr($error) !!}
            @endforeach
        @endif
    @stop

{{--Flash Notifications--}}

    @if (Session::has('flash_notification.message'))



    {{--@if (Session::has('success'))--}}
        {{--<div class="flash alert alert-success">--}}
            {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
            {{--{{ Session::get('success') }}--}}
        {{--</div>--}}
    {{--@endif--}}

    @if (Session::has('error'))
        <div class="flash alert alert-error">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('error') }}
        </div>
    @endif

    @if (isset($errors))
        @if (count($errors)>0)
            <div class="flash  alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    @endif
@endif

{{ session()->forget('flash_notification') }}