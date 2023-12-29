<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartyController extends Controller
{
    public function index()
    {
        $parties = Party::paginate(10); // Adjust the pagination as needed

        return view('parties.index', compact('parties'));
    }

    public function create()
    {
        return view('parties.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partyName' => 'required|string|max:255',
            'partyCNIC' => 'required|string|unique:parties|max:10',
            'partyAddress' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('parties.create')
                ->withErrors($validator)
                ->withInput();
        }

        Party::create([
            'partyName' => $request->input('partyName'),
            'partyCNIC' => $request->input('partyCNIC'),
            'partyAddress' => $request->input('partyAddress'),
        ]);

        return redirect()->route('parties.index')
            ->with('success', __('Party created successfully.'));
    }

    public function edit($id)
    {
        $party = Party::findOrFail($id);

        return view('parties.edit', compact('party'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'partyName' => 'required|string|max:255',
            'partyCNIC' => 'required|string|max:10|unique:parties,partyCNIC,' . $id,
            'partyAddress' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('parties.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $party = Party::findOrFail($id);
        $party->update([
            'partyName' => $request->input('partyName'),
            'partyCNIC' => $request->input('partyCNIC'),
            'partyAddress' => $request->input('partyAddress'),
        ]);

        return redirect()->route('parties.index')
            ->with('success', __('Party updated successfully.'));
    }

    public function show($id)
    {
        $party = Party::findOrFail($id);

        return view('parties.show', compact('party'));
    }

    public function destroy($id)
    {
        $party = Party::findOrFail($id);
        $party->delete();

        return redirect()->route('parties.index')
            ->with('success', __('Party deleted successfully.'));
    }
}

