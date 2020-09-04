<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ValidatedRequest;
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

        $items = Item::all();

        return response()->json([
            'message' => 'OK',
            'data' => $items
        ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

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

        $item_model->title = $request->title;
        $item_model->description = $request->description;
        $item_model->price = $request->price;

        $uploadImg = $item_model->image = $request->file('image');
        $path = Storage::disk(config('filesystems.cloud'))->putFile('/', $uploadImg, 'public');
        $item_model->image = Storage::disk(config('filesystems.cloud'))->url($path);

        $item_model->save();

        return response()->json([
            'message' => 'Created successfully.',
            'data' => $item_model
        ], 201, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);

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

        $item_model = new Item();

        $uploadImg = $item_model->image = $request->file('image');
        $path = Storage::disk(config('filesystems.cloud'))->putFile('/', $uploadImg, 'public');
        $item_model->image = Storage::disk(config('filesystems.cloud'))->url($path);

        $update = [
            'title' => $request->title,
            'image' => $item_model->image,
            'description' => $request->description,
            'price' => $request->price,
        ];
        
        $item = Item::where('id', $id)->update($update);

        if ($item) {
            return response()->json([
                'message' => 'Updated successfully.',
                'data' => $update
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found.',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::where('id', $id)->delete();

        if ($item) {
            return response()->json([
                'message' => 'Deleted successfully.',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found.',
            ], 404);
        }
    }
}
