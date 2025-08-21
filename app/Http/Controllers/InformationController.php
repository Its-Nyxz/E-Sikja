<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    protected string $pathUpload;
    public function __construct()
    {
        if (Auth::user()->role != 'admin') {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }

        $this->pathUpload = public_path('uploads/informations/');
    }
    public function index()
    {
        if (request()->ajax()) {
            $informations = Information::with('user')->latest();
            return DataTables::of($informations)
                ->addIndexColumn()
                ->addColumn('action', function ($information) {
                    return '
                        <div class="btn-group">
                            <a href="' . route('informasi-kelurahan.show', $information->id) . '" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="' . route('informasi-kelurahan.edit', $information->id) . '" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $information->id . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->addColumn('status_badge', function ($information) {
                    return $information->status 
                        ? '<span class="badge badge-success">Aktif</span>'
                        : '<span class="badge badge-danger">Nonaktif</span>';
                })
                ->addColumn('image_preview', function ($information) {
                    return $information->image 
                        ? '<img src="' . asset($information->image) . '" class="img-thumbnail" width="50">'
                        : '<span class="text-muted">No Image</span>';
                })
                ->rawColumns(['action', 'status_badge', 'image_preview'])
                ->make(true);
        }
        $data = [
            'title' => 'Informasi Kelurahan'
        ];

        return view('information.index')->with($data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Informasi'
        ];

        return view('information.create')->with($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($this->pathUpload, $imageName);
            $data['image'] = 'uploads/informations/' . $imageName;
        }

        Information::create($data);

        return redirect()->route('informasi-kelurahan.index')
            ->with('success', 'Informasi berhasil ditambahkan');
    }

    public function show($id)
    {
        $information = Information::with('user')->findOrFail($id);
        $data = [
            'title' => 'Detail Informasi',
            'information' => $information
        ];
        return view('information.show')->with($data);
    }

    public function edit($id)
    {
        $information = Information::findOrFail($id);
        $data = [
            'title' => 'Edit Informasi',
            'information' => $information
        ];
        return view('information.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'status' => 'required|boolean'
        ]);

        $information = Information::findOrFail($id);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($information->image) {
                $oldImagePath = public_path($information->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($this->pathUpload, $imageName);
            $data['image'] = 'uploads/informations/' . $imageName;
        }

        $information->update($data);

        return redirect()->route('informasi-kelurahan.index')
            ->with('success', 'Informasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $information = Information::findOrFail($id);
        
        if ($information->image) {
            $imagePath = public_path($information->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $information->delete();

        return response()->json(['success' => true]);
    }

    public function toggleStatus($id)
    {
        $information = Information::findOrFail($id);
        $information->status = !$information->status;
        $information->save();
        
        return response()->json(['success' => true]);
    }
}
