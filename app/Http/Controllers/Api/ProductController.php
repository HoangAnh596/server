<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

/**
* @OA\Info(  version="1.0.0",  title="L5 OpenApi",  description="L5 Swagger OpenApi description" )
* @OA\Get(
*   path="/api/products",
*   summary="Show Products",
*   operationId="index",
*   tags={"Products"},
*   security={
*       {"ApiKeyAuth": {}}
*   },

*   @OA\Response(response=200, description="successful operation"),
*   @OA\Response(response=406, description="not acceptable"),
*   @OA\Response(response=500, description="internal server error")
* )
*
*/
class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ProductResource(Product::findOrFail($id));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
