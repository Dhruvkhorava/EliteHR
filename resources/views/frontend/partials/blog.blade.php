<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h5 class="fw-bold text-primary text-uppercase">EliteHR Insights</h5>
            <h1 class="mb-0">Stay Updated with Latest HR Trends & EliteHR Features</h1>
        </div>
        <div class="row g-5">
            @forelse($blogs as $blog)
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.{{ $loop->iteration * 3 }}s">
                    <div class="blog-item-premium">
                        <div class="blog-img position-relative overflow-hidden">
                            @if($blog->image)
                                <img class="img-fluid w-100" src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" style="height: 250px; object-fit: cover;">
                            @else
                                <img class="img-fluid w-100" src="{{ asset('frontend/img/blog-' . (($loop->index % 3) + 1) . '.jpg') }}" alt="{{ $blog->title }}" style="height: 250px; object-fit: cover;">
                            @endif
                            <span class="blog-category-badge">{{ $blog->category ?? 'Insights' }}</span>
                            <div class="blog-date-badge-premium">
                                <div style="font-size: 1.2rem;">{{ $blog->created_at->format('d') }}</div>
                                <div style="font-size: 0.7rem; text-transform: uppercase;">{{ $blog->created_at->format('M') }}</div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="d-flex mb-3">
                                <small class="me-3"><i class="far fa-user text-primary me-2"></i>{{ $blog->author->name }}</small>
                                <small><i class="far fa-calendar-alt text-primary me-2"></i>{{ $blog->created_at->format('Y') }}</small>
                            </div>
                            <h4 class="mb-3">{{ Str::limit($blog->title, 50) }}</h4>
                            <p class="text-muted mb-4">{{ Str::limit($blog->excerpt ?? strip_tags($blog->content), 100) }}</p>
                            <a class="blog-read-more text-uppercase text-decoration-none" href="{{ route('front.detail', ['slug' => $blog->slug]) }}">Read More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No blog posts available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
