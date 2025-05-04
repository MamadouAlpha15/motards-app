@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
        <h2 class="text-center text-md-start mb-3 mb-md-0">👨‍💼 Liste des Administrateurs</h2>
        <a href="{{ route('motards.index') }}" class="btn btn-warning">
            <i class="bi bi-arrow-left"></i> Retour à la Liste Motards
        </a>
    </div>

    <hr>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Message d'erreur --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Créé le</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $admin)
                    <tr class="text-center align-middle">
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($admin->id !== Auth::id())
                                <form method="POST" action="{{ route('admin.supprimer', $admin->id) }}"
                                      onsubmit="return confirm('Supprimer cet administrateur ?')"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">Vous</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucun administrateur trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
