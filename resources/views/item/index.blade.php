@extends('adminlte::page')

@section('title', 'ストック一覧')

@section('content_header')
    <h1>ストック一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ストック一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">ストック品登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>中カテゴリ</th>
                                <th>品名</th>
                                <th>賞味期限</th>
                                <th>購入価格</th>
                                <th>購入店</th>
                                <th>メモ</th>
                                <th>購入日</th>
                                <th>出庫日</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->sub_category_id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->best_before_date }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->shop_id }}</td>
                                    <td>{{ $item->memo }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->out_date }}</td>
                                    <td>
                                        <!-- 編集ボタン -->
                                        <a href="" class="btn btn-dark btn-sm">編集</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
