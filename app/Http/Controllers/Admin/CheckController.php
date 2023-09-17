<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Endpoint;
use Inertia\Inertia;

class CheckController extends Controller
{
    public function index(Endpoint $endpoint)
    {
        $this->authorize('ownerChecks', $endpoint);

        $checks = $endpoint->checks()->paginate(8);

        return Inertia::render('Admin/Endpoints/Logs/Index', compact('endpoint', 'checks'));
    }
}