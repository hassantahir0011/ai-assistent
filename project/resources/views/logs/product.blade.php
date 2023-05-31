@extends('layouts.master')
<?php
$asset_controls = [
    'datatable', 'sweetalert', 'select2'
];
?>

@section('content')
    <section class="section">
        <div class="container">
            <div class="section-main-heading"
                 style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-lighter:#1d9ba4;">
                <h4>{{ $product['title'] }}</h4>
            </div>

            <div class="">
                <div class="">
                    <div class="logs-page table-scroll">
                        <table class="registered-webhook-table responsive table table-hover table-checkable order-column dataTable no-footer dtr-inline"
                               id="sample_1">
                            <thead>
                            <tr class="">
                                <th> ID</th>
                                <th> Image</th>
                                <th> Title</th>
                                <th> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
