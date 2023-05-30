function add_order_transactions_in_sheet(post_data) {

    try{
        var sheet =getSheetByName('order_transactions');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'order_transactions' found in spreadsheet.");
        // remove uncessary object keys
        delete post_data.admin_graphql_api_id;
        delete post_data.request_type;
        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        var column_no=1;
        sheet.insertRowAfter(lastRow);
        for(var key in post_data){

            let value=post_data[key];

            if(key=='payment_details' && Object.keys(value).length){

                for(var obj in value){

                    sheet.getRange(new_row, column_no).setValue(value[obj] || '');
                    column_no++;
                }
            }
            else if(key=='receipt' && Object.keys(value).length){
                var concatenate_receipts='';
                for(var obj in value){
                    concatenate_receipts+=(value[obj] || '') + ',';

                }
                sheet.getRange(new_row, column_no).setValue(concatenate_receipts);
                column_no++;
            }else{
                sheet.getRange(new_row, column_no).setValue(value || '');
                column_no++;
            }




        }
        return ContentService.createTextOutput("ORder Transaction added successfully.");

    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }


}
function update_inventory_levels_in_sheet(post_data) {

    try{
        const indexed_sheet_fields = {"1" : "inventory_item_id", "2" : "location_id", "3" : "available", "4" : "updated_at"};
        var sheet =getSheetByName('inventory_level');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'inventory_level' found in spreadsheet.Please create new sheet with this name and keep header fields descrived into docs.");
        var data = sheet.getDataRange().getValues();
        var  found_row_in_sheet=false;
        for (var i = 1; i <= data.length; i++) {
            current_sheet_row = data[i];
            if (typeof current_sheet_row !=='undefined' && current_sheet_row[0] == post_data.inventory_item_id) {
                found_row_in_sheet=true;
                //exclude header row
                var new_row = i +1;
                // if update webhook triggered
                for(var key in indexed_sheet_fields){
                    let value=indexed_sheet_fields[key];
                    sheet.getRange(new_row, key).setValue(post_data[value]);

                }
                return ContentService.createTextOutput("Item updated successfully.");

            }
        }
        if(!found_row_in_sheet)return add_inventory_levels_in_sheet(post_data);

    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }

}

function add_inventory_levels_in_sheet(post_data) {

    try{
        const indexed_sheet_fields = {"1" : "inventory_item_id", "2" : "location_id", "3" : "available", "4" : "updated_at"};
        var sheet =getSheetByName('inventory_level');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'inventory_level' found in spreadsheet.");

        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        sheet.insertRowAfter(lastRow);
        for(var key in indexed_sheet_fields){
            let value=indexed_sheet_fields[key];
            sheet.getRange(new_row, key).setValue(post_data[value]);

        }
        return ContentService.createTextOutput("Item added successfully.");

    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }


}
function update_delete_inventory_item_in_sheet(post_data) {

    try{
        const indexed_sheet_fields = {"1" : "id", "2" : "sku", "3" : "created_at", "4" : "updated_at", "5" : "requires_shipping", "6" : "cost", "7" : "country_code_of_origin","8":"province_code_of_origin","9":"harmonized_system_code","10":"tracked","11":"country_harmonized_system_codes"};
        var sheet =getSheetByName('inventory_items');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'inventory_items' found in spreadsheet.Please create new sheet with this name and keep header fields descrived into docs.");
        var data = sheet.getDataRange().getValues();
        var  found_row_in_sheet=false;
        for (var i = 1; i <= data.length; i++) {
            current_sheet_row = data[i];
            if (typeof current_sheet_row !=='undefined' && current_sheet_row[0] == post_data.id) {
                found_row_in_sheet=true;
                //exclude header row
                var new_row = i +1;

                // if delete webhook called
                if(post_data.request_type=="inventory_items/delete"){
                    sheet.deleteRow(new_row);
                    return ContentService.createTextOutput("Item  deleted from google sheet.");
                }

                // if update webhook triggered
                for(var key in indexed_sheet_fields){
                    let value=indexed_sheet_fields[key];
                    sheet.getRange(new_row, key).setValue(post_data[value]);

                }


                return ContentService.createTextOutput("Item updated successfully.");

            }
        }


        if(!found_row_in_sheet)return ContentService.createTextOutput("No record found in sheet.");



    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }

}

function add_inventory_item_in_sheet(post_data) {

    try{
        const indexed_sheet_fields = {"1" : "id", "2" : "sku", "3" : "created_at", "4" : "updated_at", "5" : "requires_shipping", "6" : "cost", "7" : "country_code_of_origin","8":"province_code_of_origin","9":"harmonized_system_code","10":"tracked","11":"country_harmonized_system_codes"};
        var sheet =getSheetByName('inventory_items');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'inventory_items' found in spreadsheet.");

        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        sheet.insertRowAfter(lastRow);
        for(var key in indexed_sheet_fields){
            let value=indexed_sheet_fields[key];
            sheet.getRange(new_row, key).setValue(post_data[value]);

        }
        return ContentService.createTextOutput("Item added successfully.");

    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }


}
function update_delete_location_in_sheet(post_data) {

    try{
        const indexed_sheet_fields = {"1" : "id", "2" : "name", "3" : "address1", "4" : "address2", "5" : "city", "6" : "zip", "7" : "province","8":"country","9":"phone","10":"created_at","11":"updated_at","12":"country_code","13":"country_name","14":"province_code","15":"legacy","16":"active"};
        var sheet =getSheetByName('locations');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'locations' found in spreadsheet.");
        var data = sheet.getDataRange().getValues();
        var  found_row_in_sheet=false;
        for (var i = 1; i <= data.length; i++) {
            current_sheet_row = data[i];
            if (typeof current_sheet_row !=='undefined' && current_sheet_row[0] == post_data.id) {
                found_row_in_sheet=true;
                //exclude header row
                var new_row = i +1;

                // if delete webhook called
                if(post_data.request_type=="locations/delete"){
                    sheet.deleteRow(new_row);
                    return ContentService.createTextOutput("Locations  deleted from google sheet.");
                }

                // if update webhook triggered
                for(var key in indexed_sheet_fields){
                    let value=indexed_sheet_fields[key];
                    sheet.getRange(new_row, key).setValue(post_data[value]);
                }
                return ContentService.createTextOutput("Locations updated successfully.");

            }
        }
        if(!found_row_in_sheet)
            add_location_in_sheet(post_data)
    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }
}


function add_location_in_sheet(post_data) {

    try{
        const indexed_sheet_fields = {"1" : "id", "2" : "name", "3" : "address1", "4" : "address2", "5" : "city", "6" : "zip", "7" : "province","8":"country","9":"phone","10":"created_at","11":"updated_at","12":"country_code","13":"country_name","14":"province_code","15":"legacy","16":"active"};
        var sheet =getSheetByName('locations');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'locations' found in spreadsheet.");

        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        sheet.insertRowAfter(lastRow);
        for(var key in indexed_sheet_fields){
            let value=indexed_sheet_fields[key];
            sheet.getRange(new_row, key).setValue(post_data[value]);

        }
        return ContentService.createTextOutput("Location added successfully.");

    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }


}
function getSheetByName(sheet_name) {

    var spread_sheet = SpreadsheetApp.getActive();
    for(var n in spread_sheet.getSheets()){
        var sheet = spread_sheet.getSheets()[n];
        var name = sheet.getName();
        if(name == sheet_name ){
            return sheet;
        }

    }
    return false;
}

