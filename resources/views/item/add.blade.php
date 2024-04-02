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
            <form method="POST" action="{{ route('items.store')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category">大カテゴリ</label>
                            <select name="category" id="category" class="form-select form-control">
                                <option selected>大カテゴリを選択してください。</option>
                                    @if(isset($categories))
                                        @foreach(Auth::user()->getFilteredCategories($categories) as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    @endif
                            </select>
                            <label for="sub_category">中カテゴリ</label>
                            <select name="sub_category_id" id="sub_category" class="form-select form-control">
                            </select>

                        <div class="form-group">
                            <label for="item">品名</label>
                            <input type="text" class="form-control" id="item" name="item_name" placeholder="品名、銘柄">
                        </div>
                        <div class="form-group">
                            <label for="best_before_date">賞味期限・使用期限</label>
                            <input type="date" class="form-control" id="best_before_date" name="best_before_date" placeholder="簡単なカレンダーで選びたい">
                        </div>
                        <div class="form-group">
                            <label for="price">購入価格</label>
                            <input type="int" class="form-control" id="price" name="price" placeholder="○○○円">
                        </div>
                        <div class="form-group">
                            <label for="shop">購入店</label>
                            <input type="text" class="form-control" id="shop" name="shop_name" placeholder="○○スーパー">
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    document.getElementById('category').addEventListener('change', function() {
    var categoryId = this.value;
    
        // AJAXリクエストを送信して中カテゴリを取得
        $.ajax({
            url: '/getsubcategories',
            method: 'POST',
            data: {
                category_id: categoryId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                var subCategorySelect = document.getElementById('sub_category');
                subCategorySelect.innerHTML = '<option selected>中カテゴリを選択してください。</option>';
                
                response.forEach(function(subCategory) {
                    var option = document.createElement('option');
                    option.value = subCategory.id;
                    option.innerText = subCategory.name;
                    subCategorySelect.appendChild(option);
                });
            }
        });
    });

    // 中カテゴリが選択されたときにそのidをhidden inputに設定する
    document.getElementById('sub_category').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var selectedOptionId = selectedOption.value;
    });

</script>
@stop
