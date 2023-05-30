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
function doPost(e) {
    try {

        var   post_data= JSON.parse(e.postData.contents);
        switch (post_data.request_type) {
            case "orders/create":
                return   add_order_rows_in_sheet(post_data);
                break;
            case "orders/deleted":
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
            case "customers/enable":
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
            default:
                return ContentService.createTextOutput("No function found for this webhook in sheet apps script .");
                break;

        }
    }
    catch(err) {
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