function add_delete_fulfillment_events_in_sheet(post_data) {

    try{

        var sheet =getSheetByName('fulfillment_events');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'fulfillment_events' found in spreadsheet.");
        if(post_data.request_type=="fulfillment_events/create"){
            delete post_data.admin_graphql_api_id;
            delete post_data.request_type;
            var lastRow = Math.max(sheet.getLastRow(), 1);
            var new_row = lastRow + 1;
            var column_no=1;
            sheet.insertRowAfter(lastRow);
            for(var key in post_data){
                let value=post_data[key];
                sheet.getRange(new_row, column_no).setValue(value || '');
                column_no++;
            }
            return ContentService.createTextOutput("Full fillment event  added successfully.");

        }


        else{
            var data = sheet.getDataRange().getValues();
            var  found_row_in_sheet=false;
            for (var i = 1; i <= data.length; i++) {
                var current_sheet_row = data[i];
                if (typeof current_sheet_row !=='undefined' && current_sheet_row[0] == post_data.id) {
                    found_row_in_sheet=true;
                    //exclude header row
                    var new_row = i +1;
                    sheet.deleteRow(new_row);
                    return ContentService.createTextOutput("Fulfillment event  deleted from google sheet.");
                }
            }
            if(!found_row_in_sheet)
                return ContentService.createTextOutput('No row found in sheet with this id');
        }
    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }
}


function update_fulfillments_in_sheet(post_data) {
    try {
        const indexed_sheet_fields = {
            "1": "id",
            "2": "order_id",
            "3": "status",
            "4": "created_at",
            "5": "service",
            "6": "updated_at",
            "7": "tracking_company",
            "8": "shipment_status",
            "9": "location_id",
            "10": "email",
            "11": "destination",
            "12": "tracking_number",
            "13": "tracking_url",
            "14": "receipt",
            "15": "name",

        };
        const line_items_sheet_fields = {
            "16": "id",
            "17": "title",
            "18": "quantity",
            "19": "sku",
            "20": "line_item_title",
            "21": "vendor",
            "22": "fulfillment_service",
            "23": "requires_shipping",
            "24": "taxable",
            "25": "gift_card",
            "26": "line_item_inventory_management",
            "27": "grams",
            "28": "price",
            "29": "total_discount",
            "30": "fulfillment_status"
        };
        var sheet = getSheetByName('fulfillments');
        if (!sheet) return ContentService.createTextOutput("No sheet having name 'fulfillments' found in spreadsheet.");
        var found_row_in_sheet = false;
        var data = sheet.getDataRange().getValues();
        var first_instance = false;
        var new_row = 0;
        for (var i = 1; i <= data.length; i++) {
            current_sheet_row = data[i];
            if (typeof current_sheet_row !== 'undefined' && current_sheet_row[0] == post_data.id) {
                found_row_in_sheet = true;
                if (first_instance === false) {
                    //exclude header row
                    new_row = i + 1;
                    first_instance = true;
                    // update the first row found for the line item

                    for (var key in indexed_sheet_fields) {
                        let value = indexed_sheet_fields[key];
                        sheet.getRange(new_row, key).setValue(post_data[value]);
                    }
                    //loop line_items
                    var line_items = post_data.line_items;

                    //loop line_items
                    var line_items = post_data.line_items;
                    if (line_items && line_items.length) {

                        for (var opt in line_items) {
                            if (opt > 0) {
                                sheet.insertRowAfter(new_row);
                                new_row++;
                                sheet.getRange(new_row, 1).setValue(post_data.id);
                                sheet.getRange(new_row, 2).setValue(post_data.order_id);
                            }
                            for (var line_item_array_key in line_items_sheet_fields) {
                                let line_item_key_value = line_items_sheet_fields[line_item_array_key];
                                sheet.getRange(new_row, line_item_array_key).setValue(line_items[opt][line_item_key_value]);
                            }
                        }
                    }
                    new_row++;

                }
                else {
                    //delete the existing rows of same product after updating first row and adding new rows under it for more than one line_items
                    sheet.deleteRow(new_row);
                    // return ContentService.createTextOutput(new_row);
                }
            } else {
                //row numbers
                new_row++;
            }
        }


        if (!found_row_in_sheet) return ContentService.createTextOutput("No record found in fullfillments sheet.");
        return ContentService.createTextOutput("Fullfillment rows updated successfully.");


    } catch (err) {
        return ContentService.createTextOutput(err.message);
    }

}


function add_fulfillments_in_sheet(post_data) {
    try {
        const indexed_sheet_fields = {
            "1": "id",
            "2": "order_id",
            "3": "status",
            "4": "created_at",
            "5": "service",
            "6": "updated_at",
            "7": "tracking_company",
            "8": "shipment_status",
            "9": "location_id",
            "10": "email",
            "11": "destination",
            "12": "tracking_number",
            "13": "tracking_url",
            "14": "receipt",
            "15": "name",

        };
        const line_items_sheet_fields = {
            "16": "id",
            "17": "title",
            "18": "quantity",
            "19": "sku",
            "20": "line_item_title",
            "21": "vendor",
            "22": "fulfillment_service",
            "23": "requires_shipping",
            "24": "taxable",
            "25": "gift_card",
            "26": "line_item_inventory_management",
            "27": "grams",
            "28": "price",
            "29": "total_discount",
            "30": "fulfillment_status"
        };
        var sheet = getSheetByName('fulfillments');
        if (!sheet) return ContentService.createTextOutput("No sheet having name 'fulfillments' found in spreadsheet.");


        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        sheet.insertRowAfter(lastRow);
        //var ui= SpreadsheetApp.getUi();
        for (var key in indexed_sheet_fields) {
            let value = indexed_sheet_fields[key];

            sheet.getRange(new_row, key).setValue(post_data[value]);
        }
        //loop line_items
        var line_items = post_data.line_items;
        if (line_items && line_items.length) {

            for (var opt in line_items) {
                if (opt > 0) {
                    sheet.insertRowAfter(new_row);
                    new_row++;
                    sheet.getRange(new_row, 1).setValue(post_data.id);
                    sheet.getRange(new_row, 2).setValue(post_data.order_id);
                }
                for (var line_item_array_key in line_items_sheet_fields) {
                    let line_item_key_value = line_items_sheet_fields[line_item_array_key];
                    sheet.getRange(new_row, line_item_array_key).setValue(line_items[opt][line_item_key_value]);
                }
            }
        }

        return ContentService.createTextOutput("Fullfillment rows added successfully.");
    } catch (err) {
        return ContentService.createTextOutput(err.message);
    }

}



function update_shop_in_sheet(post_data) {

    try{
        const indexed_sheet_fields = {
            "1": "id",
            "2": "name",
            "3": "email",
            "4": "domain",
            "5": "province",
            "6": "country",
            "7": "address1",
            "8": "zip",
            "9": "city",
            "10": "phone",
            "11": "primary_locale",
            "12": "address2",
            "13": "updated_at",
            "14": "country_code",
            "15": "country_name",
            "16":"currency",
            "17":"customer_email",
            "18":"shop_owner",
            "19":"weight_unit",
            "20":"plan_display_name",
            "21":"plan_name",
            "22":"enabled_presentment_currencies"


        };
        var sheet =getSheetByName('shop');
        if(!sheet)return ContentService.creshopateTextOutput("No sheet having name 'shop' found in spreadsheet.Please create new sheet with this name and keep header fields descrived into docs.");
        var data = sheet.getDataRange().getValues();
        var  found_row_in_sheet=false;
        for (var i = 1; i <= data.length; i++) {
            current_sheet_row = data[i];
            if (typeof current_sheet_row !=='undefined' && current_sheet_row[0] == post_data.id) {
                found_row_in_sheet=true;
                //exclude header row
                var new_row = i +1;
                // if update webhook triggered
                for(var key in indexed_sheet_fields){
                    let value=indexed_sheet_fields[key];
                    sheet.getRange(new_row, key).setValue(post_data[value]);

                }
                return ContentService.createTextOutput("Shop updated successfully.");

            }
        }
        if(!found_row_in_sheet){

            var lastRow = Math.max(sheet.getLastRow(), 1);
            var new_row = lastRow + 1;
            sheet.insertRowAfter(lastRow);
            for(var key in indexed_sheet_fields){
                let value=indexed_sheet_fields[key];
                sheet.getRange(new_row, key).setValue(post_data[value]);

            }
            return ContentService.createTextOutput("Shop updated successfully.");
        }



    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }
}

function update_theme_in_sheet(post_data) {
    try{
        var sheet =getSheetByName('theme');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'theme' found in spreadsheet.Please create new sheet with this name and keep header fields descrived into docs.");
        var data = sheet.getDataRange().getValues();
        var column_no=1;
        delete post_data.admin_graphql_api_id;
        var  found_row_in_sheet=false;
        for (var i = 1; i <= data.length; i++) {
            var current_sheet_row = data[i];
            if (typeof current_sheet_row !='undefined' && post_data.id && current_sheet_row[0] == post_data.id) {
                found_row_in_sheet=true;
                //exclude header row
                var new_row = i +1;

                if(post_data.request_type=='themes/delete'){
                    sheet.deleteRow(new_row);
                    return ContentService.createTextOutput("Theme deleted from google sheet.");
                }
                // if update webhook triggered
                delete post_data.request_type;
                for(var key in post_data){
                    let value=post_data[key];
                    sheet.getRange(new_row, column_no).setValue(value);
                    column_no++;

                }
                return ContentService.createTextOutput("Theme updated successfully.");

            }
        }
        if(!found_row_in_sheet){
            var lastRow = Math.max(sheet.getLastRow(), 1);
            var new_row = lastRow + 1;
            delete post_data.request_type;
            sheet.insertRowAfter(lastRow);
            for(var keys in post_data){
                let value=post_data[keys];
                sheet.getRange(new_row, column_no).setValue(value);
                column_no++;

            }
            return ContentService.createTextOutput("Theme added successfully.");
        }
    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }
}

function add_update_del_customer_groups_in_sheet(post_data) {
    try{
        var sheet =getSheetByName('customer_saved_search');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'customer_saved_search' found in spreadsheet.Please create new sheet with this name and keep header fields descrived into docs.");
        var data = sheet.getDataRange().getValues();
        var column_no=1;
        var  found_row_in_sheet=false;
        for (var i = 1; i <= data.length; i++) {
            var current_sheet_row = data[i];
            if (typeof current_sheet_row !='undefined' && post_data.id && current_sheet_row[0] == post_data.id) {
                found_row_in_sheet=true;
                //exclude header row
                var new_row = i +1;

                if(post_data.request_type=='customer_groups/delete'){
                    sheet.deleteRow(new_row);
                    return ContentService.createTextOutput("row deleted from google sheet.");
                }
                // if update webhook triggered
                delete post_data.request_type;
                for(var key in post_data){
                    let value=post_data[key];
                    sheet.getRange(new_row, column_no).setValue(value);
                    column_no++;

                }
                return ContentService.createTextOutput("row updated successfully.");

            }
        }
        if(!found_row_in_sheet){
            var lastRow = Math.max(sheet.getLastRow(), 1);
            var new_row = lastRow + 1;
            delete post_data.request_type;
            sheet.insertRowAfter(lastRow);
            for(var keys in post_data){
                let value=post_data[keys];
                sheet.getRange(new_row, column_no).setValue(value);
                column_no++;

            }
            return ContentService.createTextOutput("row added successfully.");
        }
    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }
}

function add_orders_edited_rows_in_sheet(post_data) {
    try{
        var sheet =getSheetByName('order_edits');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'order_edits' found in spreadsheet.Please create new sheet with this name and keep header fields descrived into docs.");
        var column_no=1;

        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        delete post_data.request_type;
        sheet.insertRowAfter(lastRow);

        for(var key in post_data){
            let value=post_data[key];
            if(key=='line_items'){
                sheet.getRange(new_row, column_no).setValue(value.additions);
                column_no++;
                sheet.getRange(new_row, column_no).setValue(value.removals);
            }else{
                sheet.getRange(new_row, column_no).setValue(value);
            }

            column_no++;

        }
        return ContentService.createTextOutput("Order Edit added successfully.");

    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }
}

function add_update_locales_in_sheet(post_data) {
    try{
        var sheet =getSheetByName('locales');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'locales' found in spreadsheet.Please create new sheet with this name and keep header fields descrived into docs.");
        var data = sheet.getDataRange().getValues();
        var column_no=1;
        var  found_row_in_sheet=false;
        delete post_data.request_type;
        for (var i = 1; i <= data.length; i++) {
            var current_sheet_row = data[i];
            if (typeof current_sheet_row !='undefined' && post_data.id && current_sheet_row[0] == post_data.locale) {
                found_row_in_sheet=true;
                //exclude header row
                var new_row = i +1;
                // if update webhook triggered
                for(var key in post_data){
                    let value=post_data[key];
                    sheet.getRange(new_row, column_no).setValue(value);
                    column_no++;

                }
                return ContentService.createTextOutput("Locale row updated into the sheet successfully.");

            }
        }
        if(!found_row_in_sheet){
            var lastRow = Math.max(sheet.getLastRow(), 1);
            var new_row = lastRow + 1;

            sheet.insertRowAfter(lastRow);
            for(var keys in post_data){
                let value=post_data[keys];
                sheet.getRange(new_row, column_no).setValue(value);
                column_no++;

            }
            return ContentService.createTextOutput("Locale row added into the sheet successfully.");
        }
    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }
}

function doPost(e) {

    try {
        var post_data= JSON.parse(e.postData.contents);
        switch (post_data.request_type) {
            case "checkouts/create":
                return   add_checkouts_in_sheet(post_data);
                break;
            case "checkouts/update":
                return   update_checkouts_in_sheet(post_data);
                break;
            case "checkouts/delete":
                return  delete_object_rows_in_sheet(post_data.id,'checkouts');
                break;

            case "orders/create":
                return   add_order_rows_in_sheet(post_data);
                break;
            case "orders/deleted":
                return  delete_object_rows_in_sheet(post_data.name,'orders');
                break;
                break;
            case "orders/fulfilled":
            case "orders/partially_fulfilled":
            case "orders/paid":
            case "orders/updated":
                //return ContentService.createTextOutput("here order obj successfully.");
                return  update_order_rows_in_sheet(post_data);
                break;
            case "customers/create":
                return   add_customer_in_sheet(post_data);
                break;
            case "customers/update":
            case "customers/enable":
            case "customers/disable":
            case "customers/delete":
                return   update_delete_customer_in_sheet(post_data);
                break;
            case "products/create":
                return   add_product_in_sheet(post_data);
                break;
            case "products/update":
                // case "products/delete":
                return   update_product_in_sheet(post_data);
                break;

            case "draft_orders/create":
                return   add_draft_order_rows_in_sheet(post_data);
                break;
            case "draft_orders/update":
                return   update_draft_order_rows_in_sheet(post_data);
                break;

            case "collections/create":
                return   add_collection_in_sheet(post_data);
                break;
            case "collections/update":
            case "collections/delete":
                return   update_delete_collection_in_sheet(post_data);
                break;
            case "tender_transactions/create":
                return   add_tender_transactions_in_sheet(post_data);
                break;
            case "carts/create":
                return   add_cart_in_sheet(post_data);
                break;
            case "carts/update":
                return   update_cart_in_sheet(post_data);
                break;

            case "inventory_items/create":
                return   add_inventory_item_in_sheet(post_data);
                break;
            case "inventory_items/update":
            case "inventory_items/delete":
                return   update_delete_inventory_item_in_sheet(post_data);
                break;

            case "inventory_levels/connect":
            case "inventory_levels/disconnect":
            case "inventory_levels/update":
                return   update_inventory_levels_in_sheet(post_data);
                break;
            case "locations/create":
                return   add_location_in_sheet(post_data);
                break;
            case "locations/update":
            case "locations/delete":
                return   update_delete_location_in_sheet(post_data);
                break;
            case "order_transactions/create":
                return   add_order_transactions_in_sheet(post_data);
                break;

            case "fulfillments/create":
                return   add_fulfillments_in_sheet(post_data);
                break;
            case "fulfillments/update":
                return   update_fulfillments_in_sheet(post_data);
                break;

            case "fulfillment_events/create":
                return   add_delete_fulfillment_events_in_sheet(post_data);
                break;
            case "shop/update":
                return   update_shop_in_sheet(post_data);
                break;
            case "themes/create":
            case "themes/update":
            case "themes/publish":
            case "themes/delete":
                return   update_theme_in_sheet(post_data);
                break;
            case "customer_groups/create":
            case "customer_groups/update":
            case "customer_groups/delete":
                return   add_update_del_customer_groups_in_sheet(post_data);

            case "refunds/create":
                return   add_refunds_in_sheet(post_data);
                break;
            case "orders/edited":
                return   add_orders_edited_rows_in_sheet(post_data);
                break;
            case "locales/create":
            case "locales/update":
                return   add_update_locales_in_sheet(post_data);
                break;

            default:
                return ContentService.createTextOutput("No function found for this webhook in sheet apps script .");
                break;

        }
    }
    catch(err) {
        return ContentService.createTextOutput(err.message);
    }

}

