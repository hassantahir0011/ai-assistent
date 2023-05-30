function make_multiple_input_value_array(object_id){
    let selected_values=$('#'+object_id).select2('data');
    let text_array=[];
    $.each(selected_values,function(index,value){
        let obj={
            "id":value.id,
            "text":value.text
        };
        text_array.push(obj);
    });
    return text_array;
}
function callSwalWithHTML(status,html_msg,icon) {
    const wrapper = document.createElement('div');
    wrapper.innerHTML = html_msg;
    swal({
        title: status+"!",
        content: wrapper,
        icon: icon
    });
}
function showUpgradePlanImportExport() {
    $('#alert-wrap-div').show();
    $("html, body").animate({ scrollTop: 0 }, "slow");
}
function toggle_conditions_warning_msg(selectedOptions) {
    let page_found=false;
    selectedOptions.each(function () {
        if ($(this).val() == 'checkout-page') {
            page_found=true;
            $('#conditions-warning-message').show()
        }
    });
    if (selectedOptions.length == 0 || page_found==false)
        $('#conditions-warning-message').hide();
}

function show_loading_img() {
    $("body").addClass('unavalable').css({"pointer-events": "none"});
    $(".designPage").hide();
    $(".overlay").show();
}

function hide_loading_img() {
    $("body").removeClass('unavalable').css({"pointer-events": "visible" });
    $(".designPage").show();
    $(".overlay").hide();
}

function make_cols(row) {
    var str = '';

    str += ' <div class="divTableCell">' + row.name + '</div> ';
    str += ' <div author-id="' + row.user_id + '" class="divTableCell snippet-author-name"><a href="javascript:"> ' + row.author_name + '</a></div> ';
    str += ' <div class="divTableCell">' + row.add_on + '</div> ';
    // str += ' <div class="divTableCell">'+row.edit_on+'</div> ';
    str += ' <div class="Polaris-ButtonGroup Polaris-ButtonGroup--segmented"> <div data-id="' + row.id + '"><i class="fa fa-thumbs-up snippet-thumbs-up' + row.id + '"></i> <br><span>(</span><span>' + row.snippet_like + '</span><span>)</span></div><div data-id="' + row.id + '"><i class="fa fa-thumbs-down snippet-thumbs-down' + row.id + '"></i> <br><span>(</span><span>' + row.snippet_unlike + '</span><span>)</span></div><div style="margin-left: 5px;" class="Polaris-ButtonGroup__Item"><a category_id="' + row.category_id + '" sub_category_id="' + row.sub_category_id + '" id="' + row.id + '" href="javascript:;" type="' + row.type + '" class="choose-snippet Polaris-Button">Select</a><a  id="' + row.id + '" href="javascript:;" " class="open-snippet-detail Polaris-Button">View</a></div></div></div> ';


    return str;
}

function RemoveTableRow(TableId, Row_selector) {
    var selected_table = $('#' + TableId).DataTable();
    Row_selector.fadeOut(1000, function () {
        selected_table
            .row($(Row_selector))
            .remove()
            .draw();
    });

}
