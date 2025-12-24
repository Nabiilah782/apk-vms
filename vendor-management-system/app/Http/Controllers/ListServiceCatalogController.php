<?php

namespace App\Http\Controllers;

use App\Models\ListServiceCatalog;
use App\Models\ServiceCatalog; // TAMBAHKAN INI
use Illuminate\Http\Request;

class ListServiceCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load relasi services
        $lists = ListServiceCatalog::with('services')->get();
        return view('list_service_catalog.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua service catalog untuk dipilih
        $services = ServiceCatalog::all();
        return view('list_service_catalog.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'list_name' => 'required|string|max:255|unique:list_service_catalog,list_name',
            'services' => 'nullable|array', // Optional jika ingin pilih services
            'services.*' => 'exists:service_catalog,id'
        ]);

        // Create the list
        $list = ListServiceCatalog::create([
            'list_name' => $request->list_name,
        ]);

        // Attach selected services jika ada
        if ($request->has('services')) {
            $list->services()->attach($request->services);
        }

        return redirect()->route('list_service_catalog.index')
            ->with('success', 'List service catalog berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $listServiceCatalog = ListServiceCatalog::with('services')->findOrFail($id);
        $services = ServiceCatalog::all();
        $selectedServices = $listServiceCatalog->services->pluck('id')->toArray();
        
        return view('list_service_catalog.edit', compact('listServiceCatalog', 'services', 'selectedServices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'list_name' => 'required|string|max:255|unique:list_service_catalog,list_name,' . $id,
            'services' => 'nullable|array',
            'services.*' => 'exists:service_catalog,id'
        ]);

        $listServiceCatalog = ListServiceCatalog::findOrFail($id);
        
        // Update list name
        $listServiceCatalog->update([
            'list_name' => $request->list_name,
        ]);

        // Sync services jika ada
        if ($request->has('services')) {
            $listServiceCatalog->services()->sync($request->services);
        } else {
            // Jika tidak ada services yang dipilih, kosongkan
            $listServiceCatalog->services()->sync([]);
        }

        return redirect()->route('list_service_catalog.index')
            ->with('success', 'List berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $listServiceCatalog = ListServiceCatalog::findOrFail($id);
            
            // Detach semua services sebelum delete
            $listServiceCatalog->services()->detach();
            
            $listServiceCatalog->delete();
            
            return redirect()->route('list_service_catalog.index')
                ->with('success', 'List berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('list_service_catalog.index')
                ->with('error', 'Gagal menghapus list: ' . $e->getMessage());
        }
    }
}