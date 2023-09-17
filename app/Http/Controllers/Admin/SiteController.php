<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateSiteRequest;
use App\Models\Site;
use Inertia\Inertia;
use Inertia\Response;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::paginate();

        return Inertia::render('Admin/Sites/Index', compact('sites'));
    }

    public function create()
    {
        return Inertia::render('Admin/Sites/Create');
    }

    public function store(StoreUpdateSiteRequest $request)
    {
        $request->user()->sites()->create($request->validated());

        return redirect()
            ->route('sites.index')
            ->with('message', 'Created');
    }

    public function edit(string $id)
    {
        if (!$site = Site::find($id)) {
            return back();
        }

        return Inertia::render('Admin/Sites/Edit', compact('site'));
    }

    public function update(StoreUpdateSiteRequest $request, Site $site)
    {
        $site->update($request->validated());

        return redirect()
            ->route('sites.index')
            ->with('message', 'Updated');
    }

    public function destroy(Site $site)
    {
        $site->delete();

        return redirect()
            ->route('sites.index')
            ->with('message', 'Deleted');
    }
}