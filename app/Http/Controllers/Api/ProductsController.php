<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Catagories;


class ProductsController extends Controller
{
    //

    public function addProducts(Request $request)
    {


    }

    public function getAvailableCatagories(Request $request)
    {

    	$cats = Catagories::all();

    	return response()->json(['status' => true, 'message' => 'Catagories Fetched Successfully!', 'details' => $cats]);

    }

}
