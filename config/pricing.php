<?php

return [
    'plans' => [
        [
            'title' => 'Free Trial',
            'price' => '₹0',
            'price_suffix' => '',
            'subtitle' => '(Includes 50 Employees)',
            'button_text' => 'Start Free Trial',
            'button_link' => '#',
            'highlight' => false,
        ],
        [
            'title' => 'Essential',
            'price' => '₹3,495',
            'price_suffix' => '/month',
            'subtitle' => '(Includes 50 Employees)',
            'button_text' => 'Start Free Trial',
            'button_link' => '#',
            'highlight' => false,
        ],
        [
            'title' => 'Growth',
            'price' => '₹5,495',
            'price_suffix' => '/month',
            'subtitle' => '(Includes 50 Employees)',
            'button_text' => 'Start Free Trial',
            'button_link' => '#',
            'highlight' => true,
        ],
        [
            'title' => 'Enterprise',
            'price' => '₹7,495',
            'price_suffix' => '/month',
            'subtitle' => '(Includes 50 Employees)',
            'button_text' => 'Start Free Trial',
            'button_link' => '#',
            'highlight' => false,
        ],
    ],
    
    'categories' => [
        [
            'name' => null, // No category header
            'features' => [
                [
                    'name' => 'Number of Employees',
                    'values' => [
                        ['type' => 'text', 'text' => 'Limited', 'class' => 'limited-text'],
                        ['type' => 'text', 'text' => 'Unlimited', 'class' => 'unlimited-text'],
                        ['type' => 'text', 'text' => 'Unlimited', 'class' => 'unlimited-text'],
                        ['type' => 'text', 'text' => 'Unlimited', 'class' => 'unlimited-text'],
                    ]
                ],
                [
                    'name' => 'Cost Per Additional Employee',
                    'values' => [
                        ['type' => 'text', 'text' => 'Not Applicable', 'class' => ''],
                        ['type' => 'text', 'text' => '₹35/ month', 'class' => 'fw-bold'],
                        ['type' => 'text', 'text' => '₹65/ month', 'class' => 'fw-bold'],
                        ['type' => 'text', 'text' => '₹105/ month', 'class' => 'fw-bold'],
                    ]
                ],
            ]
        ],
        [
            'name' => 'Core Modules',
            'features' => [
                [
                    'name' => 'Core HR',
                    'values' => [
                        ['type' => 'text', 'text' => 'Limited', 'class' => 'limited-text'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
                [
                    'name' => 'Payroll',
                    'values' => [
                        ['type' => 'text', 'text' => 'Limited', 'class' => 'limited-text'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
                [
                    'name' => 'Leave Management',
                    'values' => [
                        ['type' => 'text', 'text' => 'Limited', 'class' => 'limited-text'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
                [
                    'name' => 'Attendance Management',
                    'values' => [
                        ['type' => 'text', 'text' => 'Limited', 'class' => 'limited-text'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
            ]
        ],
        [
            'name' => 'Employee Experience',
            'features' => [
                [
                    'name' => 'Employee Portal (Web and Mobile app)',
                    'values' => [
                        ['type' => 'text', 'text' => 'Limited', 'class' => 'limited-text'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
                [
                    'name' => 'Employee Self Onboarding',
                    'values' => [
                        ['type' => 'text', 'text' => 'Limited', 'class' => 'limited-text'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
                [
                    'name' => 'Comprehensive Employee Exit Management',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
            ]
        ],
        [
            'name' => 'Automation & Intelligence',
            'features' => [
                [
                    'name' => 'Employee Workflows for Process Automation',
                    'values' => [
                        ['type' => 'text', 'text' => 'Limited', 'class' => 'limited-text'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
                [
                    'name' => 'Automated Checklists for Task Management',
                    'values' => [
                        ['type' => 'text', 'text' => 'Limited', 'class' => 'limited-text'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
                [
                    'name' => 'AI-Powered Chatbot',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
            ]
        ],
        [
            'name' => 'Reports & Management',
            'features' => [
                [
                    'name' => 'Advanced Analytics & Reporting',
                    'values' => [
                        ['type' => 'text', 'text' => 'Limited', 'class' => 'limited-text'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
                [
                    'name' => 'Access & User Management',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
                [
                    'name' => 'Extensive Excel import & Export Facility',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
            ]
        ],
        [
            'name' => 'Support & Add-ons',
            'features' => [
                [
                    'name' => 'Onboarding Support & Support plans',
                    'values' => [
                        ['type' => 'text', 'text' => 'Limited', 'class' => 'limited-text'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
                [
                    'name' => 'Group Company Support',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                    ]
                ],
                [
                    'name' => 'Enterprise Features',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                    ]
                ],
                [
                    'name' => 'GeoMark+',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                    ]
                ],
                [
                    'name' => 'Visage',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                    ]
                ],
                [
                    'name' => 'Recruit',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                    ]
                ],
                [
                    'name' => 'Expense Management',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                    ]
                ],
                [
                    'name' => 'Performance Management Software (PMS)',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                    ]
                ],
                [
                    'name' => 'Alumni Portal',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-times cross-icon'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                        ['type' => 'text', 'text' => 'Add-on', 'class' => 'addon-text'],
                    ]
                ],
                [
                    'name' => 'Security & Compliance',
                    'values' => [
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                        ['type' => 'icon', 'icon' => 'fas fa-check check-icon'],
                    ]
                ],
            ]
        ]
    ]
];
