<?php

return [
    "Cart" => [
        [
            "id" => "line_items",
            "label" => "Line Items count",
            "input" => "number",
            "type" => "integer",
            "plugin" => "",
            "values" => [],
            "operators" => ["equal", "not_equal", "less", "greater", "greater_or_equal", "less_or_equal"]

        ],

        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "Checkout" => [
        [
            "id" => "line_items",
            "label" => "Line Items count",
            "input" => "number",
            "type" => "integer",
            "plugin" => "",
            "values" => [],
            "operators" => ["equal", "not_equal", "less", "greater", "greater_or_equal", "less_or_equal"]

        ],
        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "Collection" => [
        [
            "id" => "handle",
            "label" => "Collection Handle (enter exact value)",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "Customer" => [
        [
            "id" => "email",
            "label" => "Customer email",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "phone",
            "label" => "Customer phone",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ],
        [
            "id" => "first_name",
            "label" => "First name",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ],
        [
            "id" => "last_name",
            "label" => "Last name",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ],
        [
            "id" => "orders_count",
            "label" => "Orders Count",
            "input" => "number",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "less", "greater", "greater_or_equal", "less_or_equal"]

        ],
        [
            "id" => "total_spent",
            "label" => "Total Spent",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "less", "greater", "greater_or_equal", "less_or_equal"]

        ],

        [
            "id" => "tags",
            "label" => "Tags",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ],
        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "CustomerSavedSearch" => [
        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "DraftOrder" => [
        [
            "id" => "status",
            "label" => "Status",
            "input" => "select",
            "type" => "string",
            "plugin" => "select2",
            "values" => [
                "open" => "Open",
                "invoice_sent" => "Invoice Sent",
                "completed" => "Completed"

            ],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "email",
            "label" => "Email",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal"]

        ],

        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]

    ],
    "Fulfillment" => [
        [
            "id" => "status",
            "label" => "Status",
            "input" => "select",
            "type" => "string",
            "plugin" => "select2",
            "values" => [
                "pending" => "Pending",
                "open" => "Open",
                "success" => "Success",
                "cancelled" => "Cancelled",
                "error" => "Error",
                "failure" => "Failure"
            ],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "shipment_status",
            "label" => "Shipment Status",
            "input" => "select",
            "type" => "string",
            "plugin" => "select2",
            "values" => [
                "label_printed" => "Label Printed",
                "label_purchased" => "Label Purchased",
                "attempted_delivery" => "Attempted Delivery",
                "ready_for_pickup" => "Ready For Pickup",
                "confirmed" => "Confirmed",
                "in_transit" => "In Transit",
                "out_for_delivery" => "Out For Delivery",
                "delivered" => "Delivered",
                "failure" => "Failure",
            ],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "email",
            "label" => "email",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "line_items",
            "label" => "Line Items count",
            "input" => "number",
            "type" => "integer",
            "plugin" => "",
            "values" => [],
            "operators" => ["equal", "not_equal", "less", "greater", "greater_or_equal", "less_or_equal"]

        ],
        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "FulfillmentEvent" => [
        [
            "id" => "status",
            "label" => "Status",
            "input" => "select",
            "type" => "string",
            "plugin" => "select2",
            "values" => [
                "pending" => "Pending",
                "open" => "Open",
                "success" => "Success",
                "cancelled" => "Cancelled",
                "error" => "Error",
                "failure" => "Failure"
            ],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "InventoryItem" => [
        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "InventoryLevel" => [
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "Location" => [
        [
            "id" => "name",
            "label" => "Name",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ],
        [
            "id" => "city",
            "label" => "City",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ],
        [
            "id" => "phone",
            "label" => "Phone",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ],
        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "Order" => [
        [
            "id" => "financial_status",
            "label" => "Financial Status",
            "input" => "select",
            "type" => "string",
            "plugin" => "select2",
            "values" => [
                "pending" => "Pending",
                "paid" => "Paid",
                "refunded" => "Refunded",
                "any" => "Any",
                "authorized" => "Authorized",
                "partially_paid" => "Partially Paid",
                "voided" => "Voided",
                "partially_refunded" => "Partially Refunded",
                "unpaid" => "Unpaid"
            ],
            "operators" => ["equal", "not_equal"]

        ],
//            [
//                "id"=>"status",
//                "label"=>"Status",
//                "input"=>"select",
//                "type"=>"string",
//                "plugin"=>"select2",
//                "values"=>["open"=>"Open","closed"=>"Closed","any"=>"Any","cancelled"=>"Cancelled"],
//                "operators"=> ["equal", "not_equal"]
//
//            ],
        [
            "id" => "fulfillment_status",
            "label" => "Fulfillment Status",
            "input" => "select",
            "type" => "string",
            "plugin" => "select2",
            "values" => [
                "fulfilled" => "Shipped",
                "partial" => "Partial",
                "unshipped" => "Unshipped",
            ],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "total_price",
            "label" => "Total Price",
            "input" => "text",
            "type" => "string",
            "plugin" => "",
            "values" => [],
            "operators" => ["equal", "not_equal", "less", "greater", "greater_or_equal", "less_or_equal"]

        ],
        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]

    ],
    "OrderTransaction" => [
        [
            "id" => "status",
            "label" => "Status",
            "input" => "select",
            "type" => "string",
            "plugin" => "select2",
            "values" => [
                "pending" => "Pending",
                "failure" => "Failure",
                "success" => "Success",
                "error" => "Error"

            ],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]

    ],
    "Product" => [
        [
            "id" => "vendor",
            "label" => "Vendor",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ],
        [
            "id" => "tags",
            "label" => "Tags",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ]
        ,
        [
            "id" => "handle",
            "label" => "Product Handle (enter exact value)",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ],
        [
            "id" => "product_type",
            "label" => "Product Type (enter exact value)",
            "input" => "text",
            "type" => "string",
            "values" => [],
            "plugin" => "",
            "operators" => ["equal", "not_equal", "contains"]

        ]
    ],
    "Refund" => [
        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "Shop" => [
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ],
    "TenderTransaction" => [
        [
            "id" => "amount",
            "label" => "Amount",
            "input" => "text",
            "type" => "string",
            "plugin" => "",
            "values" => [],
            "operators" => ["equal", "not_equal", "less", "greater", "greater_or_equal", "less_or_equal"]

        ]
    ],
    "Theme" => [
        [
            "id" => "created_at",
            "label" => "Created at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ],
        [
            "id" => "updated_at",
            "label" => "Updated at",
            "input" => "text",
            "type" => "string",
            "plugin" => "datepicker",
            "values" => [],
            "operators" => ["equal", "not_equal"]

        ]
    ] ,
    "OrderEdit" => [
    [
        "id" => "created_at",
        "label" => "Created at",
        "input" => "text",
        "type" => "string",
        "plugin" => "datepicker",
        "values" => [],
        "operators" => ["equal", "not_equal"]

    ]
]
];

