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
    public function countryById($id): \Illuminate\Http\JsonResponse
    {
        return response()->json(CountryModel::find($id), 200);
    }

    public function countryAdd(Request $request){
        $country = CountryModel::create($request->all());
        return response()->json($country, 201);
    }

    public function countryEdit(Request $request, CountryModel $country){
        $country->update($request->all());
        return response()->json($country, 201);
    }


}
