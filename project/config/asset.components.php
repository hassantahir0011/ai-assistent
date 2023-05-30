<?php

return [
    'rich_textarea' => [
        'css' => [
            'assets/global/plugins/customized_rich_textarea/css/rich-textarea-style.css?v=2',
        ],
        'js' => [
            'before-appjs' => [
                'assets/global/plugins/customized_rich_textarea/js/jquery.ui.autocomplete.js',
                'assets/global/plugins/customized_rich_textarea/js/rich_textarea.js?v=7',

            ]
        ]
    ],
     'lightGallery' => [
    'css' => [
        'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.14/css/lightgallery.min.css',

    ],
    'js' => [
        'before-appjs' => [''],
        'after-appjs' => [
            'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.14/js/lightgallery-all.min.js'
        ]
    ]
],
    'event-doc' => [
        'css' => [
            'css/event_documentation_tab.css',
            'https://cdn.jsdelivr.net/npm/github-markdown-css@3.0.1/github-markdown.min.css',

        ],
        'js' => [

        ]
    ],
    'lightcase' => [
        'css' => [
//            'assets/global/plugins/lightcase/css/lightcase.css',
            'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.min.css',

        ],
        'js' => [
            'before-appjs' => [''],
            'after-appjs' => [
//                'assets/global/plugins/lightcase/js/lightcase.js'
                'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/js/lightgallery-all.min.js'
            ]
        ]
    ],

    'mobile-number-format' => [
        'css' => [
            'assets/global/plugins/mobile-number-plugin/build/css/intlTelInput.css',
            'assets/global/plugins/mobile-number-plugin/build/css/demo.css'


        ],
        'js' => [
            'before-appjs' => [],
            'after-appjs' => [
                'assets/global/plugins/mobile-number-plugin/build/js/intlTelInput.js',
            ]
        ]
    ],
    'multiselectplugin' => [
        'css' => [
            'assets/global/plugins/jQuery-Plugin-mutiselect/fSelect.css'


        ],
        'js' => [
            'before-appjs' => [],
            'after-appjs' => [
                'assets/global/plugins/jQuery-Plugin-mutiselect/fSelect.js',
            ]
        ]
    ],
    'bootstrap-multiselect' => [
        'css' => [
            'assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css',
        ],
        'js' => [
            'before-appjs' => [


            ],
            'after-appjs' => [
                'assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js',
            ]
        ]
    ],
    'ckeditor' => [
        'css' => [],
        'js' => [
            'before-appjs' => [
                'assets/global/plugins/ckeditor/ckeditor.js'
            ]

        ]

    ],
    'datepicker' => [
        'css' => [
            'assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',

        ],
        'js' => [
            'before-appjs' => [
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.js',
                'assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',

            ]
        ]
    ],
    'timepicker' => [
        'js' => [
            'before-appjs' => [
                'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js'

            ]
        ]
    ],
    'select' => [
        'css' => ['assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css',
            'assets/global/plugins/jquery-multi-select/css/multi-select.css'

        ],
        'js' => [
            'before-appjs' => [
                'assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js'
            ],
            'after-appjs' => [
                'assets/pages/scripts/components-bootstrap-select.min.js'
            ]
        ]

    ],

    'multi-select' => [
        'css' => ['assets/global/plugins/jquery-multi-select/css/multi-select.css'
        ],
        'js' => [
            'before-appjs' => [
                'assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js',
                'assets/pages/scripts/components-multi-select.min.js'
            ]
        ]
    ],


    'fileinput' => [
        'css' => ['assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'],
        'js' => []

    ],
    'mask' => [
        'css' => [],
        'js' => [
            'before-appjs' => [
                'assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js',
                'js/jquery.mask.min.js',
                'assets/global/plugins/jquery.input-ip-address-control-1.0.min.js'
            ],
            'after-appjs' => [
                'assets/pages/scripts/form-input-mask.min.js',
            ]
        ]
    ],
    'datatable' => [
        'css' => [
            'assets/global/plugins/datatables/datatables.min.css',
            'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css',
        ],
        'js' => [
            'before-appjs' => [
//                'assets/global/scripts/datatable.js',
                'assets/global/plugins/datatables/datatables.min.js',
                'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js',
//                'https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap.min.css'
            ],
            'after-appjs' => [
//                'assets/pages/scripts/table-datatables-managed.min.js',
            ]
        ]
    ],
    'querybuilder' => [
        'css' => [
            //'assets/global/plugins/jQuery-QueryBuilder-master/dist/css/query-builder.default.css'
            'https://cdn.jsdelivr.net/npm/jQuery-QueryBuilder@2.5.2/dist/css/query-builder.default.css',
        ],
        'js' => [
            'before-appjs' => [
                //'assets/global/plugins/jQuery-QueryBuilder-master/dist/js/query-builder.standalone.js',
                'https://cdn.jsdelivr.net/npm/jQuery-QueryBuilder@2.5.2/dist/js/query-builder.standalone.min.js',
            ]
        ]

    ],
    'imagelibrary' => [
        'css' => [
            'assets/pages/css/viewer.css',
            'assets/pages/css/main.css'
        ],
        'js' => [
            'before-appjs' => [
                'assets/js/viewer.js',
                'assets/js/main.js'
            ]
        ],

    ],

    'icheck' => [
        'css' => [
            'assets/global/plugins/icheck/skins/all.css'
        ],
        'js' => [
            'before-appjs' => [
                'assets/global/plugins/icheck/icheck.min.js'
            ]
        ]

    ],
    'ladda' => [
        'css' => [],
        'js' => [
            'after-appjs' => [
                'assets/global/plugins/ladda/spin.min.js',
                'assets/global/plugins/ladda/ladda.min.js',
            ]
        ]
    ],

    'sweetalert' => [
        'css' => [],
        'js' => [
            'before-appjs' => [
                'https://cdn.jsdelivr.net/npm/sweetalert@2.1.2/dist/sweetalert.min.js'
            ]
            ,
            'after-appjs' => [

            ]
        ]

    ],
    'select2' => [
        'css' => [
            //'assets/global/plugins/select2/css/select2.min.css',
            //'assets/global/plugins/select2/css/select2-bootstrap.min.css'
            'https://cdn.jsdelivr.net/npm/select2@4.0.3/dist/css/select2.min.css',
            'https://cdn.jsdelivr.net/npm/select2-bootstrap-theme@0.1.0-beta.4/dist/select2-bootstrap.min.css'
        ],
        'js' =>
            [
                'before-appjs' => [
                    //'assets/global/plugins/select2/js/select2.full.min.js'
                    'https://cdn.jsdelivr.net/npm/select2@4.0.3/dist/js/select2.full.min.js'
                ],
                'after-appjs' => [
                    //'assets/pages/scripts/components-select2.min.js'
                ]

            ]
    ],

    'validation' => [
        'css' => [],
        'js' => [
            'before-appjs' => [
                'assets/global/plugins/jquery-validation/js/jquery.validate.js?v=1',
//                'assets/global/plugins/jquery-validation/js/additional-methods.min.js',
                'assets/global/scripts/oric.js?v=14',

            ]
        ]
    ],
    'tagsinput' => [
        'css' => [
            'assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',
        ],
        'js' => [
            'before-appjs' => [
                'assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js'
            ],
            'after-appjs' => [
                'assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js'
            ]
        ]

    ],
    'bootstrap-modal' => [
        'css' => [
            'assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css',
            'assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css'
        ],
        'js' => [
            'before-appjs' => [
                'assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js',
                'assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js'
            ],
            'after-appjs' => [
//                'assets/pages/scripts/ui-extended-modals.min.js',
            ]
        ]

    ]
,   'calendar' => [
        'css' => [
            'assets/global/plugins/fullcalendar/fullcalendar.min.css'
        ],
        'js' => [
            'after-appjs' => [
                'js/calender/fullcalendar.min.js'
            ]
        ]
    ],
    'jquery-tabs' => [
        'css' => [
            'assets/jquery-steps-master/dist/jquery-steps.css'
        ],
        'js' => [
            'before-appjs' => [


            ],
            'after-appjs' => [
                'assets/jquery-steps-master/dist/jquery-steps.js'
            ]
        ]
    ],
    'ace' => [
        'css' => [],
        'js' => [
            'before-appjs' => [],
            'after-appjs' => [
                'assets/global/plugins/ace-code-editor/src-noconflict/ace.js'
//                'https://unpkg.com/ace-builds@1.2.8/src-min-noconflict/ace.js'
            ]
        ]
    ],
    'hopscotch' => [
        'css' => [
            'assets/demo_scripts/css/hopscotch-0.1.1.css',
//            'https://cdn.jsdelivr.net/npm/hopscotch@0.3.1/dist/css/hopscotch.min.css',
        ],
        'js' => [
            'after-appjs' => [
                'demo_scripts/js/hopscotch-0.1.1.min.js'
//                'https://cdn.jsdelivr.net/npm/hopscotch@0.3.1/dist/js/hopscotch.min.js'
            ]
        ]
    ],
    'jscolor' => [
        'css' => [],
        'js' => [
            'after-appjs' => [
                'assets/global/plugins/colorjs/jscolor.js'
            ]
        ]
    ],
    'installed-snippets-screen' => [
        'css' => [
            'css/installed_snippet.css',

        ],
        'js' => [
            'before-appjs' => [],
            'after-appjs' => [
            ]
        ]
    ],
    'toastr' => [
        'css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css',

        ],
        'js' => [
            'before-appjs' => [''],
            'after-appjs' => [
                'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js'
            ]
        ]
    ],

];
