@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Your Info : </th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">商品の登録・編集</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">商品タイトル</label>
                            <input type="text" class="form-control" name="title" placeholder="商品名を入力してください">
                            <small id="" class="form-text text-muted">注意事項</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">商品画像</label>
                            <input type="file" name="image" class="form-control-file" id="">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">商品の説明</label>
                            <textarea name="description" class="form-control" id="" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">価格</label>
                            <input type="text" class="form-control" name="price" placeholder="価格を入力してください">
                            <small id="" class="form-text text-muted">注意事項</small>
                        </div>
                        <div class="form-group row mt-2">
                            <div class="col-md-8">
                                <input type="submit" class="btn btn-info" value="登録する">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection