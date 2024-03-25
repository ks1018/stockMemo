@extends('adminlte::page')
<!-- 始めに使い方がわからない。とりあえず、add.blade.phpをコピーしてファイル名をcreateCategory.phpにしただけ -->

@section('title', 'カテゴリ作成')

@section('content_header')
    <h1>カテゴリ作成</h1>
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
                <div class="card-header">
                    <h3 class="card-title">大カテゴリ作成</h3>
                </div>
                <form method="POST" action="{{ route('categories.create')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="new_category_name">大カテゴリ名</label>
                            <input type="text" class="form-control" id="new_category_name" name="category_name">
                        </div>
                            <button type="submit" class="btn btn-primary">作成</button>
                    </div>
                </form>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">中カテゴリ作成（※まず大カテゴリを選択してください）</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('subCategories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="category_id">大カテゴリ選択</label>
                            <select name="category_id" id="category" class="form-select form-control" aria-label="readonly">
                                <option selected>大カテゴリを選択してください。</option>
                                    @if(isset($categories))
                                        @foreach(Auth::user()->getFilteredCategories($categories) as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    @endif
                            </select>

                            <!-- htmlフォーム内の<select>要素が変更されたときに、選択されたオプションのテキストを別のフィールドに自動的に入力 -->
                            <script>
                                document.getElementById('category').addEventListener('change',function()
                                {
                                    var selectedOption = this.options[this.selectedIndex];
                                    document.getElementById('selected_category_id').value = selectedOption.value;
                                });
                            </script>

                        </div>
                        <div class="form-group">
                            <label for="sub_category_name">中カテゴリ名</label>
                            <input type="text" class="form-control" id="sub_category_name" name="name">
                        </div>
                        <input type="hidden" id="selected_category_id" name="category_id">
                        <button type="submit" class="btn btn-primary">作成</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
