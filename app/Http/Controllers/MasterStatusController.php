<?php

namespace App\Http\Controllers;

use App\Http\Resources\MasterStatusResource;
use App\Models\MasterStatus;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MasterStatusController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $statuses = MasterStatus::orderBy('id_status')->get();
        
        return MasterStatusResource::collection($statuses);
    }
}