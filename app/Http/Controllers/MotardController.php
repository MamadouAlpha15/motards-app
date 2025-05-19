<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motard;
use App\Models\Commune;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MotardController extends Controller
{
    public function index(Request $request)
    {
        $recherche = $request->input('recherche');
        $typeRecherche = null;

        // 🔄 Sélection de la commune selon le rôle
        if (auth()->user()->is_super_admin) {
            $communeSlug = $request->commune;

            if (!$communeSlug) {
                return redirect()->route('communes.choix')->withErrors(['commune' => 'Veuillez sélectionner une commune.']);
            }
        } else {
            $communeSlug = optional(auth()->user()->commune)->slug;

            if (!$communeSlug) {
                abort(403, 'Aucune commune assignée à cet utilisateur.');
            }
        }

        $commune = Commune::where('slug', $communeSlug)->firstOrFail();

        $query = Motard::where('commune_id', $commune->id);

        if ($recherche) {
            $query->where(function ($q) use ($recherche) {
                $q->where('matricule', 'like', "%$recherche%")
                    ->orWhere('nom', 'like', "%$recherche%")
                    ->orWhere('prenom', 'like', "%$recherche%")
                    ->orWhere('ligne', 'like', "%$recherche%")
                    ->orWhere('base_stationnement', 'like', "%$recherche%");
            });
        }

        $motards = $query->orderBy('ligne')->orderBy('created_at', 'desc')->get();
        $motardsParLigne = $motards->groupBy('ligne');

        return view('motard_index', compact('motardsParLigne', 'recherche', 'typeRecherche', 'commune'));
    }

    public function create(Request $request)
    {
        return view('motards_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'telephone' => 'required',
            'ligne' => 'required',
            'numero_tuteur' => 'required',
            'matricule' => 'required|unique:motards',
            'base_stationnement' => 'required|string',
            'station' => 'nullable|string',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // 🔒 Déterminer la commune à associer
        if (auth()->user()->is_super_admin) {
            $slug = request()->query('commune');
            $commune = Commune::where('slug', $slug)->first();
            if (!$commune) {
                return back()->withErrors(['commune' => 'Commune invalide ou non trouvée.']);
            }
            $data['commune_id'] = $commune->id;
        } else {
            $data['commune_id'] = auth()->user()->commune_id;
        }

        Motard::create($data);

        return redirect()->route('motards.index', ['commune' => $slug ?? null])->with('success', 'Motard ajouté !');
    }

    public function show($slug)
    {
        $motard = Motard::where('slug', $slug)->firstOrFail();
        return view('motards_show', compact('motard'));
    }

    public function qr($id)
    {
        $url = route('motards.show', $id);
        return QrCode::size(200)->generate($url);
    }

    public function carte($slug)
    {
        $motard = Motard::where('slug', $slug)->firstOrFail();
        return view('motards_carte', compact('motard'));
    }

    public function publicite()
    {
        return view('publicite');
    }

    public function edit($id)
    {
        $motard = Motard::findOrFail($id);
        return view('motards_edit', compact('motard'));
    }

    public function update(Request $request, $id)
    {
        $motard = Motard::findOrFail($id);

        $data = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'telephone' => 'required',
            'ligne' => 'required',
            'numero_tuteur' => 'required',
            'matricule' => 'required|unique:motards,matricule,' . $motard->id,
            'base_stationnement' => 'required|string',
            'station' => 'nullable|string',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $motard->update($data);

        return redirect()->route('motards.index', ['commune' => optional($motard->commune)->slug])->with('success', 'Motard mis à jour avec succès !');
    }

    public function destroy($id)
    {
        $motard = Motard::findOrFail($id);
        $motard->delete();

        return redirect()->route('motards.index', ['commune' => optional($motard->commune)->slug])->with('success', 'Motard supprimé avec succès !');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('motards_selection');
        if ($ids) {
            Motard::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Motards supprimés avec succès.');
        } else {
            return redirect()->back()->with('error', 'Aucun motard sélectionné.');
        }
    }

    public function imprimerSelection(Request $request)
    {
        $ids = explode(',', $request->ids);
        $motards = Motard::whereIn('id', $ids)->get();

        return view('motards_imprimer_selection', compact('motards'));
    }
}
