@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/frontend_partials_pricing.css') }}">
@endpush

<div class="container-fluid pricing-comparison-section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h5 class="fw-bold text-primary text-uppercase">Pricing Plans</h5>
            <h1 class="mb-0">Choose the best plan for you</h1>
            <p class="mt-3 text-muted">EliteHR offers plans for Small, Mid and Large businesses. Pick a module and
                compare plan-wise features.</p>
        </div>

        <div class="pricing-table-container">
            <table class="pricing-table">
                <thead>
                    <tr>
                        <th class="feature-header">Modules and Features</th>
                        @foreach ($pricingPlans as $plan)
                            <th class="plan-column{{ $plan['highlight'] ? ' best-value' : '' }}">
                                <div class="plan-header-card">
                                    <span class="plan-title">{{ $plan['title'] }}</span>
                                    <span class="plan-price">{{ $plan['price'] }}@if ($plan['price_suffix'])
                                            <small>{{ $plan['price_suffix'] }}</small>
                                        @endif
                                    </span>
                                    <span class="plan-subtitle">{{ $plan['subtitle'] }}</span>
                                    <a href="{{ $plan['button_link'] }}"
                                        class="btn-plan btn-plan-outline">{{ $plan['button_text'] }}</a>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pricingCategories as $category)
                        @if ($category['name'])
                            <tr>
                                <td colspan="{{ count($pricingPlans) + 1 }}" class="feature-category">
                                    {{ $category['name'] }}</td>
                            </tr>
                        @endif

                        @foreach ($category['features'] as $feature)
                            <tr>
                                <td>{{ $feature['name'] }}</td>
                                @foreach ($feature['values'] as $value)
                                    @if (($value['type'] ?? '') === 'status')
                                        @if ($value['status'] == '0' || $value['status'] === 0)
                                            <td><span class="limited-text">Limited</span></td>
                                        @elseif($value['status'] == '1' || $value['status'] === 1)
                                            <td><i class="fas fa-check check-icon"></i></td>
                                        @elseif($value['status'] == '2' || $value['status'] === 2)
                                            <td><i class="fas fa-times cross-icon"></i></td>
                                        @elseif($value['status'] == '3' || $value['status'] === 3)
                                            <td><span class="addon-text">Add-on</span></td>
                                        @elseif($value['status'] == '4' || $value['status'] === 4)
                                            <td class="unlimited-text">Unlimited</td>
                                        @else
                                            <td></td>
                                        @endif
                                    @elseif(($value['type'] ?? '') === 'text')
                                        <td
                                            class="{{ in_array($value['class'] ?? '', ['fw-bold', 'limited-text', 'unlimited-text']) && !$category['name'] ? $value['class'] : '' }}">
                                            @if (
                                                $value['class'] ??
                                                    '' && ($category['name'] || $value['class'] === 'addon-text' || $value['class'] === 'limited-text'))
                                                <span class="{{ $value['class'] }}">{{ $value['text'] }}</span>
                                            @else
                                                {{ $value['text'] }}
                                            @endif
                                        </td>
                                    @elseif(($value['type'] ?? '') === 'icon')
                                        <td><i class="{{ $value['icon'] }}"></i></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center mt-5">
            <p class="text-muted">Prices are exclusive of GST. *Additional employees charged monthly based on plan.</p>
        </div>
    </div>
</div>
