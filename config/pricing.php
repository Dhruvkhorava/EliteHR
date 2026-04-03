<?php

return [
    'plans' => [
        [
            'title' => 'Starter',
            'price' => '₹0',
            'price_suffix' => '/month',
            'subtitle' => '(Up to 10 Employees)',
            'button_text' => 'Get Started',
            'button_link' => '#',
            'highlight' => false,
        ],
        [
            'title' => 'Professional',
            'price' => '₹4,999',
            'price_suffix' => '/month',
            'subtitle' => '(Up to 50 Employees)',
            'button_text' => 'Go Pro',
            'button_link' => '#',
            'highlight' => true,
        ],
        [
            'title' => 'Enterprise',
            'price' => '₹12,499',
            'price_suffix' => '/month',
            'subtitle' => '(Unlimited Employees)',
            'button_text' => 'Contact Sales',
            'button_link' => '#',
            'highlight' => false,
        ],
    ],
    
    'categories' => [
        [
            'name' => 'Capacity',
            'features' => [
                [
                    'name' => 'Employee Limit',
                    'values' => [
                        ['type' => 'text', 'text' => '10 Employees', 'class' => 'limited-text'],
                        ['type' => 'text', 'text' => '50 Employees', 'class' => 'fw-bold'],
                        ['type' => 'text', 'text' => 'Unlimited', 'class' => 'unlimited-text'],
                    ]
                ],
                [
                    'name' => 'Additional Employee Cost',
                    'values' => [
                        ['type' => 'text', 'text' => 'N/A', 'class' => ''],
                        ['type' => 'text', 'text' => '₹99 / employee', 'class' => 'fw-bold'],
                        ['type' => 'text', 'text' => 'Included', 'class' => 'unlimited-text'],
                    ]
                ],
            ]
        ],
        [
            'name' => 'Core HR & Attendance',
            'features' => [
                [
                    'name' => 'Employee Profiles & Directories',
                    'values' => [
                        ['type' => 'status', 'status' => 1],
                        ['type' => 'status', 'status' => 1],
                        ['type' => 'status', 'status' => 1],
                    ]
                ],
                [
                    'name' => 'Attendance (Web & Mobile)',
                    'values' => [
                        ['type' => 'status', 'status' => 1],
                        ['type' => 'status', 'status' => 1],
                        ['type' => 'status', 'status' => 1],
                    ]
                ],
                [
                    'name' => 'Shift & Rotation Management',
                    'values' => [
                        ['type' => 'status', 'status' => 2],
                        ['type' => 'status', 'status' => 1],
                        ['type' => 'status', 'status' => 1],
                    ]
                ],
                [
                    'name' => 'Geofencing & Location Tagging',
                    'values' => [
                        ['type' => 'status', 'status' => 2],
                        ['type' => 'status', 'status' => 3],
                        ['type' => 'status', 'status' => 1],
                    ]
                ],
            ]
        ],
        [
            'name' => 'Payroll & Compliance',
            'features' => [
                [
                    'name' => 'Automated Payroll Processing',
                    'values' => [
                        ['type' => 'status', 'status' => 2],
                        ['type' => 'status', 'status' => 1],
                        ['type' => 'status', 'status' => 1],
                    ]
                ],
                [
                    'name' => 'Statutory Compliance (PF/ESI/PT)',
                    'values' => [
                        ['type' => 'status', 'status' => 2],
                        ['type' => 'status', 'status' => 1],
                        ['type' => 'status', 'status' => 1],
                    ]
                ],
                [
                    'name' => 'Loan & Advance Management',
                    'values' => [
                        ['type' => 'status', 'status' => 2],
                        ['type' => 'status', 'status' => 1],
                        ['type' => 'status', 'status' => 1],
                    ]
                ],
            ]
        ],
        [
            'name' => 'Talent & Performance',
            'features' => [
                [
                    'name' => 'Recruitment Pipeline (ATS)',
                    'values' => [
                        ['type' => 'status', 'status' => 2],
                        ['type' => 'text', 'text' => 'Basic', 'class' => 'limited-text'],
                        ['type' => 'text', 'text' => 'Advanced', 'class' => 'unlimited-text'],
                    ]
                ],
                [
                    'name' => 'Performance Goals & Appraisals',
                    'values' => [
                        ['type' => 'status', 'status' => 2],
                        ['type' => 'status', 'status' => 1],
                        ['type' => 'status', 'status' => 1],
                    ]
                ],
                [
                    'name' => 'Doc Management (Cloud Storage)',
                    'values' => [
                        ['type' => 'text', 'text' => '2GB', 'class' => 'limited-text'],
                        ['type' => 'text', 'text' => '10GB', 'class' => 'fw-bold'],
                        ['type' => 'text', 'text' => '50GB', 'class' => 'unlimited-text'],
                    ]
                ],
            ]
        ],
        [
            'name' => 'Support & Security',
            'features' => [
                [
                    'name' => '2FA & Advanced Security',
                    'values' => [
                        ['type' => 'status', 'status' => 1],
                        ['type' => 'status', 'status' => 1],
                        ['type' => 'status', 'status' => 1],
                    ]
                ],
                [
                    'name' => 'Support Level',
                    'values' => [
                        ['type' => 'text', 'text' => 'Commuity', 'class' => ''],
                        ['type' => 'text', 'text' => 'Priority Email', 'class' => 'fw-bold'],
                        ['type' => 'text', 'text' => '24/7 Dedicated', 'class' => 'unlimited-text'],
                    ]
                ],
            ]
        ]
    ]
];
