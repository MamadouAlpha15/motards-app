<?php

namespace App\Http\Controllers;

// Importation des classes utiles de Laravel et des packages
use Illuminate\Http\Request;
use App\Models\Motard; // Le model Motard représente la table "motards" dans la base de données
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Pour générer des QR Codes

class MotardController extends Controller
{
    /**
     * Affiche la liste des motards, avec possibilité de recherche.
     */
    public function index(Request $request)
{
    $recherche = $request->input('recherche');
    $typeRecherche = null;

    if ($recherche) {
        // Récupère toutes les lignes existantes
        $lignesExistantes = Motard::distinct()->pluck('ligne')->toArray();

        if (in_array($recherche, $lignesExistantes)) {
            // Recherche par ligne
            $typeRecherche = 'ligne';
            $motards = Motard::where('ligne', $recherche)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        elseif (Motard::where('matricule', 'like', '%' . $recherche . '%')->exists()) {
            // Recherche par matricule
            $typeRecherche = 'matricule';
            $motards = Motard::where('matricule', 'like', '%' . $recherche . '%')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        elseif (Motard::where('nom', 'like', '%' . $recherche . '%')
            ->orWhere('prenom', 'like', '%' . $recherche . '%')
            ->exists()
        ) {
            // Recherche par nom ou prénom
            $typeRecherche = 'nom';
            $motards = Motard::where('nom', 'like', '%' . $recherche . '%')
                ->orWhere('prenom', 'like', '%' . $recherche . '%')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        elseif (Motard::where('base_stationnement', 'like', '%' . $recherche . '%')->exists()) {
            // Recherche par stationnement
            $typeRecherche = 'base_stationnement';
            $motards = Motard::where('base_stationnement', 'like', '%' . $recherche . '%')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        else {
            // Aucun résultat
            $typeRecherche = 'inconnu';
            $motards = collect();
        }
    } else {
        // Liste complète, triée par ligne puis date de création (nouveau en premier)
        $motards = Motard::orderBy('ligne')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Regroupe par ligne pour la vue
    $motardsParLigne = $motards->groupBy('ligne');

    return view('motard_index', compact('motardsParLigne', 'recherche', 'typeRecherche'));
}

    /**
     * Affiche le formulaire d'ajout d'un nouveau motard.
     */
    public function create()
    {
        return view('motards_create'); // Retourne la vue "ajouter un motard"
    }

    /**
     * Enregistre un nouveau motard dans la base.
     */
    public function store(Request $request)
    {
        // Valide les champs entrés par l'utilisateur
        $data = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'telephone' => 'required',
            'ligne' => 'required',
            'numero_tuteur' => 'required',
            'matricule' => 'required|unique:motards', // Empêche les doublons de matricule
            'base_stationnement' => 'required|string',
            'station' => 'nullable|string',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048', // Photo valide de 2 Mo max
        ]);

        // Si une photo est présente dans la requête
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public'); // Stocke l'image
        }

        Motard::create($data); // Crée un nouveau motard avec les données validées

        return redirect()->route('motards.index')->with('success', 'Motard ajouté !'); // Redirige avec message de succès
    }

    /**
     * Affiche les détails d'un motard.
     */
    public function show($slug)
    {
        $motard = Motard::where('slug', $slug)->firstOrFail(); // Cherche le motard par son slug
        return view('motards_show', compact('motard')); // Affiche la vue
    }

    /**
     * Génère un QR Code qui mène à la fiche publique du motard.
     */
    public function qr($id)
    {
        $url = route('motards.show', $id); // URL vers la page publique du motard
        return QrCode::size(200)->generate($url); // Retourne le QR Code généré
    }

    /**
     * Affiche la carte d'identité du motard.
     */
    public function carte($slug)
    {
        $motard = Motard::where('slug', $slug)->firstOrFail(); // Récupère le motard
        return view('motards_carte', compact('motard')); // Affiche la carte
    }

    /**
     * Affiche une page de publicité (optionnel).
     */
    public function publicite()
    {
        return view('publicite');
    }

    /**
     * Affiche la page pour modifier un motard.
     */
    public function edit($id)
    {
        $motard = Motard::findOrFail($id); // Récupère le motard à modifier
        return view('motards_edit', compact('motard'));
    }

    /**
     * Enregistre la mise à jour d'un motard.
     */
    public function update(Request $request, $id)
    {
        $motard = Motard::findOrFail($id); // Récupère le motard ciblé

        $data = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'telephone' => 'required',
            'ligne' => 'required',
            'numero_tuteur' => 'required',
            'matricule' => 'required|unique:motards,matricule,' . $motard->id, // Matricule doit être unique sauf pour lui-même
            'base_stationnement' => 'required|string',
            'station' => 'nullable|string',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $motard->update($data); // Met à jour avec les nouvelles données

        return redirect()->route('motards.index')->with('success', 'Motard mis à jour avec succès !');
    }

    /**
     * Supprime un motard de la base.
     */
    public function destroy($id)
    {
        $motard = Motard::findOrFail($id); // Trouve le motard
        $motard->delete(); // Supprime le motard

        return redirect()->route('motards.index')->with('success', 'Motard supprimé avec succès !');
    }


    
    public function deleteSelected(Request $request)
{
    $ids = $request->input('motards_selection');
    if ($ids) {
        Motard::whereIn('id', $ids)->delete();
        return redirect()->route('motards.index')->with('success', 'Motards supprimés avec succès.');
    } else {
        return redirect()->route('motards.index')->with('error', 'Aucun motard sélectionné.');
    }
}

public function imprimerSelection(Request $request)
{
    $ids = explode(',', $request->ids);

    $motards = Motard::whereIn('id', $ids)->get();

    return view('motards_imprimer_selection', compact('motards'));
}


}
