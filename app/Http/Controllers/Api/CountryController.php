<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(
        protected CountryService $countryService
    ) {}

    public function index(Request $request)
    {   
        $countries = $this->countryService->getAllCountries($request->search);
        // استفاده از ریسورسی که قبلاً ساختیم
        return CountryResource::collection($countries);

    }
}
