@section('content')
    <div class="container">
        <h2>Proposal Event Anda</h2>
        @foreach($events as $event)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $event->title }}</h5>
                    <p>Status: 
                        @if($event->status == 'approved')
                            <span class="text-success">Disetujui</span>
                        @elseif($event->status == 'rejected')
                            <span class="text-danger">Ditolak</span>
                        @else
                            <span class="text-warning">Menunggu Persetujuan</span>
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@endsection