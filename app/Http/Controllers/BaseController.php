<?php

namespace App\Http\Controllers;

use App\Librostest;
use Illuminate\Http\Request;

/**
 * Class LibrostestController
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
    public function index()
    {
        $librostests = Librostest::paginate();

        return view('librostest.index', compact('librostests'));
    }
    public function create()
    {
        return view('librostest.create');
    }
    public function store(Request $request)
    {
        request()->validate(Librostest::$rules);

        $librostest = Librostest::create($request->all());

        return redirect()->route('librostest.index')
            ->with('success', 'Librostest created successfully.');
    }
    public function show($id)
    {
        $librostest = Librostest::find($id);

        return view('librostest.show', compact('librostest'));
    }
    public function edit($id)
    {
        $librostest = Librostest::find($id);

        return view('librostest.edit', compact('librostest'));
    }
    public function update(Request $request, Librostest $librostest)
    {
        request()->validate(Librostest::$rules);

        $librostest->update($request->all());

        return redirect()->route('librostest.index')
            ->with('success', 'Librostest updated successfully');
    }
    public function destroy($id)
    {
        $librostest = Librostest::find($id)->delete();

        return redirect()->route('librostest.index')
            ->with('success', 'Librostest deleted successfully');
    }
}
