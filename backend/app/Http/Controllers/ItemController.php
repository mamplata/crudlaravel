<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return response()->json($items);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           "name" => "required|string",
           "qty"  => "required|integer",
           "price" => "required|numeric"
        ]);
        
        Item::create($request->all());
        return response()->json(["message" => "Item added successfully."]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
          $request->validate([
             "name" => "required|string",
             "qty"  => "required|integer",
             "price" => "required|numeric"
          ]);
        
        $item->update($request->all());
        return response()->json(["message" => "Item updated successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json(["message" => "Item deleted successfully."]);
    }
}
