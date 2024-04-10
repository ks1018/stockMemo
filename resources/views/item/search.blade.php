@extends('adminlte::page')

@section('title', 'ストック状況検索')

@section('content_header')
    <h1>ストック状況</h1>
@stop

@section('content')
    <div class="container">
        @foreach ($categories as $category)
            <h2>{{ $category->name }}</h2>
            <div class="row">
                @foreach ($category->subcategories as $subcategory)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $subcategory->name }}</h5>
                                    <p class="card-text">在庫数: {{ $subcategory->items->where('out_date', null)->count() }}</p>
                                @if($subcategory->outDate != null )
                                    <p class="card-text">最後の出庫日: {{ $subcategory->outDate }}</p>
                                @else
                                    <p class="card-text">最後の出庫日: N/A</p>
                                @endif                            
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <br>
        @endforeach
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
