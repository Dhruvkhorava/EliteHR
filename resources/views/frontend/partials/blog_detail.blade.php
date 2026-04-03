<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Blog Detail Start -->
                <div class="mb-5">
                    @if($blog->image)
                        <img class="img-fluid w-100 rounded mb-5" src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" style="max-height: 500px; object-fit: cover;">
                    @endif
                    <div class="d-flex mb-3">
                        <span class="badge bg-primary text-uppercase me-3 px-3 py-2">{{ $blog->category ?? 'Insights' }}</span>
                        <div class="d-flex align-items-center text-muted">
                            <i class="far fa-user text-primary me-2"></i>{{ $blog->author->name }}
                        </div>
                        <div class="d-flex align-items-center text-muted ms-3">
                            <i class="far fa-calendar-alt text-primary me-2"></i>{{ $blog->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    <h1 class="mb-4">{{ $blog->title }}</h1>
                    <div class="blog-content text-muted lead" style="line-height: 1.8;">
                        {!! nl2br(e($blog->content)) !!}
                    </div>
                </div>
                <!-- Blog Detail End -->

                <!-- Comment List Start (Placeholder) -->
                <div class="mb-5">
                    <div class="section-title section-title-sm position-relative pb-3 mb-4">
                        <h3 class="mb-0">3 Comments</h3>
                    </div>
                    <div class="d-flex mb-4">
                        <img src="{{ asset('frontend/img/user.jpg') }}" class="img-fluid rounded" style="width: 45px; height: 45px;">
                        <div class="ps-3">
                            <h6>John Doe <small><i>01 Jan 2045</i></small></h6>
                            <p>Diam amet duo labore stet elitr invidunt ea clita ipsum voluptua, tempor labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed eirmod</p>
                            <button class="btn btn-sm btn-light">Reply</button>
                        </div>
                    </div>
                </div>
                <!-- Comment List End -->
            </div>

            <!-- Sidebar Start -->
            <div class="col-lg-4">
                <!-- Search Form Start -->
                <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                    <div class="input-group">
                        <input type="text" class="form-control p-3" placeholder="Keyword">
                        <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <!-- Search Form End -->

                <!-- Recent Post Start -->
                <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                    <div class="section-title section-title-sm position-relative pb-3 mb-4">
                        <h3 class="mb-0">Recent Post</h3>
                    </div>
                    @php
                        $recentBlogs = \App\Models\Blog::where('is_published', true)->where('id', '!=', $blog->id)->latest()->take(3)->get();
                    @endphp
                    @foreach($recentBlogs as $recent)
                        <div class="d-flex rounded overflow-hidden mb-3">
                            @if($recent->image)
                                <img class="img-fluid" src="{{ asset('storage/' . $recent->image) }}" style="width: 100px; height: 100px; object-fit: cover;" alt="">
                            @else
                                <img class="img-fluid" src="{{ asset('frontend/img/blog-1.jpg') }}" style="width: 100px; height: 100px; object-fit: cover;" alt="">
                            @endif
                            <a href="{{ route('front.detail', ['slug' => $recent->slug]) }}" class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0" style="font-size: 1rem;">{{ Str::limit($recent->title, 40) }}</a>
                        </div>
                    @endforeach
                </div>
                <!-- Recent Post End -->
            </div>
            <!-- Sidebar End -->
        </div>
    </div>
</div>
