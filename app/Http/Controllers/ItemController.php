<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
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
        ], 200, [], JSON_UNESCAPED_UNICODE);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Item::create($request->all());

        return response()->json([
            'message' => 'Created successfully.',
            'data' => $item
        ], 201, [], JSON_UNESCAPED_UNICODE);
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
            ], 200, [], JSON_UNESCAPED_UNICODE);
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
    public function update(Request $request, $id)
    {
        $update = [
            'title' => $request->title,
            'image' => $request->image,
            'description' => $request->description,
            'price' => $request->price,
        ];

        $item = Item::where('id', $id)->update($update);

        if ($item) {
            return response()->json([
                'message' => 'Updated successfully.',
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