function add_refunds_in_sheet(post_data) {
    try {
        const indexed_sheet_fields = {
            "1": "id",
            "2": "order_id",
            "3": "created_at",
            "4": "note",
            "5": "processed_at",
            "6": "restock",
            "7": "duties"


        };
        const refund_line_items_sheet_fields = {
            "8": "id",
            "9": "quantity",
            "10": "line_item_id",
            "11": "restock_type",
            "12": "subtotal",
            "13": "total_tax",
            "14": "variant_id",
            "15": "title",
            "16": "sku",
            "17": "variant_title",
            "18": "vendor",
            "19": "fulfillment_service",
            "20": "requires_shipping",
            "21": "grams",
            "22": "price",
            "23": "total_discount",
            "24": "fulfillment_status"


        };
        var sheet = getSheetByName('refunds');
        if (!sheet) return ContentService.createTextOutput("No sheet having name 'refunds' found in spreadsheet.");


        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        sheet.insertRowAfter(lastRow);
        //var ui= SpreadsheetApp.getUi();
        for (var key in indexed_sheet_fields) {
            let value = indexed_sheet_fields[key];

            sheet.getRange(new_row, key).setValue(post_data[value]);
        }
        //loop line_items
        var refund_line_items = post_data.refund_line_items;
        if (refund_line_items && refund_line_items.length) {

            for (var opt in refund_line_items) {
                if (opt > 0) {
                    sheet.insertRowAfter(new_row);
                    new_row++;
                    sheet.getRange(new_row, 1).setValue(post_data.id);
                    sheet.getRange(new_row, 2).setValue(post_data.order_id);
                }
                for (var line_item_array_key in refund_line_items_sheet_fields) {
                    let line_item_key_value = refund_line_items_sheet_fields[line_item_array_key];
                    if(line_item_array_key =>14){
                        sheet.getRange(new_row, line_item_array_key).setValue(refund_line_items[opt]['line_item'][line_item_key_value]);
                    }else{
                        sheet.getRange(new_row, line_item_array_key).setValue(refund_line_items[opt][line_item_key_value]);
                    }
                }
            }
        }

        return ContentService.createTextOutput("Refunds row added successfully.");
    } catch (err) {
        return ContentService.createTextOutput(err.message);
    }

}


function delete_object_rows_in_sheet(comparative_col_value,sheet_name) {
    try {

        var sheet = getSheetByName(sheet_name);
        if (!sheet) return ContentService.createTextOutput('No sheet having name '+sheet_name+' found in spreadsheet.');
        var found_row_in_sheet = false;

        var rows = sheet.getDataRange();
        var numRows = rows.getNumRows();
        var values = rows.getValues();
        var rowsDeleted = 0;

        // delete procedure
        for (var i = 0; i <= numRows - 1; i++) {
            var row = values[i];
            if (typeof row !== 'undefined' && row[0] == comparative_col_value) {
                if(!found_row_in_sheet)
                    found_row_in_sheet=true;
                sheet.deleteRow((parseInt(i) + 1) - rowsDeleted);
                rowsDeleted++;
            }
        }


        if (!found_row_in_sheet) return ContentService.createTextOutput("No record found in sheet.");
        return ContentService.createTextOutput("Object rows deleted successfully.");


    } catch (err) {
        return ContentService.createTextOutput(err.message);
    }

}
function update_checkouts_in_sheet(post_data) {
    try {
        const indexed_sheet_fields = {
            "1": "id",
            "2": "token",
            "3": "cart_token",
            "4": "email",
            "5": "gateway",
            "6": "created_at",
            "7": "updated_at",
            "8": "note",
            "9": "note_attributes",
            "10": "total_weight",
            "11": "currency",
            "12": "completed_at",
            "13": "phone",
            "14": "source_name",
            "15": "total_discounts",
            "16": "total_line_items_price",
            "17": "total_price",
            "18": "total_tax",
            "19": "subtotal_price",
            "20": "billing_address",
            "21": "shipping_address",
            "22": "customer",
            "23": "default_address"

        };
        const line_items_sheet_fields = {
            "24": "variant_id",
            "25": "title",
            "26": "variant_title",
            "27": "variant_price",
            "28": "vendor",
            "29": "sku",
            "30": "grams",
            "31": "gift_card",
            "32": "fulfillment_service",
            "33": "line_price",
            "34": "compare_at_price",
            "35": "price",
            "36": "applied_discounts"

        };
        var sheet = getSheetByName('checkouts');
        if (!sheet) return ContentService.createTextOutput("No sheet having name 'checkouts' found in spreadsheet.");
        var found_row_in_sheet = false;
        var data = sheet.getDataRange().getValues();
        var first_instance = false;
        var new_row = 0;
        for (var i = 1; i <= data.length; i++) {
            var current_sheet_row = data[i];
            if (typeof current_sheet_row !== 'undefined' && current_sheet_row[0] == post_data.id) {
                found_row_in_sheet = true;
                if (first_instance === false) {
                    //exclude header row
                    new_row = i + 1;
                    first_instance = true;
                    // update the first row found for the line item

                    for (var key in indexed_sheet_fields) {
                        let value = indexed_sheet_fields[key];
                        sheet.getRange(new_row, key).setValue(post_data[value]);
                    }

                    //loop line_items
                    var line_items = post_data.line_items;
                    if (line_items && line_items.length) {

                        for (var opt in line_items) {
                            if (opt > 0) {
                                sheet.insertRowAfter(new_row);
                                new_row++;
                                sheet.getRange(new_row, 1).setValue(post_data.id);
                            }
                            for (var line_item_array_key in line_items_sheet_fields) {
                                let line_item_key_value = line_items_sheet_fields[line_item_array_key];
                                sheet.getRange(new_row, line_item_array_key).setValue(line_items[opt][line_item_key_value]);
                            }
                        }
                    }
                    new_row++;

                }
                else {
                    //delete the existing rows of same product after updating first row and adding new rows under it for more than one line_items
                    sheet.deleteRow(new_row);
                    // return ContentService.createTextOutput(new_row);
                }
            } else {
                //row numbers
                new_row++;
            }
        }


        if (!found_row_in_sheet) return ContentService.createTextOutput("No record found in checkouts sheet.");
        return ContentService.createTextOutput("checkout rows updated successfully.");


    } catch (err) {
        return ContentService.createTextOutput(err.message);
    }

}

