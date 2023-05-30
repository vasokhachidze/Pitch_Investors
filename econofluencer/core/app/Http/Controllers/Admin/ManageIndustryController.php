<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;

class ManageIndustryController extends Controller {

    public function industry(Request $request) {
        $pageTitle = 'Industries';
        $industries   = Industry::query();
        if ($request->search) {
            $search = $request->search;
            $industries   = $industries->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            });
        }
        $industries = $industries->latest()->paginate(getPaginate());
        return view('admin.industry.index', compact('pageTitle', 'industries'));
    }

    public function store(Request $request, $id = 0) {
        $request->validate([
            'name' => 'required|string|unique:industries,name,'.$id,
        ]);

        if ($id) {
            $industry          = Industry::findOrFail($id);
            $notification = 'Industry updated successfully';
        } else {
            $industry          = new Industry();
            $notification = 'Industry created successfully';
        }
        $industry->name = $request->name;
        $industry->save();
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function delete($id) {
        Industry::where('id', $id)->delete();
        $notify[] = ['success', 'Industry deleted successfully'];
        return back()->withNotify($notify);
    }
}
