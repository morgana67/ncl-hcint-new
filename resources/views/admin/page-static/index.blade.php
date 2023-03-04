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
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Create At</th>
                                <th class="actions text-right">{{ __('voyager::generic.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td>{{$page->title}}</td>
                                    <td>{{$page->slug}}</td>
                                    <td>{{$page->created_at}}</td>
                                    <td class="no-sort no-click bread-actions">
                                        <a href="{{route('admin.page-static.detail', ['code' => $page->code_page])}}" title="Edit" class="btn btn-sm btn-primary pull-right edit">
                                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">View</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pull-left">
                            <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                    'voyager::generic.showing_entries', $pages->total(), [
                                        'from' => $pages->firstItem(),
                                        'to' => $pages->lastItem(),
                                        'all' => $pages->total()
                                    ]) }}</div>
                        </div>
                        <div class="pull-right">
                            {{ $pages->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop


