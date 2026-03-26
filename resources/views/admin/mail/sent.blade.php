@extends('admin.mail.layout')

@section('mail-content')
<div class="row">
    <div class="col-md-12">
        <h4>Sent Mails</h4>
        <div class="table-responsive">
            <table class="table table-hover table-striped mail-list-table">
                <thead>
                    <tr>
                        <th>Receiver</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($mails->count() > 0)
                        @foreach($mails as $mail)
                        <tr>
                            <td>{{ $mail->receiver->name ?? 'Unknown' }}</td>
                            <td>
                                <a href="{{ route('mail.show', $mail->id) }}" class="text-primary fw-bold">{{ $mail->subject }}</a>
                            </td>
                            <td>{{ $mail->created_at->format('M d, Y h:i A') }}</td>
                            <td class="text-center">
                                <a href="{{ route('mail.show', $mail->id) }}" class="btn btn-outline-primary btn-sm" title="View Mail">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </a>
                                <form action="{{ route('mail.destroy', $mail->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm confirm-delete" title="Move to Trash">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">No sent mails found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $mails->links() }}
        </div>
    </div>
</div>
@endsection
