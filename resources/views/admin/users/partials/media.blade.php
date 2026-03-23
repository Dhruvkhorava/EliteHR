<div class="media">
    <div class="usr-img-frame me-2">
        @if($user->image)
            <img alt="avatar" src="{{ asset('storage/' . $user->image) }}" />
        @else
            <img alt="avatar" src="{{ asset('asset/images/placeholder.png') }}" />
        @endif
    </div>
    <div class="media-body align-self-center">
        <h6 class="mb-0">{{ $user->name }}</h6>
        <span>{{ $user->email }}</span>
    </div>
</div>
