<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Repositories\CompanyRepository;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $companies = Company::all();
            return Datatables::of($companies)
                ->addIndexColumn()
                ->addColumn('image', function ($company) {
                    return '<img src="' . asset('storage/logos/' . $company->logo) . '" alt="Image" width="50" height="50">';
                })
                ->addColumn('action', function ($company) {
                    $editBtn = "<a href='" . route('companies.edit', ['company' => $company->id]) . "' class='edit btn btn-success btn-sm'>Edit</a>";

                    $deleteBtn = "<button type='button' class='btn btn-danger delete-btn' data-id=" . $company->id . "> Delete </button>";

                    $action = "<div class='d-flex gap-2'>" . $editBtn . $deleteBtn . "</div>";
                    return $action;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('company.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateCompanyData($request, null, false);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $company = new Company;

        $createdCompany = $this->companyRepository->save($company, $request->all());

        if ($createdCompany) {
            return response()->json(['success' => true, 'message' => 'Company created successfully']);
        } else {
            // Handle the case where the creation failed
            return response()->json(['error' => 'Failed to create company'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);

        return view('company.edit', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = Company::find($id);

        if (!$company) {
            return null; // or throw an exception, depending on your needs
        }

        $validator = $this->validateCompanyData($request, $id, true);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updatedCompany = $this->companyRepository->save($company, $request->all());

        if ($updatedCompany) {
            // return response()->json(['message' => 'Company updated successfully'], 200);
            return response()->json(['success' => true, 'message' => 'Company updated successfully']);
        } else {
            // Handle the case where the creation failed
            return response()->json(['error' => 'Failed to update company'], 500);
        }
    }

    public function delete($id)
    {
        $company = Company::find($id);

        return view('company.delete', ['company' => $company]);
    }

    public function destroy($id)
    {
        $company = Company::find($id);

        if ($company) {
            $company->delete();
            // Return a success message or any other relevant information
            return response()->json(['message' => 'Company deleted successfully']);
        } else {
            // Return an error message or any other relevant information
            return response()->json(['message' => 'Company not found or deletion failed'], 404);
        }
    }

    protected function validateCompanyData(Request $request, $companyId = null, $isUpdate)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'required|url|max:255',
        ];

        $messages = [
            'logo.dimensions' => 'Logo must be at least 100x100',
        ];

        // Add unique rule for updating companies
        if ($companyId) {
            $rules['name'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('companies')->ignore($companyId),
            ];
        } else {
            $rules['name'] = 'required|string|max:255|unique:companies';
        }

        if (!$isUpdate) {
            $rules['logo'] = [
                'required',
                'image',
                'dimensions:min_width=100,min_height=100',
                Rule::dimensions()->minWidth(100)->minHeight(100),
            ];
        }

        return Validator::make($request->all(), $rules, $messages);
    }
}
