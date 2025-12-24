<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCatalog;

class ServiceCatalogController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        $services = ServiceCatalog::orderBy('id', 'asc')->get();
        return view('service_catalog.index', compact('services'));
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('service_catalog.create');
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:100',
            'service_name'  => 'required|string|max:150',
        ]);

        ServiceCatalog::create([
            'category_name' => $request->category_name,
            'service_name' => $request->service_name,
        ]);

        return redirect()->route('service_catalog.index')
                        ->with('success', 'Service berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $service = ServiceCatalog::findOrFail($id);
        return view('service_catalog.edit', compact('service'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:100',
            'service_name'  => 'required|string|max:150',
        ]);

        $service = ServiceCatalog::findOrFail($id);
        $service->update([
            'category_name' => $request->category_name,
            'service_name' => $request->service_name,
        ]);

        return redirect()->route('service_catalog.index')
                        ->with('success', 'Service berhasil diperbarui!');
    }

    // Hapus data
    public function destroy($id)
    {
        $service = ServiceCatalog::findOrFail($id);
        $service->delete();

        return redirect()->route('service_catalog.index')
                        ->with('success', 'Service berhasil dihapus!');
    }
}