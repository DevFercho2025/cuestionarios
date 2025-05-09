<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    // Métodos para el manejo de las compañías
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function datatable(Request $request)
    {
        $companies = Company::all();
    
        $companies = $companies->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
                'description' => $company->description ?? 'No proporcionada',
                'logo' => $company->logo ? asset('storage/logos/' . $company->logo) : null,
                'active' => $company->active ? 'Sí' : 'No',
                'created_at' => $company->created_at->format('Y-m-d H:i'),
                'updated_at' => $company->updated_at->format('Y-m-d H:i'),
            ];
        });
        Log::debug('Compañías cargadas', ['companies' => $companies]);
        return response()->json($companies);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048', // Validación del logo
        ]);
    
        // Crear una nueva compañía
        $company = new Company();
        $company->name = $request->input('name');
        $company->description = $request->input('description');
    
        // Si hay un logo, procesarlo
        if ($request->hasFile('logo')) {
            // Obtener el nombre original del archivo
            $logoFileName = $request->file('logo')->getClientOriginalName();  // Obtener el nombre del archivo
    
            // Guardar el archivo en la carpeta 'logos' dentro de 'public'
            $logoPath = $request->file('logo')->storeAs('logos', $logoFileName, 'public');
            
            // Almacenar solo el nombre del archivo en la base de datos
            $company->logo = $logoFileName;
        }
    
        // Guardar la compañía en la base de datos
        $company->save();
    
        // Respuesta exitosa
        return response()->json([
            'message' => 'Compañía creada exitosamente.',
            'company' => $company,
        ]);
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $company = Company::findOrFail($id);
        $company->update($request->except('logo')); //Actualizar todo menos logo

        //Si además tiene un logo, actualizar
        if ($request->hasFile('logo')) {
            // Eliminar el logo anterior si existe
            if ($company->logo && Storage::exists('public/logos/' . $company->logo)) {
                Storage::delete('public/logos/' . $company->logo);
            }
    
            // Obtener el nombre del archivo
            $logoFileName = $request->file('logo')->getClientOriginalName();
            
            // Guardar el nuevo logo en la carpeta 'logos' dentro de 'storage/public'
            $logoPath = $request->file('logo')->storeAs('logos', $logoFileName, 'public');
            
            // Guardar solo el nombre del archivo en la base de datos
            $company->logo = $logoFileName;
            $company->save();
        }

        return response()->json([
            'message' => 'Compañía actualizada exitosamente.',
            'company' => $company
        ]);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json([
            'message' => 'Compañía eliminada exitosamente.',
            'company' => $company
        ]);
    }

    public function all()
    {
        $companies = Company::all();
        return response()->json($companies);
    }
}
