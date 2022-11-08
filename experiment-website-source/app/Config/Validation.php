<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $demo1 = [
        'Gender' => [
            'rules'  => 'required|max_length[20]',
            'errors' => [
                'required' => 'Please select an option.',
            ],
        ],
        'Gender_other' => [
            'rules'  => 'max_length[20]',
            'errors' => [
                'required' => 'Please enter a value.',
                'max_length' => 'Please limit entry to 20 characters.',
            ],
        ],
        'Age' => [
            'rules'  => 'required|is_natural_no_zero',
            'errors' => [
                'required' => 'Please enter your age.',
                'is_natural_no_zero' => 'Please enter a valid age.',
            ],
        ],
        'Language' => [
            'rules'  => 'required|max_length[10]',
            'errors' => [
                'required' => 'Please select a language.',
                'max_length' => 'Please select one of the provided languages.',
            ],
        ],
        'Fluency' => [
            'rules'  => 'required|max_length[20]',
            'errors' => [
                'required' => 'Please select a level of fluency.',
                'max_length' => 'Please select one of the provided levels.',
            ],
        ],
        'Education' => [
            'rules'  => 'required|max_length[20]',
            'errors' => [
                'required' => 'Please select a level of education.',
                'max_length' => 'Please select one of the provided levels.',
            ],
        ],
        'Major' => [
            'rules'  => 'max_length[20]',
            'errors' => [
                'required' => 'Please enter a major.',
                'max_length' => 'Please limit entry to 20 characters.',
            ],
        ],
        'Ethnicity' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Please select an option.',
                'max_length' => 'Please select one of the provided options.',
            ],
        ],
        'Race' => [
            'rules'  => 'required|max_length[50]',
            'errors' => [
                'required' => 'Please select an option.',
                'max_length' => 'Please select one of the provided options.',
            ],
        ],
    ];

    public $demo2 = [
        'YearsCyS' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Please select an option.',
                'max_length' => 'Please select one of the provided options.',
            ],
        ],
        'YearsCS' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Please select an option.',
                'max_length' => 'Please select one of the provided options.',
            ],
        ],
        'YearsCE' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Please select an option.',
                'max_length' => 'Please select one of the provided options.',
            ],
        ],
        'YearsIT' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Please select an option.',
                'max_length' => 'Please select one of the provided options.',
            ],
        ],
        'YearsProg' => [
            'rules'  => 'required|max_length[30]',
            'errors' => [
                'required' => 'Please select an option.',
                'max_length' => 'Please select one of the provided options.',
            ],
        ],
        'SpecifiedPolicy' => [
            'rules'  => 'required|in_list[0,1]',
            'errors' => [
                'required' => 'Please select an option.',
                'in_list' => 'Please select one of the provided options.',
            ],
        ],
        'PoliciesWorkedWith' => [
            'rules'  => 'max_length[200]',
            'errors' => [
                'required' => 'Please select an option.',
                'max_length' => 'Please limit your response to 200 characters.',
            ],
        ],
        'SpecifiedPolicyRego' => [
            'errors' => [
                'required' => 'Please select an option.',
                'in_list' => 'Please select one of the provided options.',
            ],
        ],
    ];
}
