<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\ListServiceCatalog;
use App\Models\VendorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DataVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Vendor::with(['documents', 'serviceLists'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('data_vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $serviceLists = ListServiceCatalog::all();
        return view('data_vendors.create', compact('serviceLists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug log
        Log::info('Form Data Received:', $request->all());
        
        // Validasi
        $validatedData = $request->validate([
            'vendor_name' => 'required|string|max:100',
            'address' => 'required|string',
            'contact_person' => 'required|string|max:100',
            'file_path.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            'service_lists' => 'nullable|string'
        ]);

        Log::info('Validated Data:', $validatedData);

        try {
            // Create vendor
            $vendor = Vendor::create([
                'vendor_name' => $validatedData['vendor_name'],
                'address' => $validatedData['address'],
                'contact_person' => $validatedData['contact_person'],
            ]);

            Log::info('Vendor created:', ['id' => $vendor->id]);

            // Upload documents
            if ($request->hasFile('file_path')) {
                Log::info('Files found:', ['count' => count($request->file('file_path'))]);
                
                foreach ($request->file('file_path') as $file) {
                    $path = $file->store('vendor_documents', 'public');
                    
                    Log::info('File stored:', ['path' => $path]);
                    
                    VendorDocument::create([
                        'vendor_id' => $vendor->id,
                        'file_path' => $path,
                    ]);
                }
            }

            // Attach service lists
            if ($request->has('service_lists') && !empty($request->service_lists)) {
                $serviceLists = json_decode($request->service_lists, true);
                
                if (is_array($serviceLists) && count($serviceLists) > 0) {
                    $validServiceIds = ListServiceCatalog::whereIn('id', $serviceLists)->pluck('id')->toArray();
                    
                    if (count($validServiceIds) > 0) {
                        $vendor->serviceLists()->attach($validServiceIds);
                        Log::info('Service lists attached:', $validServiceIds);
                    }
                }
            }

            return redirect()->route('data_vendors.index')
                ->with('success', 'Vendor berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Error creating vendor: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vendor = Vendor::with(['documents', 'serviceLists'])->findOrFail($id);
        $serviceLists = ListServiceCatalog::all();
        
        $selectedServiceLists = $vendor->serviceLists->pluck('id')->toArray();
        
        return view('data_vendors.edit', compact('vendor', 'serviceLists', 'selectedServiceLists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'vendor_name' => 'required|string|max:100',
            'address' => 'required|string',
            'contact_person' => 'required|string|max:100',
            'file_path.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            'service_lists' => 'nullable|string'
        ]);

        try {
            $vendor = Vendor::findOrFail($id);
            
            // Update vendor
            $vendor->update([
                'vendor_name' => $validatedData['vendor_name'],
                'address' => $validatedData['address'],
                'contact_person' => $validatedData['contact_person'],
            ]);

            // Upload new documents
            if ($request->hasFile('file_path')) {
                foreach ($request->file('file_path') as $file) {
                    $path = $file->store('vendor_documents', 'public');
                    
                    VendorDocument::create([
                        'vendor_id' => $vendor->id,
                        'file_path' => $path,
                    ]);
                }
            }

            // Sync service lists
            if ($request->has('service_lists') && !empty($request->service_lists)) {
                $serviceLists = json_decode($request->service_lists, true);
                
                if (is_array($serviceLists)) {
                    $vendor->serviceLists()->sync($serviceLists);
                } else {
                    $vendor->serviceLists()->sync([]);
                }
            } else {
                $vendor->serviceLists()->sync([]);
            }

            return redirect()->route('data_vendors.index')
                ->with('success', 'Vendor berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Error updating vendor: ' . $e->getMessage());
            
            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $vendor = Vendor::findOrFail($id);
            
            // Delete documents
            foreach ($vendor->documents as $document) {
                Storage::disk('public')->delete($document->file_path);
                $document->delete();
            }
            
            // Detach service lists
            $vendor->serviceLists()->detach();
            
            // Delete vendor
            $vendor->delete();

            return redirect()->route('data_vendors.index')
                ->with('success', 'Vendor berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Error deleting vendor: ' . $e->getMessage());
            
            return redirect()->route('data_vendors.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Delete specific document
     */
    public function deleteDocument($id)
    {
        try {
            $document = VendorDocument::findOrFail($id);
            
            // Delete file from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            // Delete record from database
            $document->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting document: ' . $e->getMessage());
            
            return response()->json([
                'success' => false, 
                'message' => 'Gagal menghapus dokumen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get vendor documents for modal view - SIMPLIFIED
     */
    public function getVendorDocuments($id)
    {
        try {
            $vendor = Vendor::findOrFail($id);
            $documents = $vendor->documents;
            
            return view('partials.vendor_documents', compact('vendor', 'documents'));
            
        } catch (\Exception $e) {
            Log::error('Error getting vendor documents: ' . $e->getMessage());
            
            return response()->view('partials.error', [
                'message' => 'Gagal mengambil dokumen vendor'
            ], 404);
        }
    }
    
    /**
     * Download document - SIMPLIFIED
     */
    public function downloadDocument($id)
    {
        try {
            $document = VendorDocument::findOrFail($id);
            
            // Check if file exists
            if (!Storage::disk('public')->exists($document->file_path)) {
                abort(404, 'File tidak ditemukan');
            }
            
            $filePath = Storage::disk('public')->path($document->file_path);
            
            // Ambil nama file dari path
            $fileName = basename($document->file_path);
            
            return response()->download($filePath, $fileName);
            
        } catch (\Exception $e) {
            Log::error('Error downloading document: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal mengunduh dokumen: ' . $e->getMessage());
        }
    }
    
    /**
     * View document inline - SIMPLIFIED
     */
    public function viewDocument($id)
    {
        try {
            $document = VendorDocument::findOrFail($id);
            
            // Check if file exists
            if (!Storage::disk('public')->exists($document->file_path)) {
                abort(404, 'File tidak ditemukan');
            }
            
            $filePath = Storage::disk('public')->path($document->file_path);
            
            return response()->file($filePath);
            
        } catch (\Exception $e) {
            Log::error('Error viewing document: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal menampilkan dokumen: ' . $e->getMessage());
        }
    }
}