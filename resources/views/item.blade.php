@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">商品の登録・編集・削除</div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_item_modal">
                        商品を登録する
                    </button>

                    <!-- Start of the "Add" modal -->
                    <div class="modal fade" id="add_item_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="AddModalCenterTitle">商品登録フォーム</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="addItem" method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="InputTitle">商品タイトル</label>
                                            <input type="text" class="form-control" name="title" placeholder="商品名を入力してください">
                                            <small id="" class="form-text text-muted">注意事項：</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputFile">商品画像</label>
                                            <input type="file" name="image" class="form-control-file">
                                        </div>
                                        <div class="form-group">
                                            <label for="InputDescription">商品の説明</label>
                                            <textarea name="description" class="form-control" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputPrice">価格</label>
                                            <input type="text" class="form-control" name="price" placeholder="価格を入力してください">
                                            <small id="" class="form-text text-muted">注意事項：</small>
                                        </div>
                                        <div class="">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                            <input type="submit" class="btn btn-primary" value="登録する">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of the "Add" modal -->

                    <!-- Start of the "Edit" modal -->
                    <div class="modal fade" id="edit_item_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="EditModalCenterTitle">商品情報の編集</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="editItem" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label for="">商品ID</label>
                                            <input type="text" id="id" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="EditTitle">商品タイトル</label>
                                            <input type="text" class="form-control" name="title" id="title" placeholder="商品名を入力してください">
                                            <small id="" class="form-text text-muted">注意事項：</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="EditFile">商品画像</label>
                                            <input type="file" name="image" class="form-control-file" id="image" multiple>
                                        </div>
                                        <div class="form-group">
                                            <label for="EditDescription">商品の説明</label>
                                            <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="EditPrice">価格</label>
                                            <input type="text" class="form-control" name="price" id="price" placeholder="価格を入力してください">
                                            <small id="" class="form-text text-muted">注意事項：</small>
                                        </div>
                                        <div class="">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                            <input type="submit" class="btn btn-primary" value="更新する">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of the "Edit" modal -->

                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">タイトル</th>
                                <th scope="col">画像</th>
                                <th scope="col">詳細</th>
                                <th scope="col">価格</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td scope="row">{{ $item->id }}</td>
                                <td><p style="width:10em;">{{ $item->title }}</p></td>
                                <td>
                                    <img src="{{ $item->image }}" alt="" width="100px">
                                </td>
                                <td><p class="description_text" style="width:20em;">{{ $item->description }}</p></td>
                                <td>{{ $item->price }}</td>
                                <td>
                                    <a href="#" class="btn btn-success editbtn">編集</a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success deletebtn">削除</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection