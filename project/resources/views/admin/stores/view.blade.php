@extends('admin.layouts.master')
@section('breadcrumb')
    <section class="content-header">
        <h1>
            Store
        </h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.stores.index') }}">Stores</a> <i class="fa fa-minus" aria-hidden="true"></i>
            </li>
            <li class="active"> View</li>
        </ul>
    </section>

@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject ">{{ ucfirst($store->name) }}</span>
                    </div>
                </div>
                <div class="portlet-body quotation">
                    <div class="table-scrollable">
                        <table class="table table-user-information">
                            <tbody>
                            <tr>
                                <td>MyShopify Domain
                                    <dd>
                                        <b>{{ $store->myshopify_domain }}</b>
                                    </dd>
                                </td>
                                <td>Domain
                                    <dd>
                                        <b>{{ $store->domain }}</b>
                                    </dd>
                                </td>
                                <td>Status
                                    <dd>
                                        @if(!$store->is_deleted)
                                            <span class="badge badge-primary">Active</span>
                                        @else
                                            <span class="badge badge-warning">Inactive</span>
                                        @endif
                                    </dd>
                                </td>
                                <td>Owner Email
                                    <dd>
                                        <b>{{ $store->email }}</b>
                                    </dd>
                                </td>
                            </tr>
                            <tr>
                                <td>User Plan
                                    <dd>
                                        <b id="quotation-status">{{ ucfirst($store->current_plan_type) }}</b>
                                    </dd>
                                </td>
                                <td> First Installation DateTime
                                    <dd>
                                        <b>{{ $store->created_at }}</b>
                                    </dd>
                                </td>
                                <td> Uninstalled At
                                    <dd>
                                        <b>
                                            @if($store->uninstalled_at)
                                                <b>{{ $store->uninstalled_at }}</b>
                                            @endif
                                        </b>
                                    </dd>
                                </td>
                            </tr>
                            <tr>
                                <td>Total Registered Channels
                                    <dd>
                                        <b>{{ $store->registeredEventsAndChannels
                                        ->groupBy('channel_id')
                                        ->count() }}</b>
                                    </dd>
                                </td>
                                <td>Active Channels
                                    <dd>
                                        <b>{{ $store->registeredEventsAndChannels
                                        ->where('status',1)
                                        ->groupBy('channel_id')
                                        ->count() }}</b>
                                    </dd>
                                </td>
                            </tr>
                            <tr>
                                <td>Total Registered Events
                                    <dd>
                                        <b>{{ $store->registeredEventsAndChannels
                                        ->count() }}</b>
                                    </dd>
                                </td>
                                <td>Active Events
                                    <dd>
                                        <b>{{ $store->registeredEventsAndChannels->where('status',1)->count() }}
                                         </b>
                                    </dd>
                                </td>
                            </tr>
                            <tr>
                              <?php  $processed_webhooks = $store->processed_jobs()->count();
                                $allowed_webhooks_tasks = allowed_webhooks_tasks($store->current_plan_type);
                                ?>
                                <td>Total Processed Jobs
                                    <dd>
                                        <b>{{ $processed_webhooks }}</b>
                                    </dd>
                                </td>
                                <td>Remaining Jobs
                                    <dd>
                                        <b>{{ ($allowed_webhooks_tasks-$processed_webhooks) }}</b>
                                    </dd>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject "> Plans History </span>
                    </div>
                </div>
                <div class="portlet-body quotation">
                    <div class="table-scrollable">
                        <table class="table table-user-information">
                            <tbody>
                            <tr>
                                <th>Plan Type</th>
                                <th>Charge Status</th>
                                <th>Created At</th>
                                <th>Charge ID</th>
                                {{--<th>Confirmation URL</th>--}}
                            </tr>
                            @php
                                $store_plans_history=$store->plans_history->sortByDesc('id');
                                    @endphp
                            @foreach($store_plans_history as $plans_history)
                                <tr>
                                    <td>{{ ucfirst($plans_history->plan_type) }}</td>
                                    <td>
                                        <span class="badge {{ ($plans_history->plan_type=="basic" || $plans_history->charge_status=="active")?"badge-primary":"badge-warning" }}">
                                                {{ $plans_history->charge_status??"None" }}
                                            </span>
                                    </td>
                                    <td>{{  $plans_history->created_at  }}</td>
                                    <td>{{ $plans_history->charge_id }}</td>
                                    {{--<td>{{ $plans_history->confirmation_url }}</td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="box-footer">
                    <a class="btn btn-flat" href="{{ route('admin.stores.index') }}">Back </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

    </div>
@stop
