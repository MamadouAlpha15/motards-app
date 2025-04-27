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
        $recherche = $request->input('recherche'); // Récupère ce que l'utilisateur a tapé dans la barre de recherche
        $typeRecherche = null; // Initialise une variable pour déterminer quel type de recherche a été fait

        $motards = collect(); // Crée une collection vide de motards pour l'instant

        if ($recherche) { // Si l'utilisateur a fait une recherche
            $lignesExistantes = Motard::distinct()->pluck('ligne')->toArray(); // Récupère toutes les lignes différentes (sans doublon)

            // Teste si la recherche correspond à une ligne existante
            if (in_array($recherche, $lignesExistantes)) {
                $typeRecherche = 'ligne';
                $motards = Motard::where('ligne', $recherche)->get(); // Cherche par ligne
            }
            // Sinon teste si la recherche correspond à un matricule
            elseif (Motard::where('matricule', 'like', '%' . $recherche . '%')->exists()) {
                $typeRecherche = 'matricule';
                $motards = Motard::where('matricule', 'like', '%' . $recherche . '%')->get();
            }
            // Sinon teste si correspond à un nom ou un prénom
            elseif (Motard::where('nom', 'like', '%' . $recherche . '%')
                ->orWhere('prenom', 'like', '%' . $recherche . '%')->exists()) {
                $typeRecherche = 'nom';
                $motards = Motard::where('nom', 'like', '%' . $recherche . '%')
                    ->orWhere('prenom', 'like', '%' . $recherche . '%')->get();
            }
            // Sinon cherche par stationnement (exemple T8)
            elseif (Motard::where('base_stationnement', 'like', '%' . $recherche . '%')->exists()) {
                $typeRecherche = 'base_stationnement';
                $motards = Motard::where('base_stationnement', 'like', '%' . $recherche . '%')->get();
            } else {
                $typeRecherche = 'inconnu'; // Aucun motard trouvé
            }
        } else {
            // Si aucune recherche, on affiche tous les motards triés par ligne
            $motards = Motard::orderBy('ligne')->get();
        }

        $motardsParLigne = $motards->groupBy('ligne'); // Regroupe les motards par leur ligne

        // Retourne la vue avec les données
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
}
