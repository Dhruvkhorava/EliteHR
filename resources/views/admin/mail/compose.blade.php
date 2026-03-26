@extends('admin.mail.layout')

@section('mail-content')
<div class="row">
    <div class="col-md-12">
        <h4>Compose Mail</h4>
        <form action="{{ route('mail.send') }}" method="POST">
            @csrf
            @if($draft)
                <input type="hidden" name="mail_id" value="{{ $draft->id }}">
            @endif

            <div class="mb-3">
                <label for="receiver_id" class="form-label">To:</label>
                <select name="receiver_id" id="receiver_id" class="form-select">
                    <option value="">Select Recipient</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ ($draft && $draft->receiver_id == $user->id) ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="subject" class="form-label">Subject:</label>
                <input type="text" name="subject" id="subject" class="form-control" value="{{ $draft->subject ?? '' }}" placeholder="Enter subject">
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Message:</label>
                <textarea name="message" id="message" rows="10" class="form-control" placeholder="Write your message here...">{{ $draft->message ?? '' }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <div>
                    <button type="submit" name="action" value="send" class="btn btn-primary">Send Mail</button>
                    <button type="submit" name="action" value="draft" class="btn btn-secondary">Save as Draft</button>
                </div>
                <a href="{{ route('mail.index') }}" class="btn btn-outline-danger">Discard</a>
            </div>
        </form>
    </div>
</div>
@endsection