function add_checkouts_in_sheet(post_data) {
    try {
        const indexed_sheet_fields = {
            "1": "id",
            "2": "token",
            "3": "cart_token",
            "4": "email",
            "5": "gateway",
            "6": "created_at",
            "7": "updated_at",
            "8": "note",
            "9": "note_attributes",
            "10": "total_weight",
            "11": "currency",
            "12": "completed_at",
            "13": "phone",
            "14": "source_name",
            "15": "total_discounts",
            "16": "total_line_items_price",
            "17": "total_price",
            "18": "total_tax",
            "19": "subtotal_price",
            "20": "billing_address",
            "21": "shipping_address",
            "22": "customer",
            "23": "default_address"

        };
        const line_items_sheet_fields = {
            "24": "variant_id",
            "25": "title",
            "26": "variant_title",
            "27": "variant_price",
            "28": "vendor",
            "29": "sku",
            "30": "grams",
            "31": "gift_card",
            "32": "fulfillment_service",
            "33": "line_price",
            "34": "compare_at_price",
            "35": "price",
            "36": "applied_discounts"

        };
        var sheet = getSheetByName('checkouts');
        if (!sheet) return ContentService.createTextOutput("No sheet having name 'checkouts' found in spreadsheet.");


        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        sheet.insertRowAfter(lastRow);
        //var ui= SpreadsheetApp.getUi();
        for (var key in indexed_sheet_fields) {
            let value = indexed_sheet_fields[key];

            sheet.getRange(new_row, key).setValue(post_data[value]);
        }
        //loop line_items
        var line_items = post_data.line_items;
        if (line_items && line_items.length) {

            for (var opt in line_items) {
                if (opt > 0) {
                    sheet.insertRowAfter(new_row);
                    new_row++;
                    sheet.getRange(new_row, 1).setValue(post_data.id);
                }
                for (var line_item_array_key in line_items_sheet_fields) {
                    let line_item_key_value = line_items_sheet_fields[line_item_array_key];
                    sheet.getRange(new_row, line_item_array_key).setValue(line_items[opt][line_item_key_value]);
                }
            }
        }

        return ContentService.createTextOutput("Checkout row added successfully.");
    } catch (err) {
        return ContentService.createTextOutput(err.message);
    }

}







function update_order_rows_in_sheet(post_data) {
    try{
        var spread_sheet = SpreadsheetApp.getActive();
        var found_sheet=false;
        var found_row_in_sheet=false;
        for(var n in spread_sheet.getSheets()){
            var sheet = spread_sheet.getSheets()[n];
            var name = sheet.getName();//get name
            if(name == 'orders' ){


                found_sheet=true;
                var data = sheet.getDataRange().getValues();
                var first_instance = false;
                var new_row = 0;
                for (var i = 1; i <= data.length; i++) {
                    current_sheet_row = data[i];
                    if (typeof current_sheet_row !=='undefined' && current_sheet_row[0] == post_data.name) {
                        found_row_in_sheet=true;
                        if (first_instance===false) {
                            //exclude header row
                            new_row = i +1;
                            //  ui.alert('detected row no'+new_row);
                            first_instance = true;
                            // update the first row found for the line item
                            sheet.getRange(new_row, 1).setValue( post_data.name);
                            sheet.getRange(new_row, 2).setValue(post_data.email);
                            sheet.getRange(new_row, 3).setValue(post_data.financial_status);
                            sheet.getRange(new_row, 4).setValue(post_data.fulfillment_status);
                            sheet.getRange(new_row, 5).setValue(post_data.subtotal_price);
                            sheet.getRange(new_row, 6).setValue(post_data.total_shipping_price_set.amount);
                            sheet.getRange(new_row, 7).setValue(post_data.total_tax);
                            sheet.getRange(new_row, 8).setValue(post_data.total_price);
                            sheet.getRange(new_row, 9).setValue(post_data.created_at);
                            // customer note
                            sheet.getRange(new_row, 13).setValue(post_data.note);
                            //loop line items
                            var line_items = post_data.line_items;
                            for (var j=0;j< line_items.length;j++) {

                                if (j > 0) {
                                    sheet.insertRowAfter(new_row);

                                    new_row++;
                                    ///  ui.alert('inserted row no'+new_row);
                                    sheet.getRange(new_row, 1).setValue( post_data.name);
                                    sheet.getRange(new_row, 2).setValue(post_data.email);
                                }
                                sheet.getRange(new_row, 10).setValue(line_items[j].quantity);
                                sheet.getRange(new_row, 11).setValue(line_items[j].name);
                                sheet.getRange(new_row, 12).setValue(line_items[j].price);


                                //delete all rows after this index

                            }
                            new_row++;

                        }
                        else
                        {

                            //delete the existing rows of same order after updating first row and adding new rows under it for more than one line items
                            sheet.deleteRow(new_row);
                        }


                    }else{
                        //row numbers
                        new_row++;
                    }


                }
                return ContentService.createTextOutput("order updated successfully.");
                break;
            }

        }

        if(!found_sheet)return ContentService.createTextOutput("No sheet having name 'orders' found in spreadsheet.");
        if(!found_row_in_sheet)return ContentService.createTextOutput("No record found in orders sheet.");



    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }

}


function update_delete_customer_in_sheet(post_data) {

    try{
        var spread_sheet = SpreadsheetApp.getActive();
        var found_sheet=false;
        var found_row_in_sheet=false;
        for(var n in spread_sheet.getSheets()){

            var sheet = spread_sheet.getSheets()[n];
            var name = sheet.getName();//get name

            if(name == 'customers' ){
                found_sheet=true;
                var data = sheet.getDataRange().getValues();

                for (var i = 1; i <= data.length; i++) {
                    current_sheet_row = data[i];
                    if (typeof current_sheet_row !=='undefined' && current_sheet_row[0] == post_data.id) {
                        found_row_in_sheet=true;
                        //exclude header row
                        var new_row = i +1;

                        // if delete webhook called
                        if(post_data.request_type=="customers/delete"){
                            sheet.deleteRow(new_row);
                            return ContentService.createTextOutput("Customer row deleted from google sheet.");
                        }

                        // if update,enable,disable webhook triggered
                        sheet.getRange(new_row, 1).setValue( post_data.id);
                        sheet.getRange(new_row, 2).setValue( post_data.first_name);
                        sheet.getRange(new_row, 3).setValue(post_data.last_name);
                        sheet.getRange(new_row, 4).setValue(post_data.email);

                        if(post_data.default_address){
                            var default_address=post_data.default_address;
                            sheet.getRange(new_row, 5).setValue(default_address.company);
                            sheet.getRange(new_row,6).setValue(default_address.address1);
                            sheet.getRange(new_row,7).setValue(default_address.address2);
                            sheet.getRange(new_row,8).setValue(default_address.city);
                            sheet.getRange(new_row,9).setValue(default_address.province);
                            sheet.getRange(new_row, 10).setValue(default_address.country_name);
                            sheet.getRange(new_row, 11).setValue(default_address.country_code);
                            sheet.getRange(new_row, 13).setValue(default_address.zip);
                        }
                        sheet.getRange(new_row, 14).setValue(post_data.phone);
                        sheet.getRange(new_row, 15).setValue(post_data.accepts_marketing==1?'TRUE':'FALSE');
                        sheet.getRange(new_row, 16).setValue(post_data.total_spent);
                        sheet.getRange(new_row, 17).setValue(post_data.orders_count);
                        sheet.getRange(new_row, 18).setValue(post_data.tags);
                        sheet.getRange(new_row, 19).setValue(post_data.note);




                        SpreadsheetApp.flush();
                        return ContentService.createTextOutput("Customer update added successfully.");

                    }
                }

                break;

            }

        }
        if(!found_sheet)return ContentService.createTextOutput("No sheet having name 'customers' found in spreadsheet.");
        if(!found_row_in_sheet)return ContentService.createTextOutput("No record found in customers sheet.");



    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }

}

function add_customer_in_sheet(post_data) {

    try{
        var found_sheet=false;
        var spread_sheet = SpreadsheetApp.getActive();
        for(var n in spread_sheet.getSheets()){

            var sheet = spread_sheet.getSheets()[n];
            var name = sheet.getName();//get name

            if(name == 'customers' ){
                found_sheet=true;
                var lastRow = Math.max(sheet.getLastRow(), 1);
                var new_row = lastRow + 1;
                sheet.insertRowAfter(lastRow);
                sheet.getRange(new_row, 1).setValue( post_data.id);
                sheet.getRange(new_row, 2).setValue( post_data.first_name);
                sheet.getRange(new_row, 3).setValue(post_data.last_name);
                sheet.getRange(new_row, 4).setValue(post_data.email);

                if(post_data.default_address){
                    var default_address=post_data.default_address;
                    sheet.getRange(new_row, 5).setValue(default_address.company);
                    sheet.getRange(new_row,6).setValue(default_address.address1);
                    sheet.getRange(new_row,7).setValue(default_address.address2);
                    sheet.getRange(new_row,8).setValue(default_address.city);
                    sheet.getRange(new_row,9).setValue(default_address.province);
                    sheet.getRange(new_row, 10).setValue(default_address.country_name);
                    sheet.getRange(new_row, 11).setValue(default_address.country_code);
                    sheet.getRange(new_row, 13).setValue(default_address.zip);


                }
                sheet.getRange(new_row, 14).setValue(post_data.phone);
                sheet.getRange(new_row, 15).setValue(post_data.accepts_marketing==1?'TRUE':'FALSE');
                sheet.getRange(new_row, 16).setValue(post_data.total_spent);
                sheet.getRange(new_row, 17).setValue(post_data.orders_count);
                sheet.getRange(new_row, 18).setValue(post_data.tags);
                sheet.getRange(new_row, 19).setValue(post_data.note);



                SpreadsheetApp.flush();
                return ContentService.createTextOutput("Customer row added successfully.");
                break;
            }
        }

        if(!found_sheet)return ContentService.createTextOutput("No sheet having name 'customers' found in spreadsheet.");


    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }


}

function add_order_rows_in_sheet(post_data) {
    var spread_sheet = SpreadsheetApp.getActive();
    for(var n in spread_sheet.getSheets()){

        var sheet = spread_sheet.getSheets()[n];
        var name = sheet.getName();//get name

        if(name == 'orders' ){

            var lastRow = Math.max(sheet.getLastRow(), 1);
            var new_row = lastRow + 1;
            sheet.insertRowAfter(lastRow);
            sheet.getRange(new_row, 1).setValue( post_data.name);
            sheet.getRange(new_row, 2).setValue(post_data.email);
            sheet.getRange(new_row, 3).setValue(post_data.financial_status);
            sheet.getRange(new_row, 4).setValue(post_data.fulfillment_status);
            sheet.getRange(new_row, 5).setValue(post_data.subtotal_price);
            sheet.getRange(new_row, 6).setValue(post_data.total_shipping_price_set.amount);
            sheet.getRange(new_row, 7).setValue(post_data.total_tax);
            sheet.getRange(new_row, 8).setValue(post_data.total_price);
            sheet.getRange(new_row, 9).setValue(post_data.created_at);
            // customer note
            sheet.getRange(new_row, 13).setValue(post_data.note);

            //loop line items
            var line_items = post_data.line_items;
            for (var i in line_items) {
                if (i > 0) {
                    new_row++;
                    sheet.getRange(new_row, 1).setValue(post_data.name);
                    sheet.getRange(new_row, 2).setValue(post_data.email);
                }
                sheet.getRange(new_row, 10).setValue(line_items[i].quantity);
                sheet.getRange(new_row, 11).setValue(line_items[i].name);
                sheet.getRange(new_row, 12).setValue(line_items[i].price);


            }


            SpreadsheetApp.flush();
            return ContentService.createTextOutput("Order row added successfully.");
            break;
        }
    }
}



function getKeyByValue(object, value) {
    return Object.keys(object).find(key => object[key] === value);
}
function add_product_in_sheet(post_data) {

    const indexed_sheet_fields = {"1" : "handle", "2" : "title", "3" : "body_html", "4" : "vendor", "5" : "product_type", "6" : "tags", "7" : "published_at","8":"option_1","10":"option_2","12":"option_3"};
    const variants_sheet_fields={"9":"option1","11":"option2","13":"option3","14":"sku","15":"gram","16":"inventory_quantity","17":"fulfillment_service","18":"price","19":"compare_at_price","20":"taxable","21":"barcode","22":"variant_image","23":"weight_unit"};
    var spread_sheet = SpreadsheetApp.getActive();
    //var ui=SpreadsheetApp.getUi();
    for(var n in spread_sheet.getSheets()){

        var sheet = spread_sheet.getSheets()[n];
        var name = sheet.getName();//get name

        if(name == 'products' ){
            var lastRow = Math.max(sheet.getLastRow(), 1);
            var new_row = lastRow + 1;
            sheet.insertRowAfter(lastRow);
            //  Logger.log(post_data.handle);return;
            for(var key in indexed_sheet_fields){
                let value=indexed_sheet_fields[key];

                sheet.getRange(new_row, key).setValue(post_data[value]);
            }
            // loop options

            var options=post_data.options;

            if(options && options.length){
                let key_index=8;
                for(var opt in options){
                    sheet.getRange(new_row, key_index).setValue(options[opt].name);
                    key_index=key_index+2;
                }

            }
            //loop variants
            var variants=post_data.variants;

            if(variants && variants.length){

                for(var opt in variants){
                    if(opt>0)
                        sheet.getRange(new_row, 1).setValue(post_data.handle);
                    for(var key in variants_sheet_fields){
                        let variant_key_value=variants_sheet_fields[key];


                        if(variant_key_value=='variant_image'){
                            var p_images=post_data.images;
                            for(var img_key in p_images ){

                                let current_variant_id=variants[opt].id;
                                let variant_ids=  p_images[img_key].variant_ids || [];
                                // ui.alert(current_variant_id);

                                //Logger.log(variant_ids[1]+'==');return;

                                if(variant_ids.indexOf(current_variant_id)){

                                    sheet.getRange(new_row, key).setValue(p_images[img_key].src);
                                }

                            }
                        }else{
                            sheet.getRange(new_row, key).setValue(variants[opt][variant_key_value]);
                        }


                    }

                    new_row++;

                }

            }

            SpreadsheetApp.flush();
            return ContentService.createTextOutput("Product row added successfully.");
            break;
        }
    }



}

function update_product_in_sheet(post_data) {
    try{
        const indexed_sheet_fields = {"1" : "handle", "2" : "title", "3" : "body_html", "4" : "vendor", "5" : "product_type", "6" : "tags", "7" : "published_at","8":"option_1","10":"option_2","12":"option_3"};
        const variants_sheet_fields={"9":"option1","11":"option2","13":"option3","14":"sku","15":"gram","16":"inventory_quantity","17":"fulfillment_service","18":"price","19":"compare_at_price","20":"taxable","21":"barcode","22":"variant_image","23":"weight_unit"};
        var spread_sheet = SpreadsheetApp.getActive();
        var found_sheet=false;
        var found_row_in_sheet=false;
        for(var n in spread_sheet.getSheets()){
            var sheet = spread_sheet.getSheets()[n];
            var name = sheet.getName();//get name
            if(name == 'products' ){

                found_sheet=true;
                var data = sheet.getDataRange().getValues();
                var first_instance = false;
                var new_row = 0;
                for (var i = 1; i <= data.length; i++) {
                    current_sheet_row = data[i];
                    if (typeof current_sheet_row !=='undefined' && current_sheet_row[0] == post_data.handle) {
                        found_row_in_sheet=true;
                        if (first_instance===false) {
                            //exclude header row
                            new_row = i +1;
                            first_instance = true;
                            // update the first row found for the line item

                            for(var key in indexed_sheet_fields){
                                let value=indexed_sheet_fields[key];

                                sheet.getRange(new_row, key).setValue(post_data[value]);
                            }

                            // loop options

                            var options=post_data.options;

                            if(options && options.length){
                                let key_index=8;
                                for(var opt in options){
                                    sheet.getRange(new_row, key_index).setValue(options[opt].name);
                                    key_index=key_index+2;
                                }

                            }
                            //loop variants
                            var variants=post_data.variants;

                            if(variants && variants.length){

                                for(var opt in variants){

                                    if(opt>0){
                                        sheet.insertRowAfter(new_row);
                                        new_row++;
                                        sheet.getRange(new_row, 1).setValue(post_data.handle);
                                    }

                                    for(var key in variants_sheet_fields){
                                        let variant_key_value=variants_sheet_fields[key];
                                        if(variant_key_value=='variant_image'){
                                            var p_images=post_data.images;
                                            for(var img_key in p_images ){

                                                let current_variant_id=variants[opt].id;
                                                let variant_ids=  p_images[img_key].variant_ids || [];
                                                // ui.alert(current_variant_id);

                                                //Logger.log(variant_ids[1]+'==');return;

                                                if(variant_ids.indexOf(current_variant_id)){

                                                    sheet.getRange(new_row, key).setValue(p_images[img_key].src);
                                                }

                                            }
                                        }else{
                                            sheet.getRange(new_row, key).setValue(variants[opt][variant_key_value]);
                                        }
                                    }

                                }
                            }
                            new_row++;
                        }
                        else
                        {

                            //delete the existing rows of same product after updating first row and adding new rows under it for more than one variants

                            sheet.deleteRow(new_row);
                            // return ContentService.createTextOutput(new_row);
                        }


                    }else{
                        //row numbers
                        new_row++;
                    }


                }

                break;
            }

        }

        if(!found_sheet)return ContentService.createTextOutput("No sheet having name 'products' found in spreadsheet.");
        if(!found_row_in_sheet)return ContentService.createTextOutput("No record found in products sheet.");
        return ContentService.createTextOutput("product updated successfully.");


    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }

}


function update_draft_order_rows_in_sheet(post_data) {
    try{
        var spread_sheet = SpreadsheetApp.getActive();
        var found_sheet=false;
        var found_row_in_sheet=false;
        for(var n in spread_sheet.getSheets()){
            var sheet = spread_sheet.getSheets()[n];
            var name = sheet.getName();//get name
            if(name == 'draft_orders' ){
                found_sheet=true;
                var data = sheet.getDataRange().getValues();
                var first_instance = false;
                var new_row = 0;
                for (var i = 1; i <= data.length; i++) {
                    current_sheet_row = data[i];
                    if (typeof current_sheet_row !=='undefined' && current_sheet_row[0] == post_data.name) {
                        found_row_in_sheet=true;
                        if (first_instance===false) {
                            //exclude header row
                            new_row = i +1;
                            first_instance = true;
                            // update the first row found for the line item
                            sheet.getRange(new_row, 1).setValue( post_data.name);
                            sheet.getRange(new_row, 2).setValue(post_data.id);
                            sheet.getRange(new_row, 3).setValue(post_data.email);
                            sheet.getRange(new_row, 4).setValue(post_data.status);
                            sheet.getRange(new_row, 5).setValue(post_data.currency);
                            if(post_data.applied_discount)
                                sheet.getRange(new_row, 6).setValue(post_data.applied_discount.amount || 0);
                            sheet.getRange(new_row, 7).setValue(post_data.subtotal_price);
                            if(post_data.shipping_line)
                                sheet.getRange(new_row, 8).setValue(post_data.shipping_line.price || 0);

                            sheet.getRange(new_row, 9).setValue(post_data.total_tax);

                            sheet.getRange(new_row, 10).setValue(post_data.tax_exempt);

                            sheet.getRange(new_row, 11).setValue(post_data.total_price);
                            // note on end
                            sheet.getRange(new_row, 15).setValue(post_data.note);

                            //loop line items
                            var line_items = post_data.line_items;
                            for (var j=0;j< line_items.length;j++) {

                                if (j > 0) {
                                    sheet.insertRowAfter(new_row);
                                    new_row++;
                                    ///  ui.alert('inserted row no'+new_row);
                                    sheet.getRange(new_row, 1).setValue( post_data.name);
                                    sheet.getRange(new_row, 2).setValue(post_data.id);
                                }
                                sheet.getRange(new_row, 12).setValue(line_items[j].quantity);
                                sheet.getRange(new_row, 13).setValue(line_items[j].name);
                                sheet.getRange(new_row, 14).setValue(line_items[j].price);
                                //delete all rows after this index

                            }
                            new_row++;

                        }
                        else
                        {
                            //delete the existing rows of same order after updating first row and adding new rows under it for more than one line items
                            sheet.deleteRow(new_row);
                        }


                    }else{
                        //row numbers
                        new_row++;
                    }


                }

                break;
            }

        }

        if(!found_sheet)return ContentService.createTextOutput("No sheet having name 'draft_orders' found in spreadsheet.");
        if(!found_row_in_sheet)return ContentService.createTextOutput("No record found in draft_orders sheet.");
        return ContentService.createTextOutput("draft order updated successfully.");


    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }

}

function add_draft_order_rows_in_sheet(post_data) {
    try{
        var found_sheet=false;
        var spread_sheet = SpreadsheetApp.getActive();
        for(var n in spread_sheet.getSheets()){

            var sheet = spread_sheet.getSheets()[n];
            var name = sheet.getName();//get name

            if(name == 'draft_orders' ){

                var lastRow = Math.max(sheet.getLastRow(), 1);
                var new_row = lastRow + 1;
                sheet.insertRowAfter(lastRow);
                sheet.getRange(new_row, 1).setValue( post_data.name);
                sheet.getRange(new_row, 2).setValue(post_data.id);
                sheet.getRange(new_row, 3).setValue(post_data.email);
                sheet.getRange(new_row, 4).setValue(post_data.status);
                sheet.getRange(new_row, 5).setValue(post_data.currency);
                if(post_data.applied_discount)
                    sheet.getRange(new_row, 6).setValue(post_data.applied_discount.amount || 0);
                sheet.getRange(new_row, 7).setValue(post_data.subtotal_price);
                if(post_data.shipping_line)
                    sheet.getRange(new_row, 8).setValue(post_data.shipping_line.price || 0);

                sheet.getRange(new_row, 9).setValue(post_data.total_tax);

                sheet.getRange(new_row, 10).setValue(post_data.tax_exempt);

                sheet.getRange(new_row, 11).setValue(post_data.total_price);
                // note on end
                sheet.getRange(new_row, 15).setValue(post_data.note);

                //loop line items
                var line_items = post_data.line_items;
                for (var j in line_items) {
                    if (j > 0) {
                        new_row++;
                        sheet.getRange(new_row, 1).setValue(post_data.name);
                        sheet.getRange(new_row, 2).setValue(post_data.id);
                    }
                    sheet.getRange(new_row, 12).setValue(line_items[j].quantity);
                    sheet.getRange(new_row, 13).setValue(line_items[j].name);
                    sheet.getRange(new_row, 14).setValue(line_items[j].price);


                }


                SpreadsheetApp.flush();
                return ContentService.createTextOutput("Draft Order row added successfully.");
                break;
            }
        }
        if(!found_sheet)return ContentService.createTextOutput("No sheet having name 'draft_orders' found in spreadsheet.");

    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }
}




