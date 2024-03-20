@extends('adminlte::page')

@section('title', 'ストック品登録')

@section('content_header')
    <h1>ストック品登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category">大カテゴリ</label>
                            <select name="category" id="category" class="form-select">
                                <option selected>大カテゴリを選択してください。</option>
                                    <!-- データ作成前の確認用 -->
                                    <option value="1">食品</option>
                                    <option value="2">日用品</option>
                                    <option value="3">常備薬</option>
                                    <!-- @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                    @endforeach -->
                            </select>
                            <!--初期コード <input type="text" class="form-control" id="category" name="category" placeholder="大カテゴリ ドロップリストにしたい"> -->
                        </div>

                        <div class="form-group">
                            <label for="sub_category">中カテゴリ</label>
                            <input type="text" class="form-control" id="sub_category" name="sub_category" placeholder="中カテゴリ ドロップリストにしたい">
                        </div>

                        <div class="form-group">
                            <label for="item">品名</label>
                            <input type="text" class="form-control" id="item" name="item" placeholder="品名、銘柄">
                        </div>

                        <div class="form-group">
                            <label for="best_before_date">賞味期限</label>
                            <input type="date" class="form-control" id="best_before_date" name="best_before_date" placeholder="簡単なカレンダーで選びたい">
                        </div>

                        <div class="form-group">
                            <label for="price">購入価格</label>
                            <input type="int" class="form-control" id="price" name="price" placeholder="○○○円">
                        </div>

                        <div class="form-group">
                            <label for="shop">購入店</label>
                            <input type="text" class="form-control" id="shop" name="shop" placeholder="○○スーパー">
                        </div>

                        <div class="form-group">
                            <label for="memo">メモ</label>
                            <input type="text" class="form-control" id="memo" name="memo" placeholder="特価品 新商品">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
