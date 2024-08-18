<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $sections = Section::where('user_id', $user->id)->get();
        return view('section', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'section_name' => 'required|string|max:255',
        ]);

        $section = new Section();
        $section->section_name = $request->input('section_name');
        $section->user_id = Auth::id(); // Foydalanuvchi ID sini olish
        $section->save();

        return redirect()->route('sections.index')->with('success', 'Bo\'lim muvaffaqiyatli qo\'shildi');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->route('sections.index')->with('success', 'Bo\'lim muvaffaqiyatli o\'chirildi');
    }
}
