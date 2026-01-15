<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryApiController extends Controller
{
            public function index(){
            return response()->json([
                'success' => true,
                'data' => Category::where('status', 1)->get(),
            ]);
        }
    
}
