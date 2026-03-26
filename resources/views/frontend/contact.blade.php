@extends('frontend.layouts.page')

@section('page_title', 'Contact EliteHR')

@section('page_content')
    <!-- Contact Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
                <h5 class="fw-bold text-primary text-uppercase">Contact Us</h5>
                <h1 class="mb-0">Ready to Elevate Your HR? Let's Talk</h1>
            </div>
            
            <div class="row g-4 mb-5">
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="contact-card-premium">
                        <div class="icon-box">
                            <i class="fa fa-phone-alt"></i>
                        </div>
                        <h4 class="mb-2">Call Support</h4>
                        <p class="mb-0 text-muted">Direct line to our HR tech experts</p>
                        <h5 class="text-primary mt-2">+91 8844996655</h5>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.4s">
                    <div class="contact-card-premium">
                        <div class="icon-box">
                            <i class="fa fa-envelope-open"></i>
                        </div>
                        <h4 class="mb-2">Email Us</h4>
                        <p class="mb-0 text-muted">Get a detailed quote within 24h</p>
                        <h5 class="text-primary mt-2">contact@elitehr.com</h5>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.8s">
                    <div class="contact-card-premium">
                        <div class="icon-box">
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                        <h4 class="mb-2">Visit Office</h4>
                        <p class="mb-0 text-muted">Aaksharchok, Gujarat, India</p>
                        <h5 class="text-primary mt-2">"The Park" Building</h5>
                    </div>
                </div>
            </div>

            <div class="row g-5">
                <div class="col-lg-6 wow slideInLeft" data-wow-delay="0.3s">
                    <div class="bg-light rounded p-5 shadow-sm border">
                        <h3 class="mb-4">Send us a Message</h3>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control border-white shadow-sm p-3" placeholder="Your Name" style="background: #fff;">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control border-white shadow-sm p-3" placeholder="Your Email" style="background: #fff;">
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control border-white shadow-sm p-3" placeholder="Subject" style="background: #fff;">
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control border-white shadow-sm p-3" rows="4" placeholder="How can we help you?" style="background: #fff;"></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3 shadow" type="submit">
                                        <i class="fa fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 wow slideInRight" data-wow-delay="0.6s">
                    <div class="position-relative h-100 rounded overflow-hidden shadow-lg border" style="min-height: 400px;">
                        <iframe class="position-absolute w-100 h-100"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3691.871690829539!2d73.16260851110074!3d22.282849743442604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395fc6112669e1c7%3A0x60f1c394f3c29600!2sThe%20park!5e0!3m2!1sen!2sin!4v1774521083292!5m2!1sen!2sin"
                            frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                            tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
