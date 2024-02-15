<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // Returns Company model for specified ID.
    public function index(Request $request)
    {
        $company = Company::where('id', $request->id)->get();
        return $company;
    }

}