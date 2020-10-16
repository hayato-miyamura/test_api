<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ValidatedRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{

    // Middleware/CheckAuthenticated.phpで認証済みかどうかチェック。
    // Middleware/CookieCheck.phpでCookieを持ってない場合Login画面へリダイレクト。
    public function __construct()
    {
        $this->middleware('check.auth');
        $this->middleware('cookie');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $items = Item::where('user_id', $user_id)->get();

        return view('item', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidatedRequest $request)
    {
        $item_model = new Item();
        $user = Auth::user();

        $item_model->user_id = $user->id;
        $item_model->title = $request->input('title');
        $item_model->image = $request->input('image');
        $item_model->description = $request->input('description');
        $item_model->price = $request->input('price');

        $uploadImg = $item_model->image = $request->file('image');
        $path = Storage::disk(config('filesystems.cloud'))->putFile('/', $uploadImg, 'public');
        $item_model->image = Storage::disk(config('filesystems.cloud'))->url($path);

        $item_model->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidatedRequest $request, $id, User $user)
    {
        $item_model = new Item();

        $uploadImg = $item_model->image = $request->file('image');
        $path = Storage::disk(config('filesystems.cloud'))->putFile('/', $uploadImg, 'public');
        $item_model->image = Storage::disk(config('filesystems.cloud'))->url($path);

        $update = [
            'title' => $request->input('title'),
            'image' => $item_model->image,
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ];

        $item_update = Item::where('id', $id)->update($update);

        // Policies\ItemPolicy.phpで認可を設定
        if ($user->can('update', $item_update)) {
            return redirect('/item');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, User $user)
    {
        $item_delete = Item::where('id', $id)->delete();

        // Policies\ItemPolicy.phpで認可を設定
        if ($user->can('delete', $item_delete)) {
            return redirect('/item');
        }
    }
}
