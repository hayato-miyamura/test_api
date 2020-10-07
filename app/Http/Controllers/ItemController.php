<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ValidatedRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        $items = Items::where('user_id', $user_id)->get();

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
        \Log::debug('####');
        \Log::debug($request);

        $item_model = new Items();
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
        $item = Items::find($id);

        if ($item) {
            return response()->json([
                'message' => 'OK',
                'data' => $item
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            return response()->json([
                'message' => 'Not found.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidatedRequest $request, $id)
    {
        \Log::debug('####');
        \Log::debug($request);

        $item_model = new Items();

        $uploadImg = $item_model->image = $request->file('image');
        $path = Storage::disk(config('filesystems.cloud'))->putFile('/', $uploadImg, 'public');
        $item_model->image = Storage::disk(config('filesystems.cloud'))->url($path);

        $update = [
            'title' => $request->input('title'),
            'image' => $item_model->image,
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ];

        Items::where('id', $id)->update($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        \Log::debug('####');
        \Log::debug($request);

        Items::where('id', $id)->delete();
    }
}
