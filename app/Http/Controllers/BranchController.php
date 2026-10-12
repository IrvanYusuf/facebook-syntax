<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::paginate();
        return view('branches', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:15',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        Branch::create($request->only(['name', 'address', 'phone']));

        return redirect()->route('branch.index')->with('success', 'Branch created successfully.');
    }
}
