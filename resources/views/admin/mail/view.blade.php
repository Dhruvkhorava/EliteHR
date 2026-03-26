@extends('admin.mail.layout')

@section('mail-content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>View Mail</h4>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Back
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <div>
                    <h5 class="mb-1">{{ $mail->subject }}</h5>
                    <p class="mb-0 text-muted">
                        From: <strong>{{ $mail->sender->name }}</strong> &lt;{{ $mail->sender->email }}&gt;
                    </p>
                    <p class="mb-0 text-muted">
                        To: <strong>{{ $mail->receiver->name ?? 'Draft' }}</strong>
                    </p>
                </div>
                <div class="text-end">
                    <p class="mb-0 text-muted">{{ $mail->created_at->format('M d, Y') }}</p>
                    <p class="mb-0 text-muted small">{{ $mail->created_at->format('h:i A') }}</p>
                </div>
            </div>
            <div class="card-body">
                <div class="mail-body-content" style="min-height: 200px; white-space: pre-wrap;">
                    {{ $mail->message }}
                </div>
            </div>
            <div class="card-footer bg-light d-flex justify-content-end">
                <form action="{{ route('mail.destroy', $mail->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger confirm-delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        Delete Mail
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
