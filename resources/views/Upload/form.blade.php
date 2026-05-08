@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="mb-3">Upload Proposal</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }} <br>
            <small>File disimpan di: {{ session('file_path') }}</small>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card p-4 shadow-sm">

        <form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Pilih Event</label>
                <select name="event_id" class="form-select" required>
                    <option value="">-- Pilih Event --</option>

                    @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Dokumen</label>
                <input type="text" name="type" class="form-control" value="Proposal" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload File Proposal</label>
                <input type="file" name="file" class="form-control" required>
                <small class="text-muted">Format: pdf/doc/docx/jpg/png | Maks 2MB</small>
            </div>

            <button class="btn btn-primary w-100">Upload Proposal</button>
        </form>

    </div>
</div>
@endsection