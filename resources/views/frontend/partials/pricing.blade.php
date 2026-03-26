@push('styles')
<style>
    .pricing-comparison-section {
        background-color: #f8f9fa;
        padding: 80px 0;
    }

    .pricing-table-container {
        overflow-x: auto;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        background: #fff;
        margin-top: 40px;
    }

    .pricing-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .pricing-table th, .pricing-table td {
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid #eee;
    }

    .pricing-table th:first-child, .pricing-table td:first-child {
        text-align: left;
        padding-left: 30px;
        font-weight: 600;
        color: #333;
        width: 30%;
        background: #fdfdfd;
        position: sticky;
        left: 0;
        z-index: 5;
    }

    .pricing-table thead th {
        background: #fff;
        font-size: 1.1rem;
        color: #06A3DA;
        border-top: 4px solid #06A3DA;
    }

    .pricing-table thead th.plan-column {
        width: 17.5%;
    }

    .pricing-table tr:hover td {
        background-color: #f1f9ff;
    }

    .plan-header-card {
        padding: 20px 0;
    }

    .plan-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 10px;
        display: block;
    }

    .plan-price {
        font-size: 2rem;
        font-weight: 800;
        color: #333;
        margin-bottom: 5px;
        display: block;
    }

    .plan-price small {
        font-size: 0.9rem;
        font-weight: 500;
        color: #777;
    }

    .plan-subtitle {
        font-size: 0.85rem;
        color: #888;
        display: block;
        margin-bottom: 15px;
    }

    .btn-plan {
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-plan-outline {
        border: 2px solid #06A3DA;
        color: #06A3DA;
    }

    .btn-plan-outline:hover {
        background: #06A3DA;
        color: #fff;
    }

    .feature-category {
        background: #f1f5f9 !important;
        font-weight: 800 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        color: #444 !important;
    }

    .check-icon {
        color: #28a745;
        font-size: 1.2rem;
    }

    .cross-icon {
        color: #dc3545;
        font-size: 1.2rem;
    }

    .limited-text {
        font-weight: 600;
        color: #e67e22;
    }

    .addon-text {
        font-weight: 600;
        color: #9b59b6;
        font-size: 0.85rem;
    }

    .unlimited-text {
        font-weight: 600;
        color: #27ae60;
    }

    /* Sticker for best value */
    .best-value {
        position: relative;
    }
    
    .best-value::after {
        content: "POPULAR";
        position: absolute;
        top: 8px;
        left: 50%;
        transform: translateX(-50%);
        background: #FFD700;
        color: #000;
        padding: 2px 12px;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 800;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .pricing-table th, .pricing-table td {
            padding: 12px;
        }
        .pricing-table th:first-child, .pricing-table td:first-child {
            padding-left: 15px;
            width: 40%;
        }
    }
</style>
@endpush

<div class="container-fluid pricing-comparison-section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h5 class="fw-bold text-primary text-uppercase">Pricing Plans</h5>
            <h1 class="mb-0">Choose the best plan for you</h1>
            <p class="mt-3 text-muted">EliteHR offers plans for Small, Mid and Large businesses. Pick a module and compare plan-wise features.</p>
        </div>

        <div class="pricing-table-container">
            <table class="pricing-table">
                <thead>
                    <tr>
                        <th class="feature-header">Modules and Features</th>
                        <th class="plan-column">
                            <div class="plan-header-card">
                                <span class="plan-title">Free Trial</span>
                                <span class="plan-price">₹0</span>
                                <span class="plan-subtitle">(Includes 50 Employees)</span>
                                <a href="#" class="btn-plan btn-plan-outline">Start Free Trial</a>
                            </div>
                        </th>
                        <th class="plan-column">
                            <div class="plan-header-card">
                                <span class="plan-title">Essential</span>
                                <span class="plan-price">₹3,495<small>/month</small></span>
                                <span class="plan-subtitle">(Includes 50 Employees)</span>
                                <a href="#" class="btn-plan btn-plan-outline">Start Free Trial</a>
                            </div>
                        </th>
                        <th class="plan-column best-value">
                            <div class="plan-header-card">
                                <span class="plan-title">Growth</span>
                                <span class="plan-price">₹5,495<small>/month</small></span>
                                <span class="plan-subtitle">(Includes 50 Employees)</span>
                                <a href="#" class="btn-plan btn-plan-outline">Start Free Trial</a>
                            </div>
                        </th>
                        <th class="plan-column">
                            <div class="plan-header-card">
                                <span class="plan-title">Enterprise</span>
                                <span class="plan-price">₹7,495<small>/month</small></span>
                                <span class="plan-subtitle">(Includes 50 Employees)</span>
                                <a href="#" class="btn-plan btn-plan-outline">Start Free Trial</a>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Number of Employees</td>
                        <td class="limited-text">Limited</td>
                        <td class="unlimited-text">Unlimited</td>
                        <td class="unlimited-text">Unlimited</td>
                        <td class="unlimited-text">Unlimited</td>
                    </tr>
                    <tr>
                        <td>Cost Per Additional Employee</td>
                        <td>Not Applicable</td>
                        <td class="fw-bold">₹35/ month</td>
                        <td class="fw-bold">₹65/ month</td>
                        <td class="fw-bold">₹105/ month</td>
                    </tr>
                    
                    <tr><td colspan="5" class="feature-category">Core Modules</td></tr>
                    <tr>
                        <td>Core HR</td>
                        <td><span class="limited-text">Limited</span></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    <tr>
                        <td>Payroll</td>
                        <td><span class="limited-text">Limited</span></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    <tr>
                        <td>Leave Management</td>
                        <td><span class="limited-text">Limited</span></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    <tr>
                        <td>Attendance Management</td>
                        <td><span class="limited-text">Limited</span></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    
                    <tr><td colspan="5" class="feature-category">Employee Experience</td></tr>
                    <tr>
                        <td>Employee Portal (Web and Mobile app)</td>
                        <td><span class="limited-text">Limited</span></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    <tr>
                        <td>Employee Self Onboarding</td>
                        <td><span class="limited-text">Limited</span></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    <tr>
                        <td>Comprehensive Employee Exit Management</td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    
                    <tr><td colspan="5" class="feature-category">Automation & Intelligence</td></tr>
                    <tr>
                        <td>Employee Workflows for Process Automation</td>
                        <td><span class="limited-text">Limited</span></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    <tr>
                        <td>Automated Checklists for Task Management</td>
                        <td><span class="limited-text">Limited</span></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    <tr>
                        <td>AI-Powered Chatbot</td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    
                    <tr><td colspan="5" class="feature-category">Reports & Management</td></tr>
                    <tr>
                        <td>Advanced Analytics & Reporting</td>
                        <td><span class="limited-text">Limited</span></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    <tr>
                        <td>Access & User Management</td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    <tr>
                        <td>Extensive Excel import & Export Facility</td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    
                    <tr><td colspan="5" class="feature-category">Support & Add-ons</td></tr>
                    <tr>
                        <td>Onboarding Support & Support plans</td>
                        <td><span class="limited-text">Limited</span></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                    <tr>
                        <td>Group Company Support</td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><span class="addon-text">Add-on</span></td>
                        <td><span class="addon-text">Add-on</span></td>
                    </tr>
                    <tr>
                        <td>Enterprise Features</td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><span class="addon-text">Add-on</span></td>
                        <td><span class="addon-text">Add-on</span></td>
                    </tr>
                    <tr>
                        <td>GeoMark+</td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><span class="addon-text">Add-on</span></td>
                        <td><span class="addon-text">Add-on</span></td>
                    </tr>
                    <tr>
                        <td>Visage</td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><span class="addon-text">Add-on</span></td>
                        <td><span class="addon-text">Add-on</span></td>
                    </tr>
                    <tr>
                        <td>Recruit</td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><span class="addon-text">Add-on</span></td>
                        <td><span class="addon-text">Add-on</span></td>
                        <td><span class="addon-text">Add-on</span></td>
                    </tr>
                    <tr>
                        <td>Expense Management</td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><span class="addon-text">Add-on</span></td>
                        <td><span class="addon-text">Add-on</span></td>
                    </tr>
                    <tr>
                        <td>Performance Management Software (PMS)</td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><span class="addon-text">Add-on</span></td>
                        <td><span class="addon-text">Add-on</span></td>
                        <td><span class="addon-text">Add-on</span></td>
                    </tr>
                    <tr>
                        <td>Alumni Portal</td>
                        <td><i class="fas fa-times cross-icon"></i></td>
                        <td><span class="addon-text">Add-on</span></td>
                        <td><span class="addon-text">Add-on</span></td>
                        <td><span class="addon-text">Add-on</span></td>
                    </tr>
                    <tr>
                        <td>Security & Compliance</td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                        <td><i class="fas fa-check check-icon"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="text-center mt-5">
            <p class="text-muted">Prices are exclusive of GST. *Additional employees charged monthly based on plan.</p>
        </div>
    </div>
</div>
