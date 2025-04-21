<?php

namespace App\Http\Controllers;

// Importation des classes nécessaires
use Illuminate\Http\Request;
use App\Models\Motard;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MotardController extends Controller
{
    /**
     * Affiche la liste des motards, groupés par ligne.
     */
  public function index(Request $request)
{
    $recherche = $request->input('recherche');
    $typeRecherche = null;

    $motards = collect(); // collection vide par défaut

    if ($recherche) {
        // Récupère toutes les lignes existantes (distinctes)
        $lignesExistantes = Motard::distinct()->pluck('ligne')->toArray();

        // Détection du type de recherche
        if (in_array($recherche, $lignesExistantes)) {
            $typeRecherche = 'ligne';
            $motards = Motard::where('ligne', $recherche)->get();
        } elseif (Motard::where('matricule', 'like', '%' . $recherche . '%')->exists()) {
            $typeRecherche = 'matricule';
            $motards = Motard::where('matricule', 'like', '%' . $recherche . '%')->get();
        } elseif (Motard::where('nom', 'like', '%' . $recherche . '%')
            ->orWhere('prenom', 'like', '%' . $recherche . '%')->exists()) {
            $typeRecherche = 'nom';
            $motards = Motard::where('nom', 'like', '%' . $recherche . '%')
                ->orWhere('prenom', 'like', '%' . $recherche . '%')->get();
        } else {
            $typeRecherche = 'inconnu';
        }
    } else {
        // Si pas de recherche, on affiche tous les motards
        $motards = Motard::orderBy('ligne')->get();
    }

    $motardsParLigne = $motards->groupBy('ligne');

    return view('motard_index', compact('motardsParLigne', 'recherche', 'typeRecherche'));
}


    
    
    /**
     * Affiche le formulaire de création d'un motard.
     */
    public function create()
    {
        // Affiche la vue pour créer un nouveau motard
        return view('motards_create');
    }

    /**
     * Enregistre un nouveau motard dans la base de données.
     */
    public function store(Request $request)
    {
        // Valide les données envoyées par le formulaire
        $data = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'telephone' => 'required',
            'ligne' => 'required',
            'numero_tuteur' => 'required',
            'matricule' => 'required|unique:motards', // Le matricule doit être unique
            'base_stationnement' => 'required|string',
            'station' => 'nullable|string', // Champ optionnel
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048', // Fichier image obligatoire (max 2MB)
        ]);

        // Si une photo est envoyée, on la stocke et on enregistre le chemin
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Création du motard avec les données validées
        Motard::create($data);

        // Redirige vers la liste avec un message de succès
        return redirect()->route('motards.index')->with('success', 'Motard ajouté !');
    }

    /**
     * Affiche la fiche publique d'un motard à partir de son slug.
     */
    public function show($slug)
    {
        // Cherche le motard via son slug (clé unique)
        $motard = Motard::where('slug', $slug)->firstOrFail();

        // Affiche la vue de détail du motard
        return view('motards_show', compact('motard'));
    }

    /**
     * Génère le QR Code contenant le lien vers la fiche du motard.
     */
    public function qr($id)
    {
        // Génère l'URL vers la fiche publique du motard
        $url = route('motards.show', $id);

        // Génère et retourne le QR Code
        return QrCode::size(200)->generate($url);
    }

    /**
     * Affiche la carte d'identité imprimable du motard.
     */
    public function carte($slug)
    {
        // Cherche le motard via son slug
        $motard = Motard::where('slug', $slug)->firstOrFail();

        // Affiche la vue de la carte avec les infos du motard
        return view('motards_carte', compact('motard'));
    }

   public function publicite(){
     
    return view('publicite');
   }

   /**
 * Affiche le formulaire d'édition d'un motard.
 */
public function edit($id)
{
    $motard = Motard::findOrFail($id);
    return view('motards_edit', compact('motard'));
}

/**
 * Met à jour les infos d'un motard.
 */
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

    return redirect()->route('motards.index')->with('success', 'Motard mis à jour avec succès !');
}

/**
 * Supprime un motard.
 */
public function destroy($id)
{
    $motard = Motard::findOrFail($id);
    $motard->delete();

    return redirect()->route('motards.index')->with('success', 'Motard supprimé avec succès !');
}



}
