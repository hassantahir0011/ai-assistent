<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
    window.OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
//        OneSignal.SERVICE_WORKER_PARAM = { scope: '/webhook_setup_stage/' };
//        OneSignal.SERVICE_WORKER_PATH = 'webhook_setup_stage/OneSignalSDKWorker.js';
//        OneSignal.SERVICE_WORKER_UPDATER_PATH = 'webhook_setup_stage/OneSignalSDKUpdaterWorker.js';
        OneSignal.init({
            appId: "{{ env('ONESIGNAL_PUBLIC_KEY',"") }}",
            httpPermissionRequest: {
                enable: true
            },notifyButton: {
                enable: true,
                position: 'bottom-left',
                displayPredicate: function() {
//                    document.querySelector('.onesignal-bell-launcher-dialog').className += " onesignal-bell-launcher-dialog-opened";
                   // document.querySelector('.onesignal-bell-launcher-button').click();
                }

            }

        });
        @php $shop_session = session('shop'); @endphp
        @if ($shop_session && $shop_session['email'])
         OneSignal.setEmail("{{ $shop_session['email'] }}");
        @endif


//        OneSignal.sendSelfNotification(
//            /* Title (defaults if unset) */
//            "OneSignal Web Push Notification",
//            /* Message (defaults if unset) */
//            "Action buttons increase the ways your users can interact with your notification.",
//            /* URL (defaults if unset) */
//            'https://appscorridor.com/',
//            /* Icon */
//            'https://onesignal.com/images/notification_logo.png',
//            {
//                /* Additional data hash */
//                notificationType: 'news-feature'
//            },
//            [{ /* Buttons */
//                /* Choose any unique identifier for your button. The ID of the clicked button is passed to you so you can identify which button is clicked */
//                id: 'like-button',
//                /* The text the button should display. Supports emojis. */
//                text: 'Like',
//                /* A valid publicly reachable URL to an icon. Keep this small because it's downloaded on each notification display. */
//                icon: 'http://i.imgur.com/N8SN8ZS.png',
//                /* The URL to open when this action button is clicked. See the sections below for special URLs that prevent opening any window. */
//                url: 'https://appscorridor.com/webhook_setup_stage/faqs'
//            },
//                {
//                    id: 'read-more-button',
//                    text: 'Read more',
//                    icon: 'http://i.imgur.com/MIxJp1L.png',
//                    url: 'https://example.com/?_osp=do_not_open'
//                }]
//        );
    });

</script>
