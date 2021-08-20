<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use App\Models\Models\CountryModel;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function country(): \Illuminate\Http\JsonResponse
    {

        return response()->json(CountryModel::get(), 200);
    }
    public function countryById($id): \Illuminate\Http\JsonResponse
    {
        if(is_null(CountryModel::find($id))){
            return response()->json(['error' => true, 'message' => 'Not Found'], 404);
        }
        return response()->json(CountryModel::find($id), 200);

    }

    public function countryAdd(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = [
            'iso' => 'required|min:2|max:2',
            'name' => 'required',
            'name_en' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            response()->json($validator->errors(), 400);
        }
        $country = CountryModel::create($request->all());
        return response()->json($country, 201);
    }

    public function countryEdit(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $rules = [
            'iso' => 'required|min:2|max:2',
            'name' => 'required',
            'name_en' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            response()->json($validator->errors(), 400);
        }
        if(is_null($country = CountryModel::find($id))){
            return response()->json(['error' => true, 'message' => 'Not Found'], 404);
        }
        $country->update($request->all());
        return response()->json($country, 201);
    }

    public function countryDelete($id): \Illuminate\Http\JsonResponse
    {
        if(is_null($country = CountryModel::find($id))){
            return response()->json(['error' => true, 'message' => 'Not Found'], 404);
        }
        $country->delete();
        return response()->json(null, 204);
    }
}
