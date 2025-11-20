@extends('layouts.app')

@section('title', 'Add Vineyard')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4"><i class="fas fa-plus"></i> Add New Vineyard</h2>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('vineyards.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="odroda" class="form-label">Variety <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('odroda') is-invalid @enderror" 
                                   id="odroda" name="odroda" value="{{ old('odroda') }}" required>
                            @error('odroda')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pocet_hlav" class="form-label">Number of Heads <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('pocet_hlav') is-invalid @enderror" 
                                   id="pocet_hlav" name="pocet_hlav" value="{{ old('pocet_hlav') }}" min="1" required>
                            @error('pocet_hlav')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rok_vysadby" class="form-label">Planted Year <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('rok_vysadby') is-invalid @enderror" 
                                   id="rok_vysadby" name="rok_vysadby" value="{{ old('rok_vysadby', now()->year) }}" 
                                   min="1900" max="{{ now()->year }}" required>
                            @error('rok_vysadby')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="barva" class="form-label">Color <span class="text-danger">*</span></label>
                            <select class="form-select @error('barva') is-invalid @enderror" id="barva" name="barva" required>
                                <option value="">-- Select Color --</option>
                                <option value="white" {{ old('barva') == 'white' ? 'selected' : '' }}>White</option>
                                <option value="red" {{ old('barva') == 'red' ? 'selected' : '' }}>Red</option>
                            </select>
                            @error('barva')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="zodpovedna_os" class="form-label">Responsible Person</label>
                            <input type="text" class="form-control @error('zodpovedna_os') is-invalid @enderror" 
                                   id="zodpovedna_os" name="zodpovedna_os" value="{{ old('zodpovedna_os') }}">
                            @error('zodpovedna_os')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Vineyard
                            </button>
                            <a href="{{ route('vineyards.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
