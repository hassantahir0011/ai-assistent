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
            "10": "location_id",
            "12": "email",
            "24": "tracking_number",
            "25": "tracking_url",
            "26": "receipt",
            "27": "name",
            "28": "destination"
        };
        const line_items_sheet_fields = {
            "29": "id",
            "30": "title",
            "31": "quantity",
            "32": "sku",
            "33": "line_item_title",
            "34": "vendor",
            "35": "fulfillment_service",
            "36": "requires_shipping",
            "37": "taxable",
            "38": "gift_card",
            "39": "line_item_inventory_management",
            "40": "grams",
            "41": "price",
            "42": "total_discount",
            "43": "fulfillment_status"
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

                    if (line_items && line_items.length) {

                        for (var opt in line_items) {

                            if (opt > 0) {
                                sheet.insertRowAfter(new_row);
                                new_row++;
                                sheet.getRange(new_row, 1).setValue(post_data.id);
                                sheet.getRange(new_row, 1).setValue(post_data.order_id);
                            }
                            for (var line_item_array_key in line_items_sheet_fields) {
                                let line_item_key_value = line_items_sheet_fields[key];
                                sheet.getRange(new_row, key).setValue(line_items[line_item_array_key][line_item_key_value]);
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
            "10": "location_id",
            "12": "email",
            "24": "tracking_number",
            "25": "tracking_url",
            "26": "receipt",
            "27": "name",
            "28": "destination"
        };
        const line_items_sheet_fields = {
            "29": "id",
            "30": "title",
            "31": "quantity",
            "32": "sku",
            "33": "line_item_title",
            "34": "vendor",
            "35": "fulfillment_service",
            "36": "requires_shipping",
            "37": "taxable",
            "38": "gift_card",
            "39": "line_item_inventory_management",
            "40": "grams",
            "41": "price",
            "42": "total_discount",
            "43": "fulfillment_status"
        };
        var sheet = getSheetByName('fulfillments');
        if (!sheet) return ContentService.createTextOutput("No sheet having name 'fulfillments' found in spreadsheet.");


        var lastRow = Math.max(sheet.getLastRow(), 1);
        var new_row = lastRow + 1;
        sheet.insertRowAfter(lastRow);
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
                    sheet.getRange(new_row, 1).setValue(post_data.order_id);
                }
                for (var line_item_array_key in line_items_sheet_fields) {
                    let line_item_key_value = line_items_sheet_fields[key];
                    sheet.getRange(new_row, key).setValue(line_items[line_item_array_key][line_item_key_value]);
                }
            }
        }

        return ContentService.createTextOutput("Fullfillment rows added successfully.");
    } catch (err) {
        return ContentService.createTextOutput(err.message);
    }

}