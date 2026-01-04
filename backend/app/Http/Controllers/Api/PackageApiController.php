<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageApiController extends Controller
{
    public function index()
    {
        return Package::where('is_active', 1)
            ->select('id', 'name', 'description')
            ->get();
    }

    public function show($id)
    {
        return Package::with([
            'ticketVersions.category'
        ])->findOrFail($id);
    }
}
