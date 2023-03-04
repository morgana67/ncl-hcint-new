@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.'Orders')
@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list-add"></i> Orders
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        <form method="get" class="form-search">
            <div id="search-input">
                <div class="col-2">
                    <select id="search_key" name="key">
                        @foreach($searchNames as $key => $name)
                            <option value="{{ $key }}" @if($search->key == $key) selected @endif>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <select id="filter" name="filter">
                        <option value="contains" @if($search->filter == "contains") selected @endif>contains</option>
                        <option value="equals" @if($search->filter == "equals") selected @endif>=</option>
                    </select>
                </div>
                <div class="input-group col-md-12">
                    <input type="text" class="form-control" placeholder="{{ __('voyager::generic.search') }}" name="s" value="{{ $search->value }}">
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="submit">
                            <i class="voyager-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Total Amount</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Create At</th>
                                <th class="actions text-right">{{ __('voyager::generic.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->firstName.' '.$order->lastName}}</td>
                                    <td>{{$order->email}}</td>
                                    <td>${{$order->totalAmount}}</td>
                                    <td>{{$order->paymentStatus}}</td>
                                    <td>{{$order->orderStatus}}</td>
                                    <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$order->created_at)->format('M. jS, Y')}}</td>
                                    <td class="no-sort no-click bread-actions">
                                        <a href="javascript:;" title="Delete" class="btn btn-sm btn-danger pull-right delete" data-id="{{$order->id}}" id="delete-{{$order->id}}">
                                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Delete</span>
                                        </a>
                                        <a href="{{route('admin.orders.detail', ['id' => $order->id])}}" title="Edit" class="btn btn-sm btn-primary pull-right edit">
                                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">View</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pull-left">
                            <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                    'voyager::generic.showing_entries', $orders->total(), [
                                        'from' => $orders->firstItem(),
                                        'to' => $orders->lastItem(),
                                        'all' => $orders->total()
                                    ]) }}</div>
                        </div>
                        <div class="pull-right">
                            {{ $orders->withQueryString()->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} Order ?
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_this_confirm') }} order">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <!-- DataTables -->
    <script>
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('admin.orders.destroy', ['id' => '__menu']) }}'.replace('__menu', $(this).data('id'));

            $('#delete_modal').modal('show');
        });
        $(document).ready(function () {
            $('#search-input select').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
@stop
