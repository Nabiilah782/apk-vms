<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\ListServiceCatalog;
use App\Models\VendorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\DB;

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
    
        // Validasi - semua field opsional
        $validatedData = $request->validate([
            'vendor_name' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:100',
            'company_profile' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            'nib_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'service_lists' => 'nullable|string'
        ]);

        Log::info('Validated Data:', $validatedData);

        try {
            // Check if all fields are empty (optional but good for validation)
            $isEmpty = empty($validatedData['vendor_name']) && 
                   empty($validatedData['address']) && 
                   empty($validatedData['contact_person']) && 
                   !$request->hasFile('company_profile') && 
                   !$request->hasFile('nib_document') && 
                   empty($request->service_lists);

            if ($isEmpty) {
                Log::warning('Attempt to save vendor with all empty fields');
                // You can choose to allow empty vendor or reject
                // For now, let's allow but log it
            }

            // Create vendor
            $vendor = Vendor::create([
                'vendor_name' => $validatedData['vendor_name'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'contact_person' => $validatedData['contact_person'] ?? null,
            ]);

            Log::info('Vendor created:', ['id' => $vendor->id]);

            // Upload Company Profile
            if ($request->hasFile('company_profile')) {
                $companyProfile = $request->file('company_profile');
                $companyProfilePath = $companyProfile->store('vendor_documents/company_profiles', 'public');
            
                Log::info('Company Profile stored:', ['path' => $companyProfilePath]);
            
                VendorDocument::create([
                    'vendor_id' => $vendor->id,
                    'file_path' => $companyProfilePath,
                    'document_type' => 'company_profile', // Add this field to track document type
                    'original_name' => $companyProfile->getClientOriginalName(),
                ]);
            }

            // Upload NIB Document
            if ($request->hasFile('nib_document')) {
                $nibDocument = $request->file('nib_document');
                $nibDocumentPath = $nibDocument->store('vendor_documents/nib_documents', 'public');
            
                Log::info('NIB Document stored:', ['path' => $nibDocumentPath]);
            
                VendorDocument::create([
                    'vendor_id' => $vendor->id,
                    'file_path' => $nibDocumentPath,
                    'document_type' => 'nib_document', // Add this field to track document type
                    'original_name' => $nibDocument->getClientOriginalName(),
                ]);
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
    try {
        $vendor = Vendor::findOrFail($id);
        
        // Validate input - semua optional
        $validator = Validator::make($request->all(), [
            'vendor_name' => 'nullable|string|max:100',
            'contact_person' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'service_lists' => 'nullable|string',
            'documents_to_delete' => 'nullable|string',
        ], [
            // Custom messages jika diperlukan
        ]);
        
        // Validasi file hanya jika ada file yang diupload
        if ($request->hasFile('company_profile')) {
            $validator->addRules([
                'company_profile' => 'nullable|array',
                'company_profile.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            ]);
        }
        
        if ($request->hasFile('nib_document')) {
            $validator->addRules([
                'nib_document' => 'nullable|array',
                'nib_document.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);
        }
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        DB::beginTransaction();
        
        // Update vendor information
        $vendor->update([
            'vendor_name' => $request->vendor_name ?? $vendor->vendor_name,
            'contact_person' => $request->contact_person ?? $vendor->contact_person,
            'address' => $request->address ?? $vendor->address,
        ]);
        
        // Update service lists
        if ($request->service_lists) {
            $serviceLists = json_decode($request->service_lists, true);
            if (is_array($serviceLists)) {
                $vendor->serviceLists()->sync($serviceLists);
            }
        } elseif ($request->has('service_lists')) {
            // Jika service_lists dikirim tapi kosong
            $vendor->serviceLists()->detach();
        }
        
        // Handle documents to delete
        if ($request->documents_to_delete) {
            $documentsToDelete = json_decode($request->documents_to_delete, true);
            if (is_array($documentsToDelete)) {
                foreach ($documentsToDelete as $documentId) {
                    $document = VendorDocument::find($documentId);
                    if ($document && $document->vendor_id == $vendor->id) {
                        Storage::disk('public')->delete($document->file_path);
                        $document->delete();
                    }
                }
            }
        }
        
        // Handle company profile uploads
        if ($request->hasFile('company_profile')) {
            foreach ($request->file('company_profile') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('vendor-documents', 'public');
                    
                    VendorDocument::create([
                        'vendor_id' => $vendor->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientMimeType(),
                        'document_type' => 'company_profile',
                    ]);
                }
            }
        }
        
        // Handle NIB document uploads
        if ($request->hasFile('nib_document')) {
            foreach ($request->file('nib_document') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('vendor-documents', 'public');
                    
                    VendorDocument::create([
                        'vendor_id' => $vendor->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientMimeType(),
                        'document_type' => 'nib_document',
                    ]);
                }
            }
        }
        
        DB::commit();
        
        return redirect()->route('data_vendors.index')
            ->with('success', 'Vendor berhasil diperbarui.');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            ->withInput();
    }
}

public function destroyDocument($id)
{
    try {
        $document = VendorDocument::findOrFail($id);
        
        // Delete file from storage
        Storage::disk('public')->delete($document->file_path);
        
        // Delete record
        $document->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil dihapus.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus dokumen: ' . $e->getMessage()
        ], 500);
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
