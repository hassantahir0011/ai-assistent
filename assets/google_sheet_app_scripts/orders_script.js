function update_product_in_sheet(post_data) {
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
        const variants_sheet_fields = {
            "29": "id",
            "30": "title",
            "31": "quantity",
            "32": "sku",
            "33": "variant_title",
            "34": "vendor",
            "35": "fulfillment_service",
            "36": "requires_shipping",
            "37": "taxable",
            "38": "gift_card",
            "38": "variant_inventory_management",
            "39": "grams",
            "40": "price",
            "41": "total_discount",
            "42": "fulfillment_status"
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
                    var column_no=1;
                    for (var key in indexed_sheet_fields) {
                        let value = indexed_sheet_fields[key];
                        column_no=key;
                        if(value)
                        sheet.getRange(new_row, column_no).setValue(post_data[value]);
                    }

                    // loop options

                    var options = post_data.options;

                    if (options && options.length) {
                        let key_index = 8;
                        for (var opt in options) {
                            sheet.getRange(new_row, key_index).setValue(options[opt].name);
                            key_index = key_index + 2;
                        }

                    }
                    //loop variants
                    var variants = post_data.variants;

                    if (variants && variants.length) {

                        for (var opt in variants) {

                            if (opt > 0) {
                                sheet.insertRowAfter(new_row);
                                new_row++;
                                sheet.getRange(new_row, 1).setValue(post_data.handle);
                            }

                            for (var key in variants_sheet_fields) {
                                let variant_key_value = variants_sheet_fields[key];


                                if (variant_key_value == 'variant_image') {
                                    var p_images = post_data.images;
                                    for (var img_key in p_images) {

                                        let current_variant_id = variants[opt].id;
                                        let variant_ids = p_images[img_key].variant_ids || [];
                                        // ui.alert(current_variant_id);

                                        //Logger.log(variant_ids[1]+'==');return;

                                        if (variant_ids.indexOf(current_variant_id)) {

                                            sheet.getRange(new_row, key).setValue(p_images[img_key].src);
                                        }

                                    }
                                } else {
                                    sheet.getRange(new_row, key).setValue(variants[opt][variant_key_value]);
                                }


                            }


                        }


                    }

                    new_row++;

                }
                else {

                    //delete the existing rows of same product after updating first row and adding new rows under it for more than one variants

                    sheet.deleteRow(new_row);
                    // return ContentService.createTextOutput(new_row);
                }


            } else {
                //row numbers
                new_row++;
            }


        }


        if (!found_row_in_sheet) return ContentService.createTextOutput("No record found in products sheet.");
        return ContentService.createTextOutput("product updated successfully.");


    } catch (err) {
        return ContentService.createTextOutput(err.message);
    }

}