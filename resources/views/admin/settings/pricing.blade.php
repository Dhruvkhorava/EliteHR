@extends('layouts.app')

@section('content')
<div class="layout-px-spacing">
    <div class="middle-content container-xxl p-0">
        <div class="secondary-nav">
            <div class="breadcrumbs-container">
                <header class="header navbar navbar-expand-sm">
                    <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    </a>
                    <div class="d-flex breadcrumb-content">
                        <div class="page-header">
                            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Pricing Settings</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </header>
            </div>
        </div>

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="widget-content widget-content-area br-8" id="vue-pricing-app">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Pricing Editor</h4>
                            <button @click="savePricing" class="btn btn-primary" :disabled="isSaving">
                                <span v-if="isSaving">Saving...</span>
                                <span v-else>Save Pricing Settings</span>
                            </button>
                        </div>

                        <form id="pricing-form" action="{{ route('settings.pricing.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pricing_data" :value="JSON.stringify({plans: plans, categories: categories})">
                        </form>

                        <div class="pricing-tabs mb-4">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="plans-tab" data-bs-toggle="tab" data-bs-target="#plans" type="button" role="tab" aria-controls="plans" aria-selected="true">Plans</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab" aria-controls="features" aria-selected="false">Features</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="json-tab" data-bs-toggle="tab" data-bs-target="#json-view" type="button" role="tab" aria-controls="json-view" aria-selected="false">Advanced (JSON)</button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="myTabContent">
                            <!-- Plans Tab -->
                            <div class="tab-pane fade show active" id="plans" role="tabpanel" aria-labelledby="plans-tab">
                                <button class="btn btn-sm btn-success mb-3" @click="addPlan">Add Plan</button>
                                <div class="row">
                                    <div class="col-md-4 mb-4" v-for="(plan, index) in plans" :key="index">
                                        <div class="card bg-light">
                                            <div class="card-header d-flex justify-content-between">
                                                <strong>Plan @{{ index + 1 }}</strong>
                                                <button class="btn btn-sm btn-danger py-0 px-2" @click="removePlan(index)" title="Remove Plan">X</button>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    <label class="form-label text-sm">Title</label>
                                                    <input type="text" class="form-control form-control-sm" v-model="plan.title">
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 mb-2">
                                                        <label class="form-label text-sm">Price</label>
                                                        <input type="text" class="form-control form-control-sm" v-model="plan.price">
                                                    </div>
                                                    <div class="col-6 mb-2">
                                                        <label class="form-label text-sm">Action Type</label>
                                                        <input type="text" class="form-control form-control-sm" v-model="plan.price_suffix" placeholder="/month">
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label text-sm">Subtitle</label>
                                                    <input type="text" class="form-control form-control-sm" v-model="plan.subtitle">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label text-sm">Button Text</label>
                                                    <input type="text" class="form-control form-control-sm" v-model="plan.button_text">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label text-sm">Button Link</label>
                                                    <input type="text" class="form-control form-control-sm" v-model="plan.button_link">
                                                </div>
                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" type="checkbox" v-model="plan.highlight" :id="'highlight-'+index">
                                                    <label class="form-check-label" :for="'highlight-'+index">
                                                        Highlight (Best Value)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Features Tab -->
                            <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                                <button class="btn btn-sm btn-success mb-3" @click="addCategory">Add Category</button>
                                
                                <div class="accordion" id="categoriesAccordion">
                                    <div class="accordion-item mb-3" v-for="(category, catIndex) in categories" :key="catIndex">
                                        <h2 class="accordion-header" :id="'catHeading'+catIndex">
                                            <button class="accordion-button" :class="{ 'collapsed': catIndex !== 0 }" type="button" data-bs-toggle="collapse" :data-bs-target="'#catCollapse'+catIndex" aria-expanded="true" :aria-controls="'catCollapse'+catIndex">
                                                Category: @{{ category.name || '(No Name / Top Features)' }}
                                            </button>
                                        </h2>
                                        <div :id="'catCollapse'+catIndex" class="accordion-collapse collapse" :class="{ 'show': catIndex === 0 }" :aria-labelledby="'catHeading'+catIndex" data-bs-parent="#categoriesAccordion">
                                            <div class="accordion-body">
                                                <div class="d-flex mb-3">
                                                    <input type="text" class="form-control form-control-sm me-2" v-model="category.name" placeholder="Category Name (Leave blank to hide header)">
                                                    <button class="btn btn-sm btn-danger flex-shrink-0" @click="removeCategory(catIndex)">Delete Cat.</button>
                                                </div>
                                                
                                                <h6 class="mt-4 mb-2">Features <button class="btn btn-sm btn-info py-0 px-2 ms-2" @click="addFeature(catIndex)">+ Add Feature</button></h6>
                                                
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm fw-bold-labels">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 200px;">Feature Name</th>
                                                                <th v-for="(plan, pIndex) in plans" :key="pIndex">
                                                                    Plan @{{ pIndex + 1 }}: @{{ plan.title }}
                                                                </th>
                                                                <th style="width: 50px;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(feature, fIndex) in category.features" :key="fIndex">
                                                                <td>
                                                                    <input type="text" class="form-control form-control-sm" v-model="feature.name">
                                                                </td>
                                                                <template v-for="(value, vIndex) in feature.values" :key="vIndex">
                                                                <td v-if="vIndex < plans.length">
                                                                    <select class="form-select form-select-sm mb-1" v-model="value.type" @change="value.type === 'status' && typeof value.status === 'undefined' ? value.status = '1' : null">
                                                                        <option value="text">Text</option>
                                                                        <option value="icon">Icon</option>
                                                                        <option value="status">Status Badge / Icon</option>
                                                                    </select>
                                                                    
                                                                    <div v-if="value.type === 'text'">
                                                                        <input type="text" class="form-control form-control-sm mb-1" v-model="value.text" placeholder="Value">
                                                                        <input type="text" class="form-control form-control-sm text-secondary" style="font-size: 11px;" v-model="value.class" placeholder="CSS Class (e.g. fw-bold)">
                                                                    </div>
                                                                    <div v-else-if="value.type === 'icon'">
                                                                        <input type="text" class="form-control form-control-sm mb-1" v-model="value.icon" placeholder="fas fa-check">
                                                                    </div>
                                                                    <div v-else-if="value.type === 'status'">
                                                                        <select class="form-select form-select-sm" v-model="value.status">
                                                                            <option value="0">0 - Limited</option>
                                                                            <option value="1">1 - Tick Mark</option>
                                                                            <option value="2">2 - Cross Mark</option>
                                                                            <option value="3">3 - Add-on</option>
                                                                            <option value="4">4 - Unlimited</option>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                </template>
                                                                <!-- If there are more plans than values, sync them -->
                                                                <td class="text-center align-middle">
                                                                    <button class="btn btn-sm btn-danger py-0 px-2" @click="removeFeature(catIndex, fIndex)">X</button>
                                                                </td>
                                                            </tr>
                                                            <tr v-if="!category.features || category.features.length === 0">
                                                                <td :colspan="plans.length + 2" class="text-center text-muted">No features in this category</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Advanced Tab -->
                            <div class="tab-pane fade" id="json-view" role="tabpanel" aria-labelledby="json-tab">
                                <div class="alert alert-warning">
                                    <strong>Warning:</strong> Only edit this if you know what you are doing. Invalid JSON will break the pricing page.
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control text-monospace" rows="20" id="json-textarea" style="font-family: monospace;" :value="JSON.stringify({plans: plans, categories: categories}, null, 4)" @change="updateFromJson($event)"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script>
    const pricingDataRaw = {!! $pricingData !!};
    
    const app = Vue.createApp({
        data() {
            return {
                plans: pricingDataRaw.plans || [],
                categories: pricingDataRaw.categories || [],
                isSaving: false
            }
        },
        methods: {
            savePricing() {
                this.isSaving = true;
                this.syncFeaturesWithPlans();
                setTimeout(() => {
                    document.getElementById('pricing-form').submit();
                }, 100);
            },
            addPlan() {
                this.plans.push({
                    title: 'New Plan',
                    price: '₹0',
                    price_suffix: '/month',
                    subtitle: '',
                    button_text: 'Buy Now',
                    button_link: '#',
                    highlight: false
                });
                this.syncFeaturesWithPlans();
            },
            removePlan(index) {
                if(confirm('Are you sure you want to remove this plan? You should also check the features values.')) {
                    this.plans.splice(index, 1);
                    this.syncFeaturesWithPlans();
                }
            },
            addCategory() {
                this.categories.push({
                    name: 'New Category',
                    features: []
                });
            },
            removeCategory(index) {
                if(confirm('Are you sure you want to remove this entire category?')) {
                    this.categories.splice(index, 1);
                }
            },
            addFeature(catIndex) {
                const values = [];
                for(let i=0; i<this.plans.length; i++) {
                    values.push({ type: 'text', text: '', class: '' });
                }
                if (!this.categories[catIndex].features) {
                    this.categories[catIndex].features = [];
                }
                this.categories[catIndex].features.push({
                    name: 'New Feature',
                    values: values
                });
            },
            removeFeature(catIndex, featureIndex) {
                this.categories[catIndex].features.splice(featureIndex, 1);
            },
            syncFeaturesWithPlans() {
                // Ensure every feature has exactly the number of values as there are plans
                this.categories.forEach(cat => {
                    if (cat.features) {
                        cat.features.forEach(feat => {
                            if (!feat.values) feat.values = [];
                            
                            // Add missing
                            while (feat.values.length < this.plans.length) {
                                feat.values.push({ type: 'text', text: '-', class: '' });
                            }
                            
                            // Remove excess
                            if (feat.values.length > this.plans.length) {
                                feat.values.length = this.plans.length;
                            }
                        });
                    }
                });
            },
            updateFromJson(event) {
                try {
                    const parsed = JSON.parse(event.target.value);
                    if (parsed && parsed.plans && parsed.categories) {
                        this.plans = parsed.plans;
                        this.categories = parsed.categories;
                        alert('JSON Parsed Successfully!');
                    } else {
                        alert('Invalid JSON structure. Must contain plans and categories arrays.');
                    }
                } catch (e) {
                    alert('Invalid JSON string: ' + e.message);
                }
            }
        },
        mounted() {
            this.syncFeaturesWithPlans();
        }
    });
    
    app.mount('#vue-pricing-app');
</script>
<style>
    .fw-bold-labels label { font-weight: 600; }
    .text-monospace { font-family: monospace, monospace; }
</style>
@endpush
