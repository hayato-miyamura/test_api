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
        $all_items = Item::latest('created_at')->paginate(10);

        return view('welcome', compact('all_items'));
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
        $item_model->user_name = $user->name;
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
    public function show()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $items = Item::where('user_id', $user_id)->latest()->paginate(5);

        return view('item', compact('items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, User $user)
    {
        $item_model = new Item();

        $image_request = $request->file('image');
        $title_request = $request->input('title');
        $description_request = $request->input('description');
        $price_request = $request->input('price');

        $can_input_title = config('const.title');
        $can_input_description = config('const.description');
        $min_price = config('const.min_price');
        $max_price = config('const.max_price');

        if ($image_request) {

            $request->validate([
                'image' => 'required|image'
            ]);

            $uploadImg = $item_model->image = $image_request;
            $path = Storage::disk(config('filesystems.cloud'))->putFile('/', $uploadImg, 'public');
            $item_model->image = Storage::disk(config('filesystems.cloud'))->url($path);

            $image_update_array = [
                'image' => $item_model->image
            ];

            $image_update = Item::where('id', $id)->update($image_update_array);

            // Policies\ItemPolicy.phpで認可を設定
            if ($user->can('update', $image_update)) {
                return redirect('/item');
            }

        } else {

            $request->validate([
                'title' => "required|string|max:$can_input_title",
                'description' => "required|string|max:$can_input_description",
                'price' => "required|integer|between:$min_price,$max_price"
            ]);

            $update_array = [
                'title' => $title_request,
                'description' => $description_request,
                'price' => $price_request,
            ];

            $item_info_update = Item::where('id', $id)->update($update_array);

            // Policies\ItemPolicy.phpで認可を設定
            if ($user->can('update', $item_info_update)) {
                return redirect('/item');
            }

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
