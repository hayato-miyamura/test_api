@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('投稿された商品一覧') }}</div>
                <div class="card-body">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">投稿者</th>
                                <th scope="col">タイトル</th>
                                <th scope="col">画像</th>
                                <th scope="col">詳細</th>
                                <th scope="col">価格</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_items as $item)
                            <tr>
                                <td scope="row" id="item_id">{{ $item->user_name }}</td>
                                <td>
                                    <p style="width:10em;">{{ $item->title }}</p>
                                </td>
                                <td>
                                    <img src="{{ $item->image }}" alt="" width="100px">
                                </td>
                                <td>
                                    <p class="description_text" style="width:20em;">{{ $item->description }}</p>
                                </td>
                                <td class="item_price">{{ $item->price }}円</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    {{ $all_items->links() }}
</div>
<script src="{{ mix('js/insertcomma.js') }}"></script>
@endsection