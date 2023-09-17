<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEndpointRequest;
use App\Models\Endpoint;
use App\Models\Site;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class EndpointController extends Controller
{
    public function index(string $siteId)
    {
        $site = Site::with('endpoints.check')->find($siteId);
        if (!$site) {
            return back();
        }
        $this->authorize('owner', $site);

        $endpoints = $site->endpoints;

        return Inertia::render('Admin/Endpoints/Index', compact('site', 'endpoints'));
    }

    public function create(string $siteId)
    {
        if (!$site = Site::find($siteId)) {
            return back();
        }
        $this->authorize('owner', $site);

        return Inertia::render('Admin/Endpoints/Create', compact('site'));
    }

    public function store(StoreUpdateEndpointRequest $request, Site $site)
    {
        $this->authorize('owner', $site);
        $site->endpoints()->create($request->all());

        return redirect()
            ->route('endpoints.index', $site->id)
            ->with('message', 'Created');
    }

    public function edit(Site $site, Endpoint $endpoint)
    {
        $this->authorize('owner', $site);

        return Inertia::render('Admin/Endpoints/Edit', compact('site', 'endpoint'));
    }

    public function update(StoreUpdateEndpointRequest $request, Site $site, Endpoint $endpoint)
    {
        $this->authorize('owner', $site);
        $endpoint->update($request->validated());

        return redirect()
            ->route('endpoints.index', $site->id)
            ->with('message', 'Updated');
    }

    public function destroy(Site $site, Endpoint $endpoint)
    {
        $this->authorize('owner', $site);
        $endpoint->delete();

        return redirect()
            ->route('endpoints.index', $site->id)
            ->with('message', 'Deleted');
    }
}