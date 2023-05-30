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
            default:
                break;

        }
    }
    catch(err) {
        return ContentService.createTextOutput(err.message);
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

                            // if delete webhook is called ,loop will skip to next index without updating rows
                            if(post_data.request_type=="products/delete"){
                                sheet.deleteRow(new_row);
                                if(i< data.length)
                                    continue;
                                else
                                    return ContentService.createTextOutput("Product removed from google sheet.");
                            }


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


