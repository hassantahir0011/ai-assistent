
    <div class="section top-info">
        <div class="section-fixed">
            <div class="section-content">
                <div class="section-row">
                    <div class="section-cell">
                        <table class="payment-details app-label" cellpadding="0" cellspacing="0" summary="payment details">
                            <tbody><tr>
                                <td class="payment-state">
                                    <div class="wrapper">



                                        <!-- Charge history. -->
                                    </div>
                                </td>

                            </tr>
                            </tbody></table>
                        <div class="clear"></div>
                        <!-- Public content. -->
                    </div></div></div></div></div>
@section('last_scripts')

    <script type="text/javascript">
    @if(isset($shopUrl) && !empty($shopUrl))
    @endif
    </script>
@endsection
