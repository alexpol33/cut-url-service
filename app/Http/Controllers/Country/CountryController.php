<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use App\Models\Models\CountryModel;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function country(): \Illuminate\Http\JsonResponse
    {
        return response()->json(CountryModel::get(), 200);
    }
}