function add_tender_transactions_in_sheet(post_data) {

    try{
        const indexed_sheet_fields = {"1" : "id", "2" : "order_id", "3" : "amount", "4" : "currency", "5" : "user_id", "6" : "test", "7" : "processed_at","8":"remote_reference","9":"payment_details","11":"payment_method"};
        var sheet =getSheetByName('tender_transactions');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'tender_transactions' found in spreadsheet.");

        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        sheet.insertRowAfter(lastRow);
        for(var key in indexed_sheet_fields){
            let value=indexed_sheet_fields[key];

            if(value=='payment_details'){
                sheet.getRange(new_row, 9).setValue(post_data.payment_details.credit_card_number || 0);
                sheet.getRange(new_row, 10).setValue(post_data.payment_details.credit_card_number || '');
            }else{
                sheet.getRange(new_row, key).setValue(post_data[value]);
            }


        }
        return ContentService.createTextOutput("Tender Transactions row added successfully.");

    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }


}


function add_collection_in_sheet(post_data) {

    try{
        const indexed_sheet_fields = {"1" : "id", "2" : "handle", "3" : "title", "4" : "updated_at", "5" : "body_html", "6" : "published_at", "7" : "sort_order","8":"template_suffix","9":"published_scope"};
        var sheet =getSheetByName('collections');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'collections' found in spreadsheet.");

        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        sheet.insertRowAfter(lastRow);
        for(var key in indexed_sheet_fields){
            let value=indexed_sheet_fields[key];
            sheet.getRange(new_row, key).setValue(post_data[value]);

        }
        return ContentService.createTextOutput("Collection row added successfully.");

    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }


}


function update_delete_collection_in_sheet(post_data) {

    try{
        const indexed_sheet_fields = {"1" : "id", "2" : "handle", "3" : "title", "4" : "updated_at", "5" : "body_html", "6" : "published_at", "7" : "sort_order","8":"template_suffix","9":"published_scope"};
        var sheet =getSheetByName('collections');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'collections' found in spreadsheet.");
        var data = sheet.getDataRange().getValues();
        var  found_row_in_sheet=false;
        for (var i = 1; i <= data.length; i++) {
            current_sheet_row = data[i];
            if (typeof current_sheet_row !=='undefined' && current_sheet_row[0] == post_data.id) {
                found_row_in_sheet=true;
                //exclude header row
                var new_row = i +1;

                // if delete webhook called
                if(post_data.request_type=="collections/delete"){
                    sheet.deleteRow(new_row);
                    return ContentService.createTextOutput("Collection row deleted from google sheet.");
                }

                // if update webhook triggered
                for(var key in indexed_sheet_fields){
                    let value=indexed_sheet_fields[key];
                    sheet.getRange(new_row, key).setValue(post_data[value]);

                }


                return ContentService.createTextOutput("Collection update added successfully.");

            }
        }


        if(!found_row_in_sheet)return ContentService.createTextOutput("No record found in collections sheet.");



    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }

}

function add_cart_in_sheet(post_data) {
    try{
        const indexed_sheet_fields = {"1" : "id", "2" : "token", "13" : "note", "14" : "updated_at", "15" : "created_at"};
        const line_item_sheet_fields={"3":"quantity","4":"title","5":"discounted_price","6":"line_price","7":"original_line_price","8":"original_price","9":"price","10":"product_id","11":"sku","12":"total_discount"};

        var sheet =getSheetByName('cart');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'cart' found in spreadsheet.");
        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        sheet.insertRowAfter(lastRow);

        for(var key in indexed_sheet_fields){
            let value=indexed_sheet_fields[key];
            sheet.getRange(new_row, key).setValue(post_data[value]);
        }

        //loop line items
        var line_items=post_data.line_items;

        if(line_items && line_items.length){

            for(var opt in line_items){
                if(opt>0){
                    sheet.insertRowAfter(new_row);
                    new_row++;
                    sheet.getRange(new_row, 1).setValue(post_data.id);
                    sheet.getRange(new_row, 2).setValue(post_data.token);
                }

                for(var key in line_item_sheet_fields){
                    let line_item_key_value=line_item_sheet_fields[key];
                    sheet.getRange(new_row, key).setValue(line_items[opt][line_item_key_value]);
                }
            }

        }
        return ContentService.createTextOutput("Cart row added successfully.");



    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }

}



function update_cart_in_sheet(post_data) {
    try{
        const indexed_sheet_fields = {"1" : "id", "2" : "token", "13" : "note", "14" : "updated_at", "15" : "created_at"};
        const line_item_sheet_fields={"3":"quantity","4":"title","5":"discounted_price","6":"line_price","7":"original_line_price","8":"original_price","9":"price","10":"product_id","11":"sku","12":"total_discount"};
        var sheet =getSheetByName('cart');
        if(!sheet)return ContentService.createTextOutput("No sheet having name 'cart' found in spreadsheet.");
        var found_row_in_sheet=false;
        var data = sheet.getDataRange().getValues();
        var first_instance = false;
        var new_row = 0;
        for (var i = 1; i <= data.length; i++) {
            current_sheet_row = data[i];
            if (typeof current_sheet_row !=='undefined' && current_sheet_row[0] == post_data.id) {
                found_row_in_sheet=true;
                if (first_instance===false) {
                    //exclude header row
                    new_row = i +1;
                    first_instance = true;

                    for(var key in indexed_sheet_fields){
                        let value=indexed_sheet_fields[key];
                        sheet.getRange(new_row, key).setValue(post_data[value]);
                    }

                    //loop line items
                    var line_items=post_data.line_items;

                    if(line_items && line_items.length){

                        for(var opt in line_items){
                            if(opt>0){
                                sheet.insertRowAfter(new_row);
                                new_row++;
                                sheet.getRange(new_row, 1).setValue(post_data.id);
                                sheet.getRange(new_row, 2).setValue(post_data.token);
                            }

                            for(var key in line_item_sheet_fields){
                                let line_item_key_value=line_item_sheet_fields[key];
                                sheet.getRange(new_row, key).setValue(line_items[opt][line_item_key_value]);
                            }
                        }

                    }
                    new_row++;

                }
                else
                {
                    //delete the existing rows of same order after updating first row and adding new rows under it for more than one line items
                    sheet.deleteRow(new_row);
                }


            }else{
                //row numbers
                new_row++;
            }


        }

        if(!found_row_in_sheet)return ContentService.createTextOutput("No record found in cart sheet.");
        return ContentService.createTextOutput("cart updated successfully.");


    } catch(err) {
        return ContentService.createTextOutput(err.message);
    }

}
