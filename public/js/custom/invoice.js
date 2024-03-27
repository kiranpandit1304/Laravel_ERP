function appendTopColumns(e) {

    var LineHtml = [];
    LineHtml += ' <li class="ui-state-default show top_rwo_' + tkey + '" key="' + tkey + '">';
    LineHtml += '                                         <input type="text" class="invoice_custome_filed_key" name="col_key[' + tkey + ']" id="" value="" placeholder="Fields name">';

    LineHtml += '                                     <div>';
    LineHtml += '                                         <input type="text" class="invoice_custome_filed_value" name="col_value[' + tkey + ']" id="" value="" placeholder="Value">';
    LineHtml += '                                     </div>';
    LineHtml += '                                     <a href="javascript:void(0)" onclick="removeTopColumn(this)" data-id="' + tkey + '" class="close">';
    LineHtml += '                                         <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#006AFF" xmlns="http://www.w3.org/2000/svg">';
    LineHtml += '                                             <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z" ></path>';
    LineHtml += '                                             <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z" ></path>';
    LineHtml += '                                         </svg>';
    LineHtml += '                                     </a>';
    LineHtml += '                                 </li>';
    $(".append_top_column").find(".last_top_li").prev().after(LineHtml);
    tkey++;
}

function removeTopColumn(event) {
    var rid = $(event).attr("data-id");
    $(".top_rwo_" + rid).remove();
    tkey--;

}

function addMoreExtraChanges(e) {

    var LineHtml = [];
    LineHtml+='  <div class="ch-col withclose hide_addcharges_item extra_changes_div show top_chrges_rwo_' + extrakey + '" key="' + extrakey +'">';
    LineHtml+=' <span>Extra Charges</span>';
    LineHtml+='<span class="withIn">';
    LineHtml+='    <input type="text"  name="changes_value[' + extrakey + ']" class="dic_out extra_changes" value="">';
    LineHtml+='    <div class="select_full_se">';
    LineHtml+='        <select class="js-states form-control nosearch extra_changes_unit common_currency_sel_d extra_charges_type">';
    LineHtml+='           <option value="rupees" data-id="₹" >₹</option>';
    LineHtml+='           <option value="%" >%</option>';
    LineHtml+='       </select>';
    LineHtml+='   </div>';
    LineHtml+=' </span>';
    LineHtml+=' <button class="close_btn" type="button"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#733dd9" xmlns="http://www.w3.org/2000/svg">';
    LineHtml+='        <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z"></path>';
    LineHtml+='        <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z"></path>';
    LineHtml+='    </svg></button>';
    LineHtml+='</div>';

    $(".extra_changes_div").next().append(LineHtml);
    extrakey++;
}

function removeExtraChanges(event) {
    var rid = $(event).attr("data-id");
    $(".top_chrges_rwo_" + rid).remove();
    tkey--;

}



var rwkey = 0;

function addBelowItemRow(event) {
    var rowBelowItemHtml = createItemHtml(rwkey);
    $(event).parent().parent().after(rowBelowItemHtml);
    var gid = $(".item_row_" + rwkey).prevAll().closest('.group_rw_d').last().attr("data-key")
    $(".item_row_" + rwkey).attr("data-group-id", gid);
    $(".item_inp_" + rwkey).attr("data-group-id", gid);
    $(".item_inp_" + rwkey).attr("data-group-name", $("group_nm_" + gid).val());

    showCommonRwInAppendColumn();

    initializeEditor('editor1' + rwkey);
    ImgUpload();
    initializeSuggestionInput();
    rwkey++;

}

function createItemHtml(rwkey) {
    var rid = parseInt(rwkey) + 1;

    var rowHtml = [];
    rowHtml += ' <div class="tbody_column inv ui-state-default itm_rw_d visible item_row_' + rwkey + '" >';
    rowHtml += '<span cols="22" class="td-u six-s">';
    rowHtml += '<span class="label">Item</span>';
    rowHtml += '    <div class="css-rxk9pl">';
    rowHtml += '<div class="searchInput">';
    rowHtml += '                                               <input class="grp_item item_inp_' + rwkey + '"  type="text" placeholder="item">';
    rowHtml += '                                               <div class="resultBox">';
    rowHtml += '                                               </div>';
    rowHtml += '                                               </div>';
    rowHtml += '                                           </div>';
    rowHtml += ' </span>';
    rowHtml += ' <span cols="22" class="td-u two-s">';
    rowHtml += '     <span class="label">HSN/SAC</span>';
    rowHtml += '    <div class="css-rxk9pl">';
    rowHtml += '        <input type="text" name="hsn[]" class="hsn_d hsn_' + rid + '"  placeholder="#" />';
    rowHtml += '   </div>';
    rowHtml += '</span>';
    rowHtml += ' <span cols="22" class="td-u two-s comn_rate_col">';
    rowHtml += '    <span class="label">GST Rate</span>';
    rowHtml += '   <div class="css-rxk9pl">';
    rowHtml += '      <input type="text" name="gst_rate[]" class="gst_rate_d  gst_rate_' + rid + '" data-index-key="' + rid + '"  placeholder="" />';
    rowHtml += '  </div>';
    rowHtml += ' </span>';
    rowHtml += '<span cols="22" class="td-u two-s">';
    rowHtml += ' <span class="label">Quantity</span>';
    rowHtml += ' <div class="css-rxk9pl">';
    rowHtml += '     <input type="text" name="quantity[]" class="qty_d budle_quantity_' + rid + '" data-index-key="' + rid + '" placeholder="" value="1" />';
    rowHtml += '  </div>';
    rowHtml += ' </span>';
    rowHtml += ' <span cols="22" class="td-u two-s">';
    rowHtml += '   <span class="label">Rate</span>';
    rowHtml += '   <div class="css-rxk9pl">';
    rowHtml += '      <input type="text" name="rate[]" class="rate_d rate_' + rid + '"  data-index-key="' + rid + '" placeholder="" />';
    rowHtml += '  </div>';
    rowHtml += '</span>';
    rowHtml += '<span cols="22" class="td-u two-s hide-d inline_disc_td discount_td_' + rid + '" data-key="' + rid + '">';
    rowHtml += '                    <span class="label">Discount</span>';
    rowHtml += '                    <div class="css-rxk9pl">';
    rowHtml += '                        <input type="text" disabled name="inline_dics[]" class="inline_disc_d inpt_inline_disc_' + rid + '" placeholder="" />';
    rowHtml += '                    </div>';
    rowHtml += '                </span>';
    rowHtml += '<span cols="22" class="td-u two-s">';
    rowHtml += ' <span class="label">Amount</span>';
    rowHtml += ' <div class="css-rxk9pl">';
    rowHtml += '     <input type="text" name="amount[]"  class="amt_d amount_' + rid + '" data-key="' + rid + '" placeholder="" />';
    rowHtml += '  </div>';
    rowHtml += '</span>';
    rowHtml += '<span cols="22" class="td-u two-s c_s_gst_td cgst_td hide-d">';
    rowHtml += '  <span class="label">CGST</span>';
    rowHtml += '  <div class="css-rxk9pl">';
    rowHtml += '      <input type="text" name="cgst[]" disabled class="cgst_d cgst_' + rid + '" data-key="' + rid + '" placeholder="" />';
    rowHtml += '   </div>';
    rowHtml += ' </span>';
    rowHtml += ' <span cols="22" class="td-u two-s c_s_gst_td sgst_td hide-d">';
    rowHtml += '  <span class="label">SGST</span>';
    rowHtml += '  <div class="css-rxk9pl">';
    rowHtml += '      <input type="text" name="sgst[]" disabled class="sgst_d sgst_' + rid + '" data-key="' + rid + '" placeholder="" />';
    rowHtml += '   </div>';
    rowHtml += '</span>';
    rowHtml += '<span cols="22" class="td-u two-s igst_td comn_rate_col">';
    rowHtml += ' <span class="label">IGST</span>';
    rowHtml += ' <div class="css-rxk9pl">';
    rowHtml += '      <input type="text" name="igst[]" disabled class="igst_d igst_' + rid + '" data-key="' + rid + '" placeholder="" />';
    rowHtml += '  </div>';
    rowHtml += '</span>';
    rowHtml += '<span cols="22" class="td-u two-s">';
    rowHtml += '<span class="label">Total</span>';
    rowHtml += '    <div class="css-rxk9pl">';
    rowHtml += '        <input type="text"  name="total[]" disabled class="total_d total_' + rid + '" data-key="' + rid + '" placeholder="" />';
    rowHtml += '     </div>';
    rowHtml += ' </span>';
    rowHtml += '<span class="close_icon">';
    rowHtml += '   <button aria-label="Remove Item" type="button" class="close_column"  onclick="removeItemRow(this)" data-id="' + rwkey + '" >';
    rowHtml += '       <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>';
    rowHtml += '    </button>';
    rowHtml += '</span>';
    rowHtml += ' <div cols="15" class="hide_discount  inline_disc_div_' + rid + '" data-id="' + rid + '">';
    rowHtml += '                                           <div class="ch-col withclose hide_discount_item">';
    rowHtml += '                                               <span>Discount</span>';
    rowHtml += '                                              <span class="withIn">';
    rowHtml += '                                                  <input type="text" class="dic_out inline_disc inlineDiscVal_' + rid + ' "   data-key="' + rid + '">';
    rowHtml += '                                                  <div class="select_full_se">';
    rowHtml += '                                                     <select class="js-states form-control inline_disc_type nosearch common_currency_sel_d inlineDiscType_' + rid + ' "  data-key="' + rid + '" >';
    rowHtml += '                                                         <option value="rupees" data-id="₹" >₹</option>';
    rowHtml += '                                                         <option value="%">%</option>';
    rowHtml += '                                                     </select>';
    rowHtml += '                                                 </div>';
    rowHtml += '                                            </span>';
    rowHtml += '                                            <button class="save_btn apply_inline_discount"  data-key="' + rid + '" type="button">';
    rowHtml += '                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16"><path fill="none" stroke="currentColor" stroke-linecap="round" color="#5bbe2c" stroke-linejoin="round" stroke-width="1.5" d="m2.75 8.75l3.5 3.5l7-7.5"/></svg>';
    rowHtml += '                                            </button>';
    rowHtml += '                                            <button class="close_btn remove_inline_discount"  data-key="' + rid + '" type="button">';
    rowHtml += '                                                 <svg width="24" height="24"';
    rowHtml += '                                                     viewBox="0 0 24 24" fill="currentColor" color="#006AFF"';
    rowHtml += '                                                    xmlns="http://www.w3.org/2000/svg">';
    rowHtml += '                                                    <path';
    rowHtml += '                                                       d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z">';
    rowHtml += '                                                   </path>';
    rowHtml += '                                                   <path';
    rowHtml += '                                                       d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z">';
    rowHtml += '                                                   </path>';
    rowHtml += '                                               </svg>';
    rowHtml += '                                           </button>';
    rowHtml += '                                       </div>';
    rowHtml += '                                   </div>';
    rowHtml += '                                      <span cols="5" class="td-u five-s" data-id="' + rid + '">';
    rowHtml += '                                         <button aria-label="Add Edit Discount" title=""';
    rowHtml += '                                            class="add_discount add_inline_discount add_inlineDisc_' + rid + ' " data-key="' + rid + '" type="button">';
    rowHtml += '                                            <iconify-icon icon="iconamoon:discount-light"></iconify-icon>';
    rowHtml += '                                            Add/Edit Discount';
    rowHtml += '                                       </button>';
    rowHtml += '                                   </span>';
    rowHtml += ' <div cols="15" class="hide_option_descandimage2 editrImage_' + rwkey + '"> ';
    rowHtml += '    <div id="editor1' + rwkey + '"></div>';
    rowHtml += ' </div>';
    rowHtml += '<span cols="4" class="td-u five-s">';
    rowHtml += ' <button aria-label="Add Description" class="openDescription2" data-id="' + rwkey + '" type="button">';
    rowHtml += '    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">';
    rowHtml += '      <g id="plus-square-outline" transform="translate(-.266 .217)">';
    rowHtml += '         <g id="Rectangle_1143" fill="rgba(255,255,255,0)" stroke="#006AFF" transform="translate(.266 -.217)">';
    rowHtml += '            <rect width="16" height="16" stroke="none" rx="3"></rect>';
    rowHtml += '            <rect width="15" height="15" x=".5" y=".5" fill="none" rx="2.5"></rect>';
    rowHtml += '        </g>';
    rowHtml += '        <g id="Group_588" transform="translate(5.264 4.783)">';
    rowHtml += '             <path id="Line_109" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="translate(3)"></path>';
    rowHtml += '              <path id="Line_110" d="M0 0L0 6" stroke="#006AFF" fill="none" stroke-linecap="round" transform="rotate(90 1.5 4.5)"></path>';
    rowHtml += '          </g>';
    rowHtml += '       </g>';
    rowHtml += '   </svg>';
    rowHtml += '    Add Description';
    rowHtml += '  </button>';
    rowHtml += '</span>';
    rowHtml += ' <div cols="20" class="hide_option_imageOnly two_op shw_uodr_' + rwkey + '">';
    rowHtml += '   <div class="upload__box">';
    rowHtml += '      <div class="upload__img-wrap"></div>';
    rowHtml += '     <div class="upload__btn-box">';
    rowHtml += '         <label class="upload__btn">';
    rowHtml += '            <p><iconify-icon icon="ion:add"></iconify-icon> Upload Thumbnail</p>';
    rowHtml += '           <input type="file" multiple=""  data-max_length="20" class="upload__inputfile invoice_product_image">';
    rowHtml += '        </label>';
    rowHtml += '    </div>';
    rowHtml += '  </div>';
    rowHtml += ' </div>';
    rowHtml += ' <span cols="5" class="td-u five-s">';
    rowHtml += '<button aria-label="Add Thumbnail" class="openthumbnails opetwo" data-id="' + rwkey + '" type="button">';
    rowHtml += ' <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16.072 16">';
    rowHtml += '  <g id="image" transform="translate(0.495 0.495)">';
    rowHtml += '      <rect id="Rectangle_1144" data-name="Rectangle 1144" width="16" height="16" transform="translate(-0.495 -0.495)" fill="none" opacity="0"></rect>';
    rowHtml += '      <g';
    rowHtml += '          id="Rectangle_771"';
    rowHtml += '          data-name="Rectangle 771"';
    rowHtml += '          transform="translate(-0.495 -0.495)"';
    rowHtml += '          fill="none"';
    rowHtml += '          stroke="#006AFF"';
    rowHtml += '          stroke-linecap="round"';
    rowHtml += '          stroke-linejoin="round"';
    rowHtml += '          stroke-width="1"';
    rowHtml += '      >';
    rowHtml += '          <rect width="16" height="16" rx="2" stroke="none"></rect>';
    rowHtml += '          <rect x="0.5" y="0.5" width="15" height="15" rx="1.5" fill="none"></rect>';
    rowHtml += '      </g>';
    rowHtml += '      <circle';
    rowHtml += '          id="Ellipse_275"';
    rowHtml += '          data-name="Ellipse 275"';
    rowHtml += '          cx="1.5"';
    rowHtml += '          cy="1.5"';
    rowHtml += '          r="1.5"';
    rowHtml += '          transform="translate(3.505 3.505)"';
    rowHtml += '          fill="none"';
    rowHtml += '          stroke="#006AFF"';
    rowHtml += '          stroke-linecap="round"';
    rowHtml += '          stroke-linejoin="round"';
    rowHtml += '          stroke-width="1"';
    rowHtml += '      ></circle>';
    rowHtml += '      <path';
    rowHtml += '          id="Path_1674"';
    rowHtml += '          data-name="Path 1674"';
    rowHtml += '          d="M19.587,14.614,14.973,10,5.426,19.6"';
    rowHtml += '          transform="translate(-4.718 -4.902)"';
    rowHtml += '          fill="none"';
    rowHtml += '          stroke="#006AFF"';
    rowHtml += '          stroke-linecap="round"';
    rowHtml += '          stroke-linejoin="round"';
    rowHtml += '          stroke-width="1"';
    rowHtml += '      ></path>';
    rowHtml += '  </g>';
    rowHtml += '</svg>';
    rowHtml += 'Add Thumbnail';
    rowHtml += '</button>';
    rowHtml += ' </span>   ';

    rowHtml += '<span cols="22" class="td-u tt2-s">';
    rowHtml += '    <button aria-label="Add new item" onclick="addBelowItemRow(this)" data-id="' + rwkey + '"  title="Add new item below this item" class="" type="button">';
    rowHtml += '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 20 20" stroke-width="1" fill="none" stroke="currentColor">';
    rowHtml += '  <path';
    rowHtml += '      d="M1 8.5V10.2917C1 10.5678 1.22386 10.7917 1.5 10.7917H4.26667M4.26667 10.7917L3.05333 9.325M4.26667 10.7917L3.05333 12.1667M1.5 6H14.5C14.7761 6 15 5.77614 15 5.5V3.5C15 3.22386 14.7761 3 14.5 3H1.5C1.22386 3 1 3.22386 1 3.5V5.5C1 5.77614 1.22386 6 1.5 6ZM7.50057 11.9999H14.5006C14.7767 11.9999 15.0006 11.7761 15.0006 11.4999V9.49991C15.0006 9.22377 14.7767 8.99991 14.5006 8.99991H7.50057C7.22443 8.99991 7.00057 9.22377 7.00057 9.49991V11.4999C7.00057 11.7761 7.22443 11.9999 7.50057 11.9999Z"';
    rowHtml += '      stroke="#006AFF"';
    rowHtml += '      stroke-linecap="round"';
    rowHtml += '      stroke-linejoin="round"';
    rowHtml += '  ></path>';
    rowHtml += '</svg>';
    rowHtml += 'Insert an item below';
    rowHtml += '</button>';
    rowHtml += '</span>';
    rowHtml += '<span cols="22" class="td-u tt3-s">';
    rowHtml += '    <button shape="circle" aria-label="Move Down" title="Move Down" class="" type="button">';
    rowHtml += '        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">';
    rowHtml += '  <path';
    rowHtml += '      d="M99.4 284.9l134 138.1c5.8 6 13.7 9 22.4 9h.4c8.7 0 16.6-3 22.4-9l134-138.1c12.5-12 12.5-31.3 0-43.2-12.5-11.9-32.7-11.9-45.2 0l-79.4 83v-214c0-16.9-14.3-30.6-32-30.6-18 0-32 13.7-32 30.6v214l-79.4-83c-12.5-11.9-32.7-11.9-45.2 0s-12.5 31.2 0 43.2z"';
    rowHtml += '  ></path>';
    rowHtml += '</svg>';
    rowHtml += ' </button>';
    rowHtml += ' </span>';
    rowHtml += '</div>';

    return rowHtml;
}
function appendItemRow_old(e) {
    var rowItemHtml = createItemHtml(rwkey);

    $(".tble_append_d").find(".bt_footer").prev().after(rowItemHtml);

    showCommonRwInAppendColumn();
    var gid = $(".item_row_" + rwkey).prevAll().closest('.group_rw_d').last().attr("data-key")
    $(".item_row_" + rwkey).attr("data-group-id", gid);
    $(".item_inp_" + rwkey).attr("data-group-id", gid);
    $(".item_inp_" + rwkey).attr("data-group-name", $(".group_nm_" + gid).val());



    initializeEditor('editor1' + rwkey);
    ImgUpload();
    initializeSuggestionInput();
    rwkey++;
}

function showCommonRwInAppendColumn() {
    var is_show_disc = $(".inpt_inline_disc_0").attr("data-show-disc");
    if (is_show_disc == 'yes') {
        $(".inline_disc_td").removeClass("hide-d");
    }

    var is_show_cgst = $("input[type='radio'][name='final_igst']:checked").val();
    if (is_show_cgst == 'CGST') {
        $(".c_s_gst_td").removeClass("hide-d");
        $(".c_s_gst_th ").removeClass("hide-d");

        $(".igst_th").addClass("hide-d");
        $(".igst_td").addClass("hide-d");
    }

}

function removeItemRow(event) {
    rwkey--;
    var rid = $(event).attr("data-id");
    $(".item_row_" + rid).remove();
    calculateRowValues(rid);
    // calculateInvoiceTotal();
}


$("body").on("click", "button.openDescription2", function () {
    var rid = $(this).attr("data-id");
    $('.editrImage_' + rid).addClass('show');
    $(this).next().removeClass('hide-d');
    $(this).addClass('hide-d');
});

$("body").on("click", "button.closeDescription", function () {
    var rid = $(this).attr("data-id");
    $('.editrImage_' + rid).removeClass('show');
    $(this).addClass('hide-d');
    $(this).prev().removeClass('hide-d');
    $(this).parent().parent().find('.ProseMirror').children().text('')
    $('.openDescription2').show();
    $(this).hide();
});

$("body").on("click", "button.opetwo", function () {
    var rid = $(this).attr("data-id");
    $('.shw_uodr_' + rid).addClass('show');
    $('.closeDescription').addClass('hide-d');
    $(this).hide();
});
$("body").on("click", "button.group_img_tmnail", function () {
    var rid = $(this).attr("data-id");
    $('.shw_group_odr_' + rid).addClass('show');
    $(this).hide();
});


function manageGstRates(type='') {
    var itemGST = $(".gst_rate_d");

    for (var k = 0; k <= itemGST.length; k++) {
        if (
            typeof itemGST[k]?.value != undefined &&
            itemGST[k]?.value != "" &&
            itemGST[k]?.value != null &&
            !isNaN(itemGST[k]?.value)
        ) {
            var rate = $(".budle_quantity_" + k).attr("data-gst-rate");
            $(".gst_rate_" + k).val(rate);
            calculateRowValues(k);
        }
    }
}


$("body").on("click", ".i_c_s_gst_radio", function () {
    var chk_val = $(this).val();

    if (chk_val == 'CGST') {

        var alreadyExists = -1;
        var searchCurrentId = "CGST";
        $.each(defaultJson, function (index, obj) {
            if (obj.unique_key === searchCurrentId) {
                alreadyExists = index;
                return false; // Exit the loop once the object is found
            }
        });

        if (alreadyExists !== -1) {
            return false;
        }

        removeIgstFromArray();
        addCgstInArray();
        CGSTShowed = true;
        $(".c_s_gst_th").removeClass("hide-d");
        $(".c_s_gst_td").removeClass("hide-d");

        $(".igst_th").addClass("hide-d");
        $(".igst_td").addClass("hide-d");

    } else {

        var alreadyExists = -1;
        var searchCurrentId = "IGST";

        $(".c_s_gst_th").addClass("hide-d");
        $(".c_s_gst_td").addClass("hide-d");
        $(".igst_th").removeClass("hide-d");
        $(".igst_td").removeClass("hide-d");

        CGSTShowed = false;

        $.each(defaultJson, function (index, obj) {
            if (obj.unique_key === searchCurrentId) {
                alreadyExists = index;
                return false; // Exit the loop once the object is found
            }
        });

        if (alreadyExists !== -1) {
            return false;
        }

        removeCgstFromArray();
        removeSgstFromArray();
        addIgstInArray();
    }

    loadDefaultColumns();
    listColumnsInPopUp();
    loadColumnOnPage();
    reLoadColumnFieldsOnPage();

    $('.items_view_edit_table').each(function (i, obj) {
        var index = $(obj).attr("data-items_view_edit_table");
        var divList = $("div").find("[data-items_view_edit_table='" + index + "'] .listing-item");
        divList.sort(function (a, b) {
            return $(a).data("listing-item") - $(b).data("listing-item")
        });

        $("div").find("[data-items_view_edit_table='" + index + "']").html(divList);
    });

    ImgUpload();
    $("#editcolumns").modal("hide");

    manageGstRates(chk_val);

});

function removeGstRateFromArray() {
    var searchedIndex = -1;
    var searchId = "GST_Rate";

    $.each(defaultJson, function (index, obj) {
        if (obj.unique_key === searchId) {
            searchedIndex = index;
            return false; // Exit the loop once the object is found
        }
    });

    if (searchedIndex !== -1) {
        defaultJson.splice(searchedIndex, 1);
        console.log(defaultJson);
        removedFields.push("GST_Rate");
    }
}


function removeIgstFromArray() {
    var searchedIndex = -1;
    var searchId = "IGST";

    $.each(defaultJson, function (index, obj) {
        if (obj.unique_key === searchId) {
            searchedIndex = index;
            return false; // Exit the loop once the object is found
        }
    });

    if (searchedIndex !== -1) {
        defaultJson.splice(searchedIndex, 1);
        removedFields.push("IGST");
    }
}

function removeCgstFromArray() {
    var searchedIndex = -1;
    var searchId = "CGST";

    $.each(defaultJson, function (index, obj) {
        if (obj.unique_key === searchId) {
            searchedIndex = index;
            return false; // Exit the loop once the object is found
        }
    });

    if (searchedIndex !== -1) {
        defaultJson.splice(searchedIndex, 1);
        removedFields.push("CGST");
    }
}



function removeSgstFromArray() {
    var searchedIndex = -1;
    var searchId = "SGST";

    $.each(defaultJson, function (index, obj) {
        if (obj.unique_key === searchId) {
            searchedIndex = index;
            return false; // Exit the loop once the object is found
        }
    });

    if (searchedIndex !== -1) {
        defaultJson.splice(searchedIndex, 1);
        removedFields.push("SGST");
    }
}

function addCgstInArray() {
    var searchedIndex = -1;
    var searchId = "Amount";

    $.each(defaultJson, function (index, obj) {
        if (obj.unique_key === searchId) {
            searchedIndex = index;
            return false; // Exit the loop once the object is found
        }
    });

    if (searchedIndex !== -1) {
        defaultJson.splice(searchedIndex + 1, 0, sgstJson);
        defaultJson.splice(searchedIndex + 1, 0, cgstJson);
    }
}

function addIgstInArray() {
    var searchedIndex = -1;
    var searchId = "Amount";

    $.each(defaultJson, function (index, obj) {
        if (obj.unique_key === searchId) {
            searchedIndex = index;
            return false; // Exit the loop once the object is found
        }
    });

    if (searchedIndex !== -1) {
        defaultJson.splice(searchedIndex + 1, 0, igstJson);
    }
}

function addGstRateInArray() {
    var searchedIndex = -1;
    var searchId = "HSN_SAC";

    $.each(defaultJson, function (index, obj) {
        if (obj.unique_key === searchId) {
            searchedIndex = index;
            return false; // Exit the loop once the object is found
        }
    });

    if (searchedIndex !== -1) {
        defaultJson.splice(searchedIndex + 1, 0, gstRatetJson);
    }
}

function loadtableAfterColumnsChange(){
    // loadDefaultColumns();
    listColumnsInPopUp();
    loadColumnOnPage();
    reLoadColumnFieldsOnPage();

    $('.items_view_edit_table').each(function (i, obj) {
        var index = $(obj).attr("data-items_view_edit_table");
        var divList = $("div").find("[data-items_view_edit_table='" + index + "'] .listing-item");
        divList.sort(function (a, b) {
            return $(a).data("listing-item") - $(b).data("listing-item")
        });

        $("div").find("[data-items_view_edit_table='" + index + "']").html(divList);
    });

    ImgUpload();
    $("#editcolumns").modal("hide");

    manageGstRates();
}

var gkey = 0;
// $("body").on("click", ".appendItemGroup", function() {
function appendItemGroup(e) {

    var totalMainDivs = $(".loadColumnFieldsOnPage").length;
    gkey = totalMainDivs;

    var groupHtml = [];

    groupHtml += '<div class="tbody_column group ui-state-default loadColumnFieldsOnPage group_rw_d group_row_' + totalMainDivs + '" data-key="' + gkey + '" data-main_listing_index="' + totalMainDivs + '">';
    groupHtml += '<span cols="22" class="td-u six-s group listing-item">';
    groupHtml += '  <span class="label">Item</span>';
    groupHtml += '  <div class="css-rxk9pl">';
    groupHtml += '      <input type="text" class="group_name_d group_nm_' + gkey + '"  data-key="' + gkey + '" placeholder="Group name (Required)" />';
    groupHtml += '  </div>';
    groupHtml += ' </span>';
    groupHtml += ' <span class="close_icon listing-item">';
    groupHtml += '    <button aria-label="Remove Item" type="button" class="close_group"  onclick="removeItemGroup(this)" data-id="' + gkey + '">';
    groupHtml += '        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>';
    groupHtml += '    </button>';
    groupHtml += ' </span>';
    groupHtml += '  <div cols="20" class="hide_option_imageOnly listing-item shw_group_odr_' + gkey + '">';
    groupHtml += '  <div class="upload__box">';
    groupHtml += '      <div class="upload__img-wrap"></div>';
    groupHtml += '      <div class="upload__btn-box">';
    groupHtml += '         <label class="upload__btn">';
    groupHtml += '            <p><iconify-icon icon="ion:add"></iconify-icon> Upload Thumbnail</p>';
    groupHtml += '           <input type="file" multiple="" data-max_length="20" class="upload__inputfile invoice_group_image">';
    groupHtml += '       </label>';
    groupHtml += '     </div>';
    groupHtml += '  </div>';
    groupHtml += ' </div>';
    groupHtml += ' <span cols="5" class="td-u five-s listing-item">';
    groupHtml += '    <button aria-label="Add Thumbnail" class="group_img_tmnail" type="button"  data-id="' + gkey + '" >';
    groupHtml += '       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16.072 16">';
    groupHtml += '           <g id="image" transform="translate(0.495 0.495)">';
    groupHtml += '              <rect id="Rectangle_1144" data-name="Rectangle 1144" width="16" height="16" transform="translate(-0.495 -0.495)" fill="none" opacity="0"></rect>';
    groupHtml += '             <g';
    groupHtml += '                 id="Rectangle_771"';
    groupHtml += '                 data-name="Rectangle 771"';
    groupHtml += '                transform="translate(-0.495 -0.495)"';
    groupHtml += '                fill="none"';
    groupHtml += '                 stroke="#006AFF"';
    groupHtml += '                 stroke-linecap="round"';
    groupHtml += '                 stroke-linejoin="round"';
    groupHtml += '                 stroke-width="1"';
    groupHtml += '             >';
    groupHtml += '                 <rect width="16" height="16" rx="2" stroke="none"></rect>';
    groupHtml += '                 <rect x="0.5" y="0.5" width="15" height="15" rx="1.5" fill="none"></rect>';
    groupHtml += '            </g>';
    groupHtml += '             <circle';
    groupHtml += '                 id="Ellipse_275"';
    groupHtml += '                 data-name="Ellipse 275"';
    groupHtml += '                 cx="1.5"';
    groupHtml += '                 cy="1.5"';
    groupHtml += '                r="1.5"';
    groupHtml += '                   transform="translate(3.505 3.505)"';
    groupHtml += '                  fill="none"';
    groupHtml += '                  stroke="#006AFF"';
    groupHtml += '                  stroke-linecap="round"';
    groupHtml += '                  stroke-linejoin="round"';
    groupHtml += '                  stroke-width="1"';
    groupHtml += '              ></circle>';
    groupHtml += '               <path';
    groupHtml += '                   id="Path_1674"';
    groupHtml += '                   data-name="Path 1674"';
    groupHtml += '                   d="M19.587,14.614,14.973,10,5.426,19.6"';
    groupHtml += '                   transform="translate(-4.718 -4.902)"';
    groupHtml += '                   fill="none"';
    groupHtml += '                   stroke="#006AFF"';
    groupHtml += '                   stroke-linecap="round"';
    groupHtml += '                   stroke-linejoin="round"';
    groupHtml += '                   stroke-width="1"';
    groupHtml += '               ></path>';
    groupHtml += '           </g>';
    groupHtml += '       </svg>';
    groupHtml += '       Add Thumbnail';
    groupHtml += '   </button>';
    groupHtml += '</span>';
    groupHtml += '<span cols="22" class="td-u tt3-s listing-item">';

    if ((gkey == 0 && $(".loadColumnFieldsOnPage").length > 1) || (parseInt($(".loadColumnFieldsOnPage").length)) > parseInt(gkey) + 1) {
        groupHtml += '<button shape="circle" aria-label="Move Down" title="Move Down" class="move_down_button show" data-move_down_index="' + gkey + '" type="button">';
    } else {
        groupHtml += '<button shape="circle" aria-label="Move Down" title="Move Down" class="move_down_button hide-d" data-move_down_index="' + gkey + '" type="button">';
    }

    groupHtml += '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">';
    groupHtml += '<path d="M99.4 284.9l134 138.1c5.8 6 13.7 9 22.4 9h.4c8.7 0 16.6-3 22.4-9l134-138.1c12.5-12 12.5-31.3 0-43.2-12.5-11.9-32.7-11.9-45.2 0l-79.4 83v-214c0-16.9-14.3-30.6-32-30.6-18 0-32 13.7-32 30.6v214l-79.4-83c-12.5-11.9-32.7-11.9-45.2 0s-12.5 31.2 0 43.2z"></path>';
    groupHtml += '</svg>';
    groupHtml += '</button>';

    if (gkey != 0 && gkey <= (parseInt($(".loadColumnFieldsOnPage").length))) {
        groupHtml += '<button shape="circle" aria-label="Move Up" title="Move Up" class="move_up_button show" data-move_up_index="' + gkey + '" type="button">';
    } else {
        groupHtml += '<button shape="circle" aria-label="Move Up" title="Move Up" class="move_up_button hide-d" data-move_up_index="' + gkey + '" type="button">';
    }
    groupHtml += '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">';
    groupHtml += '<path d="M412.6 227.1L278.6 89c-5.8-6-13.7-9-22.4-9h-.4c-8.7 0-16.6 3-22.4 9l-134 138.1c-12.5 12-12.5 31.3 0 43.2 12.5 11.9 32.7 11.9 45.2 0l79.4-83v214c0 16.9 14.3 30.6 32 30.6 18 0 32-13.7 32-30.6v-214l79.4 83c12.5 11.9 32.7 11.9 45.2 0s12.5-31.2 0-43.2z"></path>';
    groupHtml += '</svg>';
    groupHtml += '</button>';
    groupHtml += ' </span>';
    groupHtml += '</div>';

    $(".tble_append_d").append(groupHtml);
    ImgUpload();
    //gkey++;

    $('.loadColumnFieldsOnPage').each(function (i, obj) {
        if ((i == 0 && $(".loadColumnFieldsOnPage").length > 1) || (parseInt($(".loadColumnFieldsOnPage").length)) > parseInt(i) + 1) {
            $("[data-move_down_index='" + i + "']").removeClass("hide-d");
        } else {
            $("[data-move_down_index='" + i + "']").addClass("hide-d");
        }

        if (i != 0 && i <= (parseInt($(".loadColumnFieldsOnPage").length))) {
            $("[data-move_up_index='" + i + "']").removeClass("hide-d");
        } else {
            $("[data-move_up_index='" + i + "']").addClass("hide-d");
        }
    });

}

function removeItemGroup(event) {
    gkey--;
    var rid = $(event).attr("data-id");
    $(event).parent().closest('.group_rw_d').remove();
    // $(".group_row_" + rid).remove();
}

// ..............Column section......................
function showColumnModal() {
    var itm_th = $(".itm_th");
    var hsn_th = $(".hsn_th");
    var gst_th = $(".gst_th");
    var qty_th = $(".qty_th");
    var rate_th = $(".rate_th");
    var amt_th = $(".amt_th");
    var cgst_th = $(".cgst_th");
    var sgst_th = $(".sgst_th");
    // var totl_th = $(".totl_th");

    $(".col_itm_name").val(itm_th.text());
    $(".col_hsn_name").val(hsn_th.text());
    $(".col_gst_name").val(gst_th.text());
    $(".col_qty_name").val(qty_th.text());
    $(".col_rate_name").val(rate_th.text());
    $(".col_amt_name").val(amt_th.text());
    $(".col_cgst_name").val(cgst_th.text());
    $(".col_sgst_name").val(sgst_th.text());
    // $(".amt_th").val(totl_th.val());

    $("#editcolumns").modal("show");

}

$("body").on("click", ".colse_column_popup", function () {
    $("#editcolumns").modal("hide");
});
// Add new table column
var tbleclkey = 0;
function addNewTableColumn(event) {
    var LineHtml = [];

    LineHtml += '<div class="col_line show tble_col_' + tbleclkey + '">';
    LineHtml += ' <div class="space_grag handle instant">';
    LineHtml += '     <iconify-icon icon="ic:twotone-drag-indicator"></iconify-icon>';
    LineHtml += ' </div>';
    LineHtml += ' <div class="withprivet">';
    LineHtml += '    <div class="form-group">';
    LineHtml += '        <label>';
    LineHtml += '            <input type="text" class="col_hsn_name dynmic_itm_rw" required="" id="" value="" placeholder="Item">';
    LineHtml += '            <span>Col name</span>';
    LineHtml += '       </label>';
    LineHtml += '   </div>';
    LineHtml += '   <div class="sd_check">';
    LineHtml += '      <input type="checkbox" name="provt_' + tbleclkey + '" id="private_' + tbleclkey + '">';
    LineHtml += '      <label class="pull-right text" for="private_' + tbleclkey + '">Make private?</label>';
    LineHtml += '  </div>';
    LineHtml += ' </div>';
    LineHtml += ' <div class="select_wr">';
    LineHtml += '    <select class="js-types form-control nosearch col_hsn_type">';
    LineHtml += '       <option value="">TEXT</option>';
    LineHtml += '       <option value="">NUMBER</option>';
    LineHtml += '   </select>';
    LineHtml += ' </div>';
    LineHtml += ' <div class="action_btns">';
    //  LineHtml += '  <button class="hide"><iconify-icon icon="ph:eye"></iconify-icon> Hide</button>';
    //  LineHtml += '  <button class="unhide"><iconify-icon icon="ph:eye-slash"></iconify-icon> Unhide</button>';
    LineHtml += '  <button class="remove" onclick="removeTableColumn(this)" data-id="' + tbleclkey + '" ><iconify-icon icon="mingcute:delete-2-line"></iconify-icon> Remove</button>';
    LineHtml += ' </div>';
    LineHtml += '</div>';

    $(".append_table_col").after(LineHtml);

    $(".js-types.form-control.nosearch").select2({
        minimumResultsForSearch: Infinity,
        theme: "bootstrap4",
    });

    tbleclkey++;
}

function removeTableColumn(event) {
    tbleclkey--;
    var rid = $(event).attr("data-id");
    $(".tble_col_" + rid).remove();
}

function appendNewItemColumn() {
    var colHtml = [];
    colHtml += ' <div class="col_line">';
    colHtml += '                   <div class="space_grag">';
    colHtml += '                  </div>';
    colHtml += '                  <div class="form-group">';
    colHtml += '                      <label>';
    colHtml += '                          <input type="text" class="col_itm_name" required="" id="" value="" placeholder="Item">';
    colHtml += '                          <span>Col name</span>';
    colHtml += '                      </label>';
    colHtml += '                  </div>';
    colHtml += '                  <div class="select_wr">';
    colHtml += '                      <select class="js-states form-control nosearch col_itm_type">';
    colHtml += '                          <option value="">TEXT</option>';
    colHtml += '                          <option value="">NUMBER</option>';
    colHtml += '                      </select>';
    colHtml += '                  </div>';
    colHtml += '                  <div class="action_btns">';
    colHtml += '                      <button class="hide"><iconify-icon icon="ph:eye"></iconify-icon> Hide</button>';
    colHtml += '                      <button class="unhide"><iconify-icon icon="ph:eye-slash"></iconify-icon> Unhide</button>';
    colHtml += '                  </div>';
    colHtml += '              </div>';

    $(".last_col_div").after(colHtml);
}



function saveItemColumns() {


}

// .........................End................

// var shpkey = 0;
function addShippingCustomFields() {

    var LineHtml = [];
    LineHtml += ' <li class="ship_rwo_' + shpkey + '" key="' + shpkey + '">';
    LineHtml += '                                         <input type="text" class="shipped_to_custome_filed_key" name="shipped_to_custome_filed_key[' + shpkey + ']" id="" value="" placeholder="Value">';

    LineHtml += '                                     <div>';
    LineHtml += '                                         <input type="text" class="shipped_to_custome_filed_value" name="shipped_to_custome_filed_value[' + shpkey + ']" id="" value="" placeholder="Value">';
    LineHtml += '                                     </div>';
    LineHtml += '                                     <a href="javascript:void(0)" onclick="removeShippingCustomField(this)" data-id="' + shpkey + '" class="close">';
    LineHtml += '                                         <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#006AFF" xmlns="http://www.w3.org/2000/svg">';
    LineHtml += '                                             <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z" ></path>';
    LineHtml += '                                             <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z" ></path>';
    LineHtml += '                                         </svg>';
    LineHtml += '                                     </a>';
    LineHtml += '                                 </li>';
    $(".shipp_cus_data").append(LineHtml);
    shpkey++;
}

function removeShippingCustomField(event) {
    shpkey--;
    var rid = $(event).attr("data-id");
    $(".ship_rwo_" + rid).remove();
}



// var trmey = 1;
function appendTermsConditonRow() {
    // close_i
    var LineHtml = [];
    var nm = parseInt(trmey) + 1;
    LineHtml += '<div class="item tncWrapper trm_rwo_' + trmey + '" data-term_listing_index="' + trmey + '">';
    LineHtml += '                       <span class="terms_and_conditions_note"  data-term_listing_number="' + trmey + '">' + nm + '.</span>';
    LineHtml += '                       <p class="editableText ">Write here..</p>';
    LineHtml += '                       <button aria-label="Remove Term" class="close_icon" onclick="removedTermsConditonRow(this)" data-id="' + trmey + '"  type="button">';
    LineHtml += '                           <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>';
    LineHtml += '                       </button>';

    if ((trmey == 0 && $(".tncWrapper").length > 1) || (parseInt($(".tncWrapper").length)) > parseInt(trmey) + 1) {
        LineHtml += '<button shape="circle" aria-label="Move Down" title="Move Down" class="tnc_move_down_button show" data-tnc_move_down_index="' + trmey + '" type="button">';
    } else {
        LineHtml += '<button shape="circle" aria-label="Move Down" title="Move Down" class="tnc_move_down_button hide-d" data-tnc_move_down_index="' + trmey + '" type="button">';
    }

    LineHtml += '                           <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">';
    LineHtml += '                               <path d="M99.4 284.9l134 138.1c5.8 6 13.7 9 22.4 9h.4c8.7 0 16.6-3 22.4-9l134-138.1c12.5-12 12.5-31.3 0-43.2-12.5-11.9-32.7-11.9-45.2 0l-79.4 83v-214c0-16.9-14.3-30.6-32-30.6-18 0-32 13.7-32 30.6v214l-79.4-83c-12.5-11.9-32.7-11.9-45.2 0s-12.5 31.2 0 43.2z"></path>';
    LineHtml += '                           </svg>';
    LineHtml += '                       </button>';

    if (trmey != 0 && trmey <= (parseInt($(".tncWrapper").length))) {
        LineHtml += '<button shape="circle" aria-label="Move Up" title="Move Up" class="tnc_move_up_button show" data-tnc_move_up_index="' + trmey + '" type="button">';
    } else {
        LineHtml += '<button shape="circle" aria-label="Move Up" title="Move Up" class="tnc_move_up_button hide-d" data-tnc_move_up_index="' + trmey + '" type="button">';
    }
    LineHtml += '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="20" width="20" xmlns="http://www.w3.org/2000/svg">';
    LineHtml += '<path d="M412.6 227.1L278.6 89c-5.8-6-13.7-9-22.4-9h-.4c-8.7 0-16.6 3-22.4 9l-134 138.1c-12.5 12-12.5 31.3 0 43.2 12.5 11.9 32.7 11.9 45.2 0l79.4-83v214c0 16.9 14.3 30.6 32 30.6 18 0 32-13.7 32-30.6v-214l79.4 83c12.5 11.9 32.7 11.9 45.2 0s12.5-31.2 0-43.2z"></path>';
    LineHtml += '</svg>';
    LineHtml += '                       </button>';
    LineHtml += '                   </div>';

    $(".terms_body").append(LineHtml);
    initializeEditabeEditor();
    trmey++;

    $('.tncWrapper').each(function (i, obj) {
        if ((i == 0 && $(".tncWrapper").length > 1) || (parseInt($(".tncWrapper").length)) > parseInt(i) + 1) {
            $("[data-tnc_move_down_index='" + i + "']").removeClass("hide-d");
        } else {
            $("[data-tnc_move_down_index='" + i + "']").addClass("hide-d");
        }

        if (i != 0 && i <= (parseInt($(".tncWrapper").length))) {
            $("[data-tnc_move_up_index='" + i + "']").removeClass("hide-d");
        } else {
            $("[data-tnc_move_up_index='" + i + "']").addClass("hide-d");
        }
    });
}

function removedTermsConditonRow(event) {
    trmey--;
    var rid = $(event).attr("data-id");
    $(".trm_rwo_" + rid).remove();
}


// ... AppendAdditionalInfo
// adkey = 1;
function AppendAdditionalInfo() {
    var LineHtml = [];
    LineHtml += '<div class="item_info all addnal_rwo_' + adkey + '">';
    LineHtml += '                   <input type="text" class="add_additional_info_key" name="" id="" placeholder="Field Name" />';
    LineHtml += '                   <input type="text" class="add_additional_info_value" name="" id="" placeholder="Value" />';
    LineHtml += '                   <button class="close" onclick="removeAdditionalInfo(this)" data-id="' + adkey + '" >';
    LineHtml += '                       <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>';
    LineHtml += '                   </button>';
    LineHtml += '               </div>';

    $(".add_additional_info_div_d").find(".additional_footer").prev().after(LineHtml);
    adkey++;
}

function removeAdditionalInfo(event) {
    adkey--;
    var rid = $(event).attr("data-id");
    $(".addnal_rwo_" + rid).remove();
}


// var btmkey = 0;
function addBottomCustomFields() {

    var LineHtml = [];
    LineHtml += ' <div class="add_field_item show bt_rwo_' + btmkey + '">';
    LineHtml += '                                         <input type="text" class="big_field bottom_custome_filed_key" name="bottom_custome_filed_key[' + btmkey + ']" id="" value="" placeholder="Field Name">';
    LineHtml += '                                         <input type="text" class="small_field  bottom_to_custome_filed_value" name="bottom_to_custome_filed_value[' + btmkey + ']" id="" value="" placeholder="Value">';
    LineHtml += ' <button class="close_re_btn" type="button" onclick="removeBottomCustomField(this)" data-id="' + btmkey + '" ><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" color="#733dd9" xmlns="http://www.w3.org/2000/svg">';
    LineHtml += ' <path d="M5.35355 4.64645C5.15829 4.45118 4.84171 4.45118 4.64645 4.64645C4.45118 4.84171 4.45118 5.15829 4.64645 5.35355L5.35355 4.64645ZM18.6464 19.3536C18.8417 19.5488 19.1583 19.5488 19.3536 19.3536C19.5488 19.1583 19.5488 18.8417 19.3536 18.6464L18.6464 19.3536ZM4.64645 5.35355L18.6464 19.3536L19.3536 18.6464L5.35355 4.64645L4.64645 5.35355Z"></path>';
    LineHtml += ' <path d="M19.3536 5.35355C19.5488 5.15829 19.5488 4.84171 19.3536 4.64645C19.1583 4.45118 18.8417 4.45118 18.6464 4.64645L19.3536 5.35355ZM4.64645 18.6464C4.45118 18.8417 4.45118 19.1583 4.64645 19.3536C4.84171 19.5488 5.15829 19.5488 5.35355 19.3536L4.64645 18.6464ZM18.6464 4.64645L4.64645 18.6464L5.35355 19.3536L19.3536 5.35355L18.6464 4.64645Z"></path>';
    LineHtml += '</svg></button>';
    LineHtml += '                                 </div>';
    // $(".terms_body").append(LineHtml);

    $(".btm_hdr").find(".btm_footer").prev().after(LineHtml);

    btmkey++;
}

function removeBottomCustomField(event) {
    btmkey--;
    var rid = $(event).attr("data-id");
    $(".bt_rwo_" + rid).remove();
}


function copyShippingFromData(event) {

    if ($(event).is(":checked")) {
        $(".shipped_from_name").val($(".business_by_name_txt_d").text());
        $(".shipped_from_country_id").val($(".edit_countyr_id").val());
        $(".shipped_from_address").val($(".business_by_address_txt_d").text());
        $(".shipped_from_city").val($(".edit_city_id").val());
        $(".shipped_from_zip_code").val($(".business_by_zip_txt_d").text());
        $(".shipped_from_state_name").val($(".business_by_state_txt_d").text());
    } else {
        $(".shipped_from_name").val('');
        $(".shipped_from_country_id").val('');
        $(".shipped_from_address").val('');
        $(".shipped_from_city").val('');
        $(".shipped_from_zip_code").val('');
        $(".shipped_from_state_name").val('');
    }
}

function copyShippingToData(event) {

    if ($(event).is(":checked")) {
        $(".shipped_to_name").val($(".business_to_name_txt_d").text());
        $(".shipped_to_country_id").val($(".edit_client_countyr_id").val());
        $(".shipped_to_address").val($(".business_to_address_txt_d").text());
        $(".shipped_to_city").val($(".edit_city_id").val());
        $(".shipped_to_zip_code").val($(".client_zip_txt_d").text());
        $(".shipped_to_state_name").val($(".client_state_txt_d").text());
    } else {
        $(".shipped_to_name").val('');
        $(".shipped_to_country_id").val('');
        $(".shipped_to_address").val('');
        $(".shipped_to_city").val('');
        $(".shipped_to_zip_code").val('');
        $(".shipped_to_state_name").val('');
    }
}

function getClientShippingAddress() {
    var id = $(".shiping_to_dropdown").val();
    $.ajax({
        url: APP_URL + '/api/CustomerShow/' + id,
        type: 'get',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                // $(".shipped_to_name").val(response.);
                $(".shipped_to_country_id").val(response.data.shipping_country).change();
                $(".shipped_to_address").val(response.data.shipping_city);
                $(".shipped_to_city").val(response.data.shipping_city);
                $(".shipped_to_zip_code").val(response.data.shipping_zip);
                $(".shipped_to_state_name").val(response.data.shipping_state_name);
            }

        },
        error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
}


function getBusinessDeatil(event) {
    var id = $(event).val();
    $.ajax({
        url: APP_URL + '/api/BusinesShow/' + id,
        type: 'get',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                appendBusinesCardData(response);
            } else {
                $("#final_igst1").prop('checked', true);
                $("#final_sgst2").removeAttr("checked");

                $(".c_s_gst_th").addClass("hide-d");
                $(".c_s_gst_td").addClass("hide-d");
                $(".igst_th").removeClass("hide-d");
                $(".igst_td").removeClass("hide-d");
            }
        },
        error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
}

function appendBusinesCardData(response) {
    $(".business_by_name_txt_d").text(response?.data?.business_name);
    $(".business_by_address_txt_d").text(response?.data?.street_address);
    $(".business_by_code_txt_d").text(response?.data?.gst_code);
    $(".business_by_state_txt_d").text(response?.data?.state);
    $(".business_by_country_txt_d").text(response?.data?.country);
    $(".business_by_zip_txt_d").text(response?.data?.zip_code);


    $(".edit_busi_country").val(response?.data?.country_id);
    $(".edit_busi_state").val(response?.data?.state_id);
    $(".edit_busi_street_address").val(response?.data?.street_address);
    $(".edit_business_id").val(response?.data?.id);

    var client_gst_code = parseInt($(".business_to_code_txt_d").text());
    var business_gst_code = parseInt(response?.data?.gst_code);
    console.log("business_gst_code 1", business_gst_code);
    console.log("client_gst_code1 ", client_gst_code);
    checkIsStateSame(business_gst_code, client_gst_code)

}

function getClientBusinessData(event) {
    var id = $(event).val();
    $.ajax({
        url: APP_URL + '/api/CustomerShow/' + id,
        type: 'get',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                appedClientData(response);
            }

        },
        error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
}

function checkIsStateSame(business_gst_code, client_gst_code){
    var is_have_tax = $(".tx_poup_taxtype").val();
    console.log("business_gst_code ", business_gst_code);
    console.log("client_gst_code ", client_gst_code);
    if(is_have_tax != 'none'){

    if (business_gst_code == client_gst_code) {
        
        
        var alreadyExists = -1;
        var searchCurrentId = "CGST";
        $.each(defaultJson, function (index, obj) {
            if (obj.unique_key === searchCurrentId) {
                alreadyExists = index;
                return false; // Exit the loop once the object is found
            }
        });

        if (alreadyExists !== -1) {
            return false;
        }
        $("#final_igst1").removeAttr("checked");
        $("#flexRadioDefault4").removeAttr("checked");
        $("#final_sgst2").prop('checked', true);
        $("#flexRadioDefault5").prop('checked', true);

        removeIgstFromArray();
        addCgstInArray();
        CGSTShowed = true;

    } else {


        var alreadyExists = -1;
        var searchCurrentId = "IGST";

        $(".c_s_gst_th").addClass("hide-d");
        $(".c_s_gst_td").addClass("hide-d");
        $(".igst_th").removeClass("hide-d");
        $(".igst_td").removeClass("hide-d");

        CGSTShowed = false;

        $.each(defaultJson, function (index, obj) {
            if (obj.unique_key === searchCurrentId) {
                alreadyExists = index;
                return false; // Exit the loop once the object is found
            }
        });

        if (alreadyExists !== -1) {
            return false;
        }

        $("#final_igst1").prop('checked', true);
        $("#flexRadioDefault4").prop('checked', true);
        $("#final_sgst2").removeAttr("checked");
        $("#flexRadioDefault5").removeAttr("checked");

        removeCgstFromArray();
        removeSgstFromArray();
        addIgstInArray();
    }
    loadtableAfterColumnsChange()
  }
}
function appedClientData(response) {
    $(".business_to_name_txt_d").text(response?.data?.name);
    var billing_address = '';
    var billing_state_name = '';
    var billing_country_name = '';
    var billing_zip = '';
    if (response?.data?.billing_address != '' && response?.data?.billing_address != undefined && response?.data?.billing_address != null) {
        billing_address = response?.data?.billing_address;
    }
    if (response?.data?.billing_state_name != '' && response?.data?.billing_state_name != undefined && response?.data?.billing_state_name != null) {
        billing_state_name = response?.data?.billing_state_name;
    }
    if (response?.data?.billing_country_name != '' && response?.data?.billing_country_name != undefined && response?.data?.billing_country_name != null) {
        billing_country_name = response?.data?.billing_country_name;
    }
    if (response?.data?.billing_zip != '' && response?.data?.billing_zip != undefined && response?.data?.billing_zip != null) {
        billing_zip = response?.data?.billing_zip;
    }
    var full_address = billing_address;
    // var full_address = billing_address + ' ' + billing_state_name + ' ' + billing_country_name + ' ' + billing_zip;
    $(".business_to_address_txt_d").text(full_address);
    $(".business_to_code_txt_d").text(response?.data?.gst_code);
    $(".client_state_txt_d").text(response?.data?.billing_state_name);
    $(".client_zip_txt_d").text(response?.data?.billing_zip);
    $(".client_country_txt_d").text(response?.data?.billing_country_name);

    $(".edit_clint_id").val(response?.data?.id);
    $(".client_empty_form").addClass("hide-d");
    $(".cient_detail_form").removeClass("hide-d");

    var business_gst_code = parseInt($(".business_by_code_txt_d").text());
    var client_gst_code = parseInt(response?.data?.gst_code);
   
    checkIsStateSame(business_gst_code, client_gst_code);

    var option = [];
    option += '<option value=""> Select </option>';
    option += '<option value="' + response?.data?.id + '" >' + response?.data?.name + ' </option>';
    $(".shiping_to_dropdown").empty().append(option);

}

$(document).ready(function(){
  
    var db_business_gst_code = parseInt($(".business_by_code_txt_d").text());
    var db_client_gst_code = parseInt($(".business_to_code_txt_d").text());
    // checkIsStateSame(db_business_gst_code, db_client_gst_code);

});

$("body").on("click", ".show_new_client_popup", function () {
    $("#createnewclient").modal("show");

});
$("body").on("click", ".show_new_business_popup", function () {
    $("#createnewcompany").modal("show");
});


$(document).ready(function () {
    initializeSuggestionInput();
});



function get_productData(id, this_) {
    $.ajax({
        url: APP_URL + '/api/VariationProductShow/' + id,
        type: 'get',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                var indx_id = this_;
                console.log('indx_id ', indx_id)
                var tax_rate = parseFloat(response?.data[0]?.tax_rate);

                $(".hsn_" + indx_id).val(response?.data[0]?.hsn);
                if (typeof tax_rate != "undefined" && tax_rate != null && !isNaN(tax_rate)) {

                    $(".gst_rate_" + indx_id).val(tax_rate);
                    $(".budle_quantity_" + indx_id).attr("data-gst-rate", tax_rate);

                } else {
                    $(".gst_rate_" + indx_id).val('0');
                    $(".budle_quantity_" + indx_id).attr("data-gst-rate", 0);

                }
                $(".budle_quantity_" + indx_id).val(1);


                var sale_price = parseFloat(response?.data[0]?.sale_price);

                if (typeof sale_price != "undefined" && sale_price != null && !isNaN(sale_price)) {
                    $(".rate_" + indx_id).val(sale_price.toFixed(2));

                    $(".rate_" + indx_id).attr("data-db-price", sale_price.toFixed(2));
                    $(".amount_" + indx_id).val(sale_price.toFixed(2));
                    $(".amount_" + indx_id).attr("data-db-price", sale_price);
                } else {
                    $(".rate_" + indx_id).val('0');

                    $(".rate_" + indx_id).attr("data-db-price", "0");
                    $(".amount_" + indx_id).val("0");
                    $(".amount_" + indx_id).attr("data-db-price", "0");
                }

                tax_rate = (tax_rate / 100) * sale_price;

                var cgst_sgst = tax_rate / 2
                if (typeof cgst_sgst != "undefined" && cgst_sgst != null && !isNaN(cgst_sgst)) {
                    $(".cgst_" + indx_id).val(cgst_sgst.toFixed(2));
                    $(".sgst_" + indx_id).val(cgst_sgst.toFixed(2));
                } else {
                    $(".cgst_" + indx_id).val('0');
                    $(".sgst_" + indx_id).val('0');
                }

                if (typeof tax_rate != "undefined" && tax_rate != null && !isNaN(tax_rate)) {
                    $(".igst_" + indx_id).val(tax_rate.toFixed(2));
                } else {
                    $(".igst_" + indx_id).val('0');
                }


                var rowTotal = parseFloat(tax_rate) + parseFloat(sale_price);
                $(".total_" + indx_id).val(rowTotal.toFixed(2));

                var db_stock = response?.data[0]?.quantity
                $(".budle_quantity_" + indx_id).attr("data-db-stock", db_stock);
                $(".budle_quantity_" + indx_id).attr("data-inital-stock", db_stock);
                calculateInvoiceTotal();

            }
        },
        error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
}

function select(index, main_listing_index, element) {
    console.log('dsds', main_listing_index)
    const searchInput = document.querySelectorAll(".searchInput")[index];
    const input = searchInput.querySelector("input");
    const resultBox = searchInput.querySelector(".resultBox");
    input.value = element.textContent;
    var selected_id = element.getAttribute("data-id");
    input.setAttribute("data-id", selected_id);
    input.setAttribute("data-proid", element.getAttribute("data-proid"));
    searchInput.classList.remove("active");
    // var pid = parseInt(index) + 1;
    get_productData(selected_id, main_listing_index);
}


function initializeSuggestionInput() {
    // getting all required elements
    const searchInputs = document.querySelectorAll(".searchInput");

    searchInputs.forEach((searchInput, index) => {
        const input = searchInput.querySelector("input");
        const resultBox = searchInput.querySelector(".resultBox");
        const icon = searchInput.querySelector(".icon");
        let linkTag = searchInput.querySelector("a");
        let webLink;
        var main_listing_index = searchInput.parentNode.parentNode.getAttribute("data-main_listing_index");

        // if user press any key and release
        input.addEventListener('keyup', (e) => {
            let userData = e.target.value; //user entered data
            let emptyArray = [];
            if (userData) {
                emptyArray = suggestions?.filter((data) => {
                    if (data?.prod_name?.toLocaleLowerCase().startsWith(userData?.toLocaleLowerCase()))
                        return data?.prod_name?.toLocaleLowerCase().startsWith(userData?.toLocaleLowerCase());
                });
                emptyArray = emptyArray.map((data) => {
                    return data = '<li data-id="' + data?.varit_id + '" data-proid="' + data?.pro_id + '" >' + data?.prod_name + ' ' + data?.variation_name + ' (' + data?.quantity + ')</li>';
                });
                searchInput.classList.add("active");
                showSuggestions(emptyArray);
                let allList = resultBox.querySelectorAll("li");
                for (let i = 0; i < allList.length; i++) {
                    allList[i].setAttribute("onclick", `select(${index},${main_listing_index}, this)`);
                }
            } else {
                searchInput.classList.remove("active");
            }
        });

        function showSuggestions(list) {
            let listData;
            if (!list.length) {
                userValue = input.value;
                listData = '<li>' + userValue + '</li>';
            } else {
                listData = list.join('');
            }
            resultBox.innerHTML = listData;
        }
    });



    document.addEventListener('click', (e) => {
        const searchInputs = document.querySelectorAll(".searchInput");
        searchInputs.forEach((searchInput) => {
            if (!searchInput.contains(e.target)) {
                searchInput.classList.remove("active");
            }
        });
    });
}

$("body").on("change", '.currency_id', function () {
    var val = $(this).val();
    var val_name = $(this).select2().find(":selected").data("id");
    $(".g_total_sign").text(val);
    $(".tag_total_sign").text(val_name);
    $(".common_currency_sel_d option[value='rupees']").remove();
    $(".common_currency_sel_d").append("<option value='rupees' data-id='" + val + "'  selected>" + val + "</option>");
    numberToWordsWithDecimal();
});


//Fill next button tab code= SBIN0060288
$("body").on("focusout", ".invoice_no", function () {
    var id = $(this).val();
    $.ajax({
        url: APP_URL + '/api/SaleInvoiceCheckNo/',
        type: "POST",
        data: { 'invoice_no': id },
        beforeSend: function (xhr) {
            // block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == false) {
                toastr.error(response?.message)
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
});

function addDateInterval() {
    var days = $(".days_after_due_date").val();
    var date2 = $('.datepicker').datepicker('getDate', '+1d');
    date2.setDate(date2.getDate() + parseInt(days));
    $('.datepicker2').datepicker('setDate', date2);

    $.ajax({
        url: APP_URL + '/api/SaleInvoiceSetDueDate',
        type: 'post',
        data:{"due_days": days},
        // cache: false,
        // contentType: false,
        // processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
               $("#duedate").modal("hide");
            }
        },
        error: function (response) {
            block_gui_end();
            console.log("server side error");
        }

  });

}

$("body").on("click", ".reset_signature", function () {
        $.ajax({
            url: APP_URL + '/api/SaleInvoiceResetSetting',
            type: 'get',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function (xhr) {
                block_gui_start();
                xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

            },
            success: function (response) {
                block_gui_end();
                if (response.status == true) {
                    // toastr.success("Saved successfully.");
                }
            },
            error: function (response) {
                block_gui_end();
                console.log("server side error");
            }

      });
});

function getLoadColumnFields() {
    var dataArray = [];
    // dataArray.product = [];
    var subDataArray = [];
    var total_qty = 0;
    var total_amt = 0;
    var total_row = 0;

    var grand_total_qty = 0;
    var grand_total_amt = 0;
    var grand_row_total = 0;

    var grp_index = -1;
    var grp_started = false;
    var is_field = false;
    var description_row_data = "";
    var gcolumn_name = [];
    $('.loadColumnFieldsOnPage').each(function (i, obj) {
        subDataArray = [];

        var main_listing_index = $(this).attr("data-main_listing_index");
        if (!$(this).hasClass("group_rw_d")) { // Means its Item
            is_field = true;
            var colsCount = 7;
            var item_cal = 'item_inp_' + main_listing_index;
            subDataArray.push(
                {
                    "column_class": "",
                    "column_name": $(".first_item_span").html(),
                    "field_class": 'grp_item ' + item_cal,
                    "field_val": $("." + item_cal).val(),
                    "field_product_id": $("." + item_cal).attr("data-proid"),
                    "is_group": false,
                    "main_index": main_listing_index,
                }
            );
            var array = [1, 2, 3, 4];
            var lastRowindex = Object.keys(defaultJson);
            lastRowindex = lastRowindex.length - 1
            description_row_data = "";
            $.each(defaultJson, function (key, item) {
                var jsonKey = key;
                var classList = item?.field_class?.split(" ");

                if (classList.length == 1) {
                    var field_cal = classList[0];
                } else {
                    var field_cal = classList[2];
                }

                field_cal = field_cal + '' + main_listing_index;
                var fval = $("." + field_cal).val();
                if (fval == undefined) {
                    field_cal = item?.field_class + '' + main_listing_index;
                    fval = $("." + field_cal).val();
                }

                if (key == lastRowindex) {
                    total_qty = parseInt(total_qty) + parseInt($(".budle_quantity_" + main_listing_index).val());
                    total_amt = parseFloat(total_amt) + parseFloat($(".amount_" + main_listing_index).val());
                    total_row = parseFloat(total_row) + parseFloat($(".total_" + main_listing_index).val());

                    grand_total_qty = parseInt(grand_total_qty) + parseInt($(".budle_quantity_" + main_listing_index).val());;
                    grand_total_amt = parseFloat(grand_total_amt) + parseFloat($(".amount_" + main_listing_index).val());
                    grand_row_total = parseFloat(grand_row_total) + parseFloat($(".total_" + main_listing_index).val());

                    if (grp_started == true) {
                        dataArray[grp_index]['data'][0] = {
                            "field_class": "",
                            "field_val": "",
                            "total_qty": total_qty,
                            "total_amt": total_amt,
                            "total_row": total_row,
                            "is_group": true,
                            "is_group_sub_total": true,
                            "main_index": main_listing_index
                        }
                    }

                    description_row_data = $("." + field_cal).parent().parent().parent().parent().find('.ProseMirror').children().text();
                        
                }

                if (item.column_class.indexOf("amount_column") >= 0 && !$(".discount_td_" + main_listing_index).hasClass("hide-d")) {

                    var alreadyExists = -1;
                    var searchCurrentId = "Discount";
                    $.each(subDataArray, function (index, obj) {
                        if (obj.unique_key === searchCurrentId) {
                            alreadyExists = index;
                            return false; // Exit the loop once the object is found
                        }
                    });

                    if (alreadyExists !== -1) {
                        subDataArray[alreadyExists].main_index = main_listing_index;
                        subDataArray[alreadyExists].field_val = $(".inpt_inline_disc_" + main_listing_index).val();
                        subDataArray[alreadyExists].inline_disc_val = $("." + field_cal).parent().parent().parent().parent().find('.inline_disc').val();
                        subDataArray[alreadyExists].inline_disc_type = $("." + field_cal).parent().parent().parent().parent().find('.inline_disc_type').val();
                        subDataArray[alreadyExists].row_description = $("." + field_cal).parent().parent().parent().parent().find('.ProseMirror').children().text();
                    } else {
                        subDataArray.push(
                            {
                                "column_class": "Discount",
                                "column_name": "Discount",
                                "field_class": "Discount",
                                "field_val": $(".inpt_inline_disc_" + main_listing_index).val(),
                                "is_group": false,
                                "unique_key": "Discount",
                                "main_index": main_listing_index,
                                "inline_disc_val": $("." + field_cal).parent().parent().parent().parent().find('.inline_disc').val(),
                                "inline_disc_type": $("." + field_cal).parent().parent().parent().parent().find('.inline_disc_type').val(),
                                "row_description": $("." + field_cal).parent().parent().parent().parent().find('.ProseMirror').children().text(),
                                "row_tax_rate": $(".budle_quantity_" + main_listing_index).attr("data-gst-rate"),
                                "row_hsn_val": $(".hsn_" + main_listing_index).val()

                            }
                        );
                    }
                }
                var unique_key = item?.column_name.replace(/\s+/g, '_');
                unique_key = unique_key.replace('/', '_');
                subDataArray.push(
                    {
                        "column_class": item?.column_class,
                        "column_name": item?.column_name,
                        "field_class": item?.field_class + ' ' + field_cal,
                        "field_val": fval,
                        "unique_key": item.unique_key,
                        "hide": item.hide,
                        "editable": item.editable,
                        "deletable": item.deletable,
                        "is_group": false,
                        "main_index": main_listing_index,
                        "inline_disc_val": $("." + field_cal).parent().parent().parent().parent().find('.inline_disc').val(),
                        "inline_disc_type": $("." + field_cal).parent().parent().parent().parent().find('.inline_disc_type').val(),
                        "row_description": $("." + field_cal).parent().parent().parent().parent().find('.ProseMirror').children().text(),
                        "row_tax_rate": $(".budle_quantity_" + main_listing_index).attr("data-gst-rate"),
                        "row_hsn_val": $(".hsn_" + main_listing_index).val()

                    }
                );
                // gcolumn_name[0]['g_columns'].push(item?.column_name);

            });
        } else { // Its Group

            is_field = false;

            grp_started = true;
            //grp_index = main_listing_index;
            subDataArray.push({
                "field_class": "",
                "field_val": "",
                "total_qty": total_qty,
                "total_amt": total_amt,
                "total_row": total_row,
                "is_group": true,
                "is_group_sub_total": true,
                "main_index": main_listing_index
            })
            var group_val = $(".group_nm_" + main_listing_index).val();
            subDataArray.push({
                // "column_name": gcolumn_name,
                "field_class": "group_nm_" + main_listing_index,
                "field_val": group_val,
                "is_group": true,
                "main_index": main_listing_index,
                "fields": []
            });



            total_qty = 0;
            total_amt = 0;
            total_row = 0;

        }
        var columns = [{
            "class": "",
            "column_class": "",
            "column_name": $(".first_item_span").html(),
            "field_class": 'grp_item ' + item_cal,
            "field_val": $("." + item_cal).val(),
            "field_product_id": $("." + item_cal).attr("data-proid"),
            "is_group": false,
            "main_index": main_listing_index,
        }];
        $.each(defaultJson, function (key, item) {
            columns.push(item);
        })

        if (grp_started == true && is_field == true) {
            dataArray[grp_index]['data'][1]['fields'].push(subDataArray);
        } else if (grp_started == true) {
            grp_index++;
            dataArray.push({ "is_group": true, "data": subDataArray, "columns": columns, "description_data": description_row_data });
        } else {
            grp_index++;
            dataArray.push({ "is_group": false, "data": subDataArray, "columns": columns, "description_data": description_row_data });
        }


    });

    dataArray.push({
        "is_grand_total": true,
        "is_group": false,
        "field_val": "",
        "grand_total_qty": grand_total_qty,
        "grand_total_amt": grand_total_amt,
        "grand_row_total": grand_row_total,
    })

    console.log('subDataArray ', dataArray);

    return dataArray;
}

function is_formValidate() {
    var status = true;
    var messageArray = [];
    var msg = "";
    if ($(".grp_item").length === 0 || $(".item_inp_0").val() == '') {
        var msg1 = "items field must have at least 1 items.";
        messageArray.push(msg1);
        status = false;
    }
    if ($(".bill_customer_id").val().length === 0 || $(".bill_customer_id").val() == '' || $(".bill_customer_id").val() == null || $(".bill_customer_id").val() == 0) {
        var msg2 = "Client detail required.";
        messageArray.push(msg2);
        status = false;
    }
    var error_msg = ''
    $(messageArray).each(function (index, val) {
        error_msg += '<li style="color: red;">' + val + '</li>'
    });
    console.log('error array ', messageArray);
    $(".error_div").empty().append(error_msg);
    return status;
}

// #form saving function start
function SaveEntity(event) {
    if (!is_formValidate()) {
        return false;
    }
    //   getLoadColumnFields();return false;
    var formData = new FormData();

    formData.append('business_logo', $(".business_logo")[0].files[0]);
    formData.append('invoice_title', $(".page_title").children(".big_size").text());
    formData.append('invoice_sub_title', $(".invoice_sub_title").find('.big_size').val());
    formData.append('invoice_no', $('.invoice_no').val());
    formData.append('invoice_date', $('.invoice_date').val());
    formData.append('due_date', $('.due_date').val());
    formData.append('days_after_due_date', $('.days_after_due_date').val());
    $(".invoice_custome_filed_key").each(function (index) {
        formData.append('invoice_custome_filed_key[' + index + ']', $(this).val());
    });
    $(".invoice_custome_filed_value").each(function (index) {
        formData.append('invoice_custome_filed_value[' + index + ']', $(this).val());
    });
    //   .................. Blling Section start.......
    // .....................Business...............
    formData.append('business_name', $(".edit_busi_name").val());
    formData.append('business_address_country_id', $(".edit_countyr_id").val());
    formData.append('business_address_state_id', $(".edit_busi_state").val());
    formData.append('business_gst_in', $(".edit_businee_gstin").val());
    formData.append('business_pan_no', $(".edit_businee_pan_no").val());
    formData.append('business_zip_code', $(".potal_code").val());
    formData.append('business_street_address', $(".edit_busi_street_address").val());
    formData.append('business_email', $(".edit_business_email").val());
    formData.append('business_phone', $(".edit_busi_no").val());
    formData.append('business_id', $(".billed_by_business_id").val());

    formData.append('business_show_email_invoice', $(".is_show_email_on_invoice").is(":checked") ? '1' : '');
    formData.append('business_show_phone_invoice', $(".is_show_phone_on_invoice").is(":checked") ? '1' : '');
    formData.append('business_current_changes_business', $(".update_current_change_by").is(":checked") ? '1' : '');
    ///..................Client section.........
    formData.append('client_business_name', $(".edit_client_name").val());
    formData.append('client_address_country_id', $(".edit_client_countyr_id").val());
    formData.append('client_address_state_id', $(".edit_client_state").val());
    formData.append('client_pan_no', $(".edit_client_pan_no").val());
    formData.append('client_gst_in', $(".edit_client_gstin").val());
    formData.append('client_phone', $(".edit_client_no").val());
    formData.append('client_street_address', $(".editclient_street_address").val());
    formData.append('client_address_zip_code', $(".client_potal_code").val());
    formData.append('client_email', $(".edit_client_email").val());

    formData.append('client_show_email_invoice', $(".is_show_client_email_on_invoice").is(":checked") ? '1' : '');
    formData.append('client_show_phone_invoice', $(".is_show_client_phone_on_invoice").is(":checked") ? '1' : '');
    formData.append('client_current_changes_business', $(".update_current_change_to").is(":checked") ? '1' : '');
    formData.append('client_id', $(".bill_customer_id").val());
    //   ..... #billing Section end...
    formData.append('e_invoice_details', '');
    formData.append('company_id', $('.billed_by_business_id').val());
    formData.append('company_name', $('.business_by_name_txt_d').text());
    formData.append('company_address', $('.business_by_address_txt_d').text());


    // formData.append('company_country_id', $('.client_zip_txt_d').val());
    // formData.append('company_country_name', $(".business_by_country_txt_d").text());
    // formData.append('company_state_id', $('.company_address').val());
    // formData.append('company_state_name', $('.business_by_state_txt_d').val());

    // formData.append('billing_from_country_id', $('.shipping_from_country').val());
    formData.append('billing_from_country_name', $(".business_by_country_txt_d").text());
    // formData.append('billing_from_address', $('.shipped_from_address').val());
    // formData.append('billing_from_city', $('.shipped_from_city').val());
    formData.append('billing_from_zip_code', $('.business_by_code_txt_d').text());
    formData.append('billing_from_state_name', $('.business_by_state_txt_d').text());

    formData.append('customer_id', $('.bill_customer_id').val());
    formData.append('customer_name', $('.business_to_name_txt_d').text());
    formData.append('customer_address', $('.business_to_address_txt_d').text());

    // formData.append('billing_to_country_id', $('.shipping_from_country').val());
    formData.append('billing_to_country_name', $(".client_country_txt_d").text());
    formData.append('billing_to_address', $('.shipped_from_address').val());
    // formData.append('billing_to_city', $('.shipped_from_city').val());
    formData.append('billing_to_zip_code', $('.client_zip_txt_d').text());
    formData.append('billing_to_state_name', $('.client_state_txt_d').text());

    formData.append('is_shipping_detail_req', $('.is_shiiping_detail_req').is(":checked") ? '1' : '0');
    formData.append('shipped_from_name', $('.shipped_from_name').val());
    formData.append('shipped_from_country_id', $('.shipping_from_country').val());
    formData.append('shipped_from_country_name', $(".shipping_from_country :selected").text());
    formData.append('shipped_from_address', $('.shipped_from_address').val());
    formData.append('shipped_from_city', $('.shipped_from_city').val());
    formData.append('shipped_from_zip_code', $('.shipped_from_zip_code').val());
    formData.append('shipped_from_state_name', $('.shipped_from_state_name').val());
    formData.append('shipped_to_id', '');
    formData.append('shipped_to_name', $('.shipped_to_name').val());
    formData.append('shipped_to_country_id', $('.shipped_to_country_id').val());
    formData.append('shipped_to_country_name', $(".shipped_to_country_id :selected").text());
    formData.append('shipped_to_address', $('.shipped_to_address').val());
    formData.append('shipped_to_city', $('.shipped_to_city').val());
    formData.append('shipped_to_zip_code', $('.shipped_to_zip_code').val());
    formData.append('shipped_to_state_name', $('.shipped_to_state_name').val());

    $(".shipped_to_custome_filed_key").each(function (index) {
        formData.append('shipped_to_custome_filed_key[' + index + ']', $(this).val());
    });
    $(".shipped_to_custome_filed_value").each(function (index) {
        formData.append('shipped_to_custome_filed_value[' + index + ']', $(this).val());
    });
    // ............Challan  
    formData.append('transport_challan', $('.challan_number').val());
    formData.append('transport_challan_date', $('.challan_date').val());
    formData.append('transport_name', $('.transport_name').val());
    formData.append('transport_information', $('.shipping_note').val());

    formData.append('currency', $('.currency_id').select2().find(":selected").data("cid"));
    formData.append('final_amount', $('#showTotal_d').text());
    formData.append('final_cgst', $('#showTotalCgst_d').text());
    formData.append('final_sgst', $('#showTotalSgst_d').text());
    formData.append('final_igst', $('#showTotalIGST_d').text());

    formData.append('final_product_wise_discount', $(".final_product_wise_discount").val());
    formData.append('final_product_wise_discount_unit', $(".final_product_wise_discount_unit").val());
    formData.append('final_total_discount_reductions', $(".final_total_discount_reductions").val());
    formData.append('final_total_discount_reductions_unit', $(".final_total_discount_reductions_unit").val());

    formData.append('final_extra_charges', $(".extra_changes").val());
    formData.append('extra_changes_unit', $(".extra_changes_unit").val());
    formData.append('final_summarise_total_quantity', $('.final_summarise_total_quantity').is(":checked") ? 1 : 0);

    formData.append('round_up', $('.round_up_d').val());
    formData.append('round_down', $('.round_down_d').val());

    formData.append('final_total', $('#finalGrandTotal').text());

    formData.append('is_total_words_show', $(".is_totalInwordshow").val());
    formData.append('final_total_words', $(".totalnWords").children().children().next().text());


    formData.append('additional_notes', $('.ProseMirror').last().text());

    // .......Terms and condition 
    $(".terms_and_conditions_note").each(function (index) {
        formData.append('terms_and_conditions_key[' + index + ']', 'term_key_' + index);
        formData.append('terms_and_conditions_value[' + index + ']', $(this).next().text());
    });


    $(".add_additional_info_key").each(function (index) {
        formData.append('add_additional_info_key[' + index + ']', $(this).val());
    });
    $(".add_additional_info_value").each(function (index) {
        formData.append('add_additional_info_value[' + index + ']', $(this).val());
    });
    var contact_detail_country_code = $(".contact_detail_country_code").val()
    var contact_detail = $(".contact_detail_text").val() + '-' + $(".contact_detail_email_at").val() + '-' + $(".contact_detail_your_email").val() + '-' + $(".contact_detail_cell_no").val();
    contact_detail = contact_detail + ' - ' + contact_detail_country_code;
    formData.append('contact_details', contact_detail);
    formData.append('is_contact_show', $(".is_contact_show").val());
    formData.append('is_terms_req', $(".is_terms_req").val());
    formData.append('is_additional_notes_req', $(".is_additional_notes_req").val());
    formData.append('is_attactments_req', $(".is_attactments_req").val());
    formData.append('is_additional_info_req', $(".is_additional_info_req").val());

    $(".bottom_custome_filed_key").each(function (index) {
        formData.append('final_total_more_field_key[' + index + ']', $(this).val());
    });
    $(".bottom_to_custome_filed_value").each(function (index) {
        formData.append('final_total_more_field_value[' + index + ']', $(this).val());
    });

    // ..product
    $(".ProseMirror").each(function (index) {
        formData.append('product_invoice_details[' + index + ']', $(this).text());
    });


    formData.append('is_tax', $('.is_igst_popoup_val').val());
    formData.append('tax_type', $('.tx_poup_taxtype').val());
    formData.append('signature_labed_name', $('.signature_labed_name').val());

    formData.append('number_format', $('.number_format').val());
    formData.append('invoice_country', $('.invoice_country').val());
    formData.append('decimal_digit_format', $('.decimal_digit_format').val());
    formData.append('hide_place_of_supply', $('.hide_place_of_supply').is(":checked") ? '1' : '');
    formData.append('hsn_column_view', $('.hsn_column_view').val());
    formData.append('show_hsn_summary', $('.show_hsn_summary').is(":checked") ? '1' : '');
    formData.append('add_original_images', $('.add_original_images').is(":checked") ? '1' : '');
    formData.append('show_description_in_full_width', $('.show_description_in_full_width').is(":checked") ? '1' : '');
    formData.append('is_tax', $('input[name="final_igst"]:checked').val());


    var proArray = [];
    $(".group_name_d").each(function (index) {
        formData.append('group_name[' + index + ']', $(this).val());
    });

    $(".grp_item").each(function (index) {
        proArray.push({
            'group_name': $(this).parent().parent().parent().parent().prevAll().find('.group_name_d').last().val(),
            'product_id': $(this).attr("data-proid"),
            'variation_id': $(this).attr("data-id"),
            'product_hsn_code': $(this).parent().parent().nextAll().find(".hsn_d").val(),
            'product_gst_rate': $(this).parent().parent().nextAll().find(".gst_rate_d").val(),
            'product_quantity': $(this).parent().parent().nextAll().find(".qty_d").val(),
            'product_discount': $(this).parent().parent().parent().parent().find('.inline_disc').val(),
            'product_discount_type': $(this).parent().parent().parent().parent().find('.common_currency_sel_d').val(),
            'product_rate': $(this).parent().parent().nextAll().find(".rate_d").val(),
            'product_amount': $(this).parent().parent().nextAll().find(".amt_d").val(),
            'product_igst': $(this).parent().parent().nextAll().find(".igst_d").val(),
            'product_cgst': $(this).parent().parent().nextAll().find(".cgst_d").val(),
            'product_sgst': $(this).parent().parent().nextAll().find(".sgst_d").val(),
            'product_total': $(this).parent().parent().nextAll().find(".total_d").val(),
            'product_description': $(this).parent().parent().parent().parent().find('.ProseMirror').children().text(),
            'product_row_index': $(this).parent().parent().parent().parent().attr("data-main_listing_index"),
        });
    });

    formData.append('product_array', JSON.stringify(proArray));
    var col_feild_array = getLoadColumnFields();
    formData.append('filed_data', JSON.stringify(col_feild_array));

    // console.log(formData);return false;
    // ..........................Attachments
    var mediArray = [];
    $(".invoice_product_image").each(function (index) {
        mediArray.push({
            'product_row_index': $(this).attr("data-main-index"),
            'invoice_product_image': $(this)[0].files[0]
        })
        formData.append('product_row_index[' + index + '][0]', $(this).attr("data-main-index"));
        formData.append('invoice_product_image[' + index + '][0]', $(this)[0].files[0]);
    });
    console.log('mediArray ', mediArray);
    formData.append('media_array', JSON.stringify(mediArray));

    $(".invoice_group_image").each(function (index) {
        formData.append('invoice_group_image[' + index + '][0]', $(this)[0].files[0]);
    });


    //Form Labed
    formData.append('label_invoice_no', $(".append_top_column").children().children().find('.big_size').html());
    formData.append('label_invoice_date', $(".append_top_column").children().next().children().find('.big_size').html());
    formData.append('label_invoice_due_date', $(".append_top_column").children().next().next().children().find('.big_size').html());

    formData.append('label_invoice_billed_by', $(".billed_by").children().find('.big_size').html());
    formData.append('label_invoice_billed_to', $(".billed_to").children().find('.big_size').html());

    formData.append('label_invoice_shipped_from', $(".ship_by").children().find('.big_size').html());
    formData.append('label_invoice_shipped_to', $(".ship_to").children().find('.big_size').html());

    formData.append('label_invoice_transport_details', $(".invoice_transport_details_div").find('.big_size').html());
    formData.append('label_invoice_challan_no', $(".challan_no_div").children().find('.big_size').html());
    formData.append('label_invoice_challan_date', $(".challan_date_div").children().find('.big_size').html());
    formData.append('label_invoice_transport', $(".invoice_transport_div").children().find('.big_size').html());
    formData.append('label_invoice_extra_information', $(".extra_information_div").children().find('.big_size').html());

    formData.append('label_invoice_terms_and_conditions', $(".invoice_terms_and_conditions_div").find('.big_size').html());
    formData.append('label_invoice_additional_notes', $(".additional_notes_div").find('.big_size').html());
    formData.append('label_invoice_attachments', $(".invoice_attachments_div").find('.big_size').html());
    
    formData.append('label_round_up', $(".label_round_up_div").find('.big_size').html());
    formData.append('label_round_down', $(".label_round_down_div").find('.big_size').html());
    formData.append('label_total', $(".label_total_div").find('.big_size').html());
    formData.append('additional_info_label', $(".additional_info_label_div_d").find('.big_size').html());
    formData.append('signature_labed_name', $(".sigture_label_value").val());

    //Dropzone   
    var mb = 0;
    var dsk = 0;
    dropzones.forEach(function (dropzone) {

        var element = dropzone.element;
        var cindex = $(element).get(0).id;
        var paramName = dropzone.options;
        var fiels = dropzone.getAcceptedFiles();
        fiels.forEach(function (file, i) {
            if (cindex && cindex == "desktop_media") {
                formData.append('invoice_attachments[' + dsk + ']', file);
                dsk++
            } else if (cindex && cindex == "mobile_media") {
                formData.append('invoice_attachments[' + mb + ']', file);
                mb++;
            }
        });
    });

    var invoiceUrl = APP_URL + '/api/SaleInvoiceAdd';

    // .....For edit
    var dbInvoiceID = $(".db_invoice_id").val();
    if (is_invoice_edit && dbInvoiceID != '') {
        formData.append('id', dbInvoiceID);
        invoiceUrl = APP_URL + '/api/SaleInvoiceEdit';
    }
    if (is_inv_duplicate != '') {
        invoiceUrl = APP_URL + '/api/SaleInvoiceAdd';
    }

    $.ajax({
        url: invoiceUrl,
        data: formData,
        type: 'post',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                toastr.success(response?.message)
                
                if(response?.have_bank_detail){
                      window.location.href = APP_URL + '/en/invoice/step3/' + enyptID + '/' + response?.invoice_id;
                }else
                  window.location.href = APP_URL + '/en/invoice/step2/' + enyptID + '/' + response?.invoice_id;

            } else {
                toastr.error(response?.message)
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    })
}

//Billing section
function showEditBusinessModel() {
    var id = $(".billed_by_business_id").val();
    $.ajax({
        url: APP_URL + '/api/SaleBusinessDetailsShow/' + id,
        type: 'get',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                $(".edit_busi_name").val(response?.data?.business_name);
                $(".edit_countyr_id").val(response?.data?.country_id).change();
                $(".edit_busi_state").val(response?.data?.state_id).change();
                $(".edit_businee_gstin").val(response?.data?.gst_no);
                $(".edit_businee_pan_no").val(response?.data?.pan_no);
                $(".potal_code").val(response?.data?.zip_code);
                $(".edit_busi_street_address").val(response?.data?.street_address);
                $(".edit_business_email").val(response?.data?.email);
                $(".edit_busi_no").val(response?.data?.bussiness_phone);
                // $(".is_show_email_on_invoice").val(response?.data?.hsn);
                // $(".edit_busi_no").val(response?.data?.hsn);
                // $(".is_show_phone_on_invoice").val(response?.data?.hsn);
                // $(".update_current_change_by").val(response?.data?.hsn);
                $(".edit_business_id").val(id);
                $("#billbyedit").modal("show");
            }
        },
        error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
}

function UpdateBusinessDetil(event) {

    var id = $(".billed_by_business_id").val();
    var formData = new FormData();

    formData.append('business_name', $(".edit_busi_name").val());
    formData.append('business_address_country_id', $(".edit_countyr_id").val());
    formData.append('business_address_state_id', $(".edit_busi_state").val());
    formData.append('business_gst_in', $(".edit_businee_gstin").val());
    formData.append('business_pan_no', $(".edit_businee_pan_no").val());
    formData.append('business_zip_code', $(".potal_code").val());
    formData.append('business_street_address', $(".edit_busi_street_address").val());
    formData.append('business_email', $(".edit_business_email").val());
    formData.append('business_phone', $(".edit_busi_no").val());
    formData.append('business_id', $(".billed_by_business_id").val());

    formData.append('business_show_email_invoice', $(".is_show_email_on_invoice").is(":checked") ? '1' : '');
    formData.append('business_show_phone_invoice', $(".is_show_phone_on_invoice").is(":checked") ? '1' : '');
    formData.append('business_current_changes_business', $(".update_current_change_by").is(":checked") ? '1' : '');

    formData.append('platform', "Unesync");
    formData.append('guard', "WEB");

    $.ajax({
        url: APP_URL + '/api/SaleBusinessDetailsEdit/' + id,
        data: formData,
        type: 'post',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                toastr.success(response?.message);
                $(".business_by_name_txt_d").text($(".edit_busi_name").val());
                $(".business_by_address_txt_d").text($(".edit_busi_street_address").val());

                $("#billbyedit").modal("hide");

            } else {
                toastr.error(response?.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    })
}


$("body").on("click", ".close_bill_by_popup", function () {
    $("#billbyedit").modal("hide");
});
$("body").on("click", ".close_bill_to_popup", function () {
    $("#billtoedit").modal("hide");
});

//Billing section
function showEditClientModel() {
    var id = $(".bill_customer_id").val();
    $.ajax({
        url: APP_URL + '/api/SaleClientDetailsShow/' + id,
        type: 'get',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);

        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                $(".edit_client_name").val(response?.data?.name);
                // $(".edit_client_countyr_id").val(response?.data?.country_id).change();
                $(".edit_client_state").val(response?.data?.billing_state).change();
                $(".edit_client_gstin").val(response?.data?.tax_number);
                $(".edit_client_pan_no").val(response?.data?.pan);
                $(".client_potal_code").val(response?.data?.billing_zip);
                $(".editclient_street_address").val(response?.data?.billing_address);
                $(".edit_client_email").val(response?.data?.email);
                $(".edit_client_no").val(response?.data?.billing_phone);
                $(".edit_clint_id").val(id);
                $("#billtoedit").modal("show");
            }
        },
        error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    });
}




function UpdateClientDetail(event) {

    var id = $(".bill_customer_id").val();
    var form_data = new FormData();

    form_data.append('client_business_name', $(".edit_client_name").val());
    form_data.append('client_address_country_id', $(".edit_client_countyr_id").val());
    form_data.append('client_address_state_id', $(".edit_client_state").val());
    form_data.append('client_pan_no', $(".edit_client_pan_no").val());
    form_data.append('client_gst_in', $(".edit_client_gstin").val());
    form_data.append('client_phone', $(".edit_client_no").val());
    form_data.append('client_street_address', $(".editclient_street_address").val());
    form_data.append('client_address_zip_code', $(".client_potal_code").val());
    form_data.append('client_email', $(".edit_client_email").val());

    form_data.append('client_show_email_invoice', $(".is_show_client_email_on_invoice").is(":checked") ? '1' : '');
    form_data.append('client_show_phone_invoice', $(".is_show_client_phone_on_invoice").is(":checked") ? '1' : '');
    form_data.append('client_current_changes_business', $(".update_current_change_to").is(":checked") ? '1' : '');

    form_data.append('client_id', $(".bill_customer_id").val());

    form_data.append('platform', "Unesync");
    form_data.append('guard', "WEB");
    form_data.append('_token', csrfTokenVal);

    $.ajax({
        url: APP_URL + '/api/SaleClientDetailsEdit/' + id,
        data: form_data,
        type: 'post',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            block_gui_start();
            xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
        },
        success: function (response) {
            block_gui_end();
            if (response.status == true) {
                toastr.success(response?.message);
                $(".business_to_name_txt_d").text($(".edit_client_name").val());
                $(".business_to_address_txt_d").text($(".editclient_street_address").val());
                $("#billtoedit").modal("hide");

            } else {
                toastr.error(response?.message);
            }

        }, error: function (response) {
            block_gui_end();
            console.log("server side error");
        }
    })
}

$("body").on("click", ".click_next_close", function () {
    $("#changeGst").modal("hide");
});

//.................Calculation section...............


// ..............Row Calculation..........
$("body").on("click", "button.apply_inline_discount", function () {
    var rid = $(this).attr("data-key");
    $(".hide_discount").removeClass("show");
    $(".add_discount").show();
    // $(this).parent().parent().parent().find('.hide_discount').removeClass();
    // $(this).parent().parent().parent().find('.add_discount').show();
    calculateRowValues(rid);
});

$("body").on("input", ".inline_disc", function () {
    var rid = $(this).attr("data-key");
    // calculateInlineDiscount(rid);
    // calculateRowValues(rid);
});

function calculateInlineDiscount(rid) {
    var totalItemDiscount = parseFloat($('.inlineDiscVal_' + rid).val());
    $('.inpt_inline_disc_' + rid).val(totalItemDiscount);
    var discTpe = $('.inlineDiscType_' + rid).val();
    var totalAmout = $('.rate_' + rid).val();

    var DsicVal = 0;
    if (discTpe == 'rupees') {
        DsicVal = parseFloat(totalItemDiscount);
    } else if (discTpe == '%') {
        DsicVal = (totalItemDiscount / 100) * totalAmout;
    } else {
        DsicVal = 0;
    }
    var finalTotalDisc = 0;
    if (typeof DsicVal != "undefined" && DsicVal != null && !isNaN(DsicVal)) {
        finalTotalDisc = parseFloat(totalAmout) - parseFloat(DsicVal);
    }

    $('.amount_' + rid).val(finalTotalDisc);
    var row_gst_rate = $('.gst_rate_' + rid).val();
    var tax_rate = parseFloat(row_gst_rate);
    tax_rate = (tax_rate / 100) * total;

    var rowTotal = parseFloat(finalTotalDisc) + parseFloat(tax_rate);
    if (typeof rowTotal != "undefined" && rowTotal != null && !isNaN(rowTotal)) {
        $('.total_' + rid).val(rowTotal);
    }

    calculateInvoiceTotal();
}

$("body").on("change", ".inline_disc_type", function () {
    var key = $(this).attr("data-key");
    // calculateInlineDiscount(key);
    calculateRowValues(key);
});

$("body").on("click", "button.remove_inline_discount", function () {
    var rid = $(this).attr("data-key");
    $('.inpt_inline_disc_' + rid).val('-');
    $('.inlineDiscVal_' + rid).val('0');
    $(".inline_disc_div_" + rid).removeClass("show");
    // $(".hide_discount").removeClass("show");
    // $(".add_discount").show();
    $(".add_inlineDisc_"+ rid).show();
     
    calculateRowValues(rid);

});

//...............end

// ........Comman functions............
function numberToWords(number) {
    var digit = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    var elevenSeries = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
    var countingByTens = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
    var shortScale = ['', 'thousand', 'million', 'billion', 'trillion'];

    number = number.toString(); number = number.replace(/[\, ]/g, ''); if (number != parseFloat(number)) return 'not a number'; var x = number.indexOf('.'); if (x == -1) x = number.length; if (x > 15) return 'too big'; var n = number.split(''); var str = ''; var sk = 0; for (var i = 0; i < x; i++) { if ((x - i) % 3 == 2) { if (n[i] == '1') { str += elevenSeries[Number(n[i + 1])] + ' '; i++; sk = 1; } else if (n[i] != 0) { str += countingByTens[n[i] - 2] + ' '; sk = 1; } } else if (n[i] != 0) { str += digit[n[i]] + ' '; if ((x - i) % 3 == 0) str += 'hundred '; sk = 1; } if ((x - i) % 3 == 1) { if (sk) str += shortScale[(x - i - 1) / 3] + ' '; sk = 0; } } if (x != number.length) { var y = number.length; str += 'point '; for (var i = x + 1; i < y; i++) str += digit[n[i]] + ' '; } str = str.replace(/\number+/g, ' '); return str.trim() + "";

}

function numberToWordsWithDecimal(n) {
    var n = $("#finalGrandTotal").text();
    var nums = n.toString().split('.');
    var whole = numberToWords(nums[0])
    console.log(nums);
    var currency_unit = $(".currency_id").select2().find(":selected").data("unit");
    if (nums.length == 2 && nums[1] != '00') {
        var fraction = numberToWords(nums[1]);
        whole = whole + ' and ' + fraction + ' ' + currency_unit + ' only.';
        $(".totalnWords").children().children().next().html(toCamelCase(whole));
        return
    } else {
        $(".totalnWords").children().children().next().html(toCamelCase(whole));
        return

    }
}
function toCamelCase(str) {
    return str.replace(/(?:^|\s)\w/g, function (match) {
        return match.toUpperCase();
    });
}

function getAmountWithOutTax() {
    var itemAmt = $(".amt_d");
    var totalAmout = 0;
    for (var k = 0; k <= itemAmt.length; k++) {
        if (typeof itemAmt[k]?.value != "undefined" &&
            itemAmt[k]?.value != "" &&
            itemAmt[k]?.value != null &&
            !isNaN(itemAmt[k]?.value)) {
            totalAmout =
                parseFloat(totalAmout) +
                parseFloat(itemAmt[k]?.value);
        }
    }

    return totalAmout;
}

function getAmountWithTax() {
    var itemAmt = $(".amt_d");
    var totalAmout = 0;
    for (var k = 0; k <= itemAmt.length; k++) {
        if (typeof itemAmt[k]?.value != "undefined" &&
            itemAmt[k]?.value != "" &&
            itemAmt[k]?.value != null &&
            !isNaN(itemAmt[k]?.value)) {
            totalAmout =
                parseFloat(totalAmout) +
                parseFloat(itemAmt[k]?.value);
        }
    }
    var gstRate = $(".igst_d");
    var totalRate = 0;
    for (var k = 0; k <= gstRate.length; k++) {
        if (typeof gstRate[k]?.value != "undefined" &&
            gstRate[k]?.value != "" &&
            gstRate[k]?.value != null &&
            !isNaN(gstRate[k]?.value)) {
            totalRate =
                parseFloat(totalRate) +
                parseFloat(gstRate[k]?.value);
        }
    }

    var gtotal = parseFloat(totalAmout) + parseFloat(totalRate);
    gtotal = gtotal.toFixed(2);
    return gtotal;
}

//..............Grand totals
$(document).on("keyup", ".qty_d", function () {
    var key = $(this).attr("data-index-key");
    calculateRowValues(key);
});

$(document).on("keyup", ".gst_rate_d", function () {
    var key = $(this).attr("data-index-key");
    calculateRowValues(key);
    $(".budle_quantity_" + key).attr("data-gst-rate", $(this).val());
});

$(document).on("keyup", ".rate_d", function () {
    var key = $(this).attr("data-index-key");
    calculateRowValues(key);

});


function calculateRowValues(key, amt_change = false) {
    var rate = $(".rate_" + key).val();
    if($(".gst_rate_" + key).val() == "" || $(".gst_rate_" + key).val() == "undefined" || $(".gst_rate_" + key).val() == null){
        var gst_rate =0;
        $(".gst_rate_" + key).val(0);
    }else{
        var gst_rate =  $(".gst_rate_" + key).val()
    }
    var qty = $(".budle_quantity_" + key).val();
    //... .....check discount.........
    var totalItemDiscount = parseFloat($('.inlineDiscVal_' + key).val());
    var discTpe = $('.inlineDiscType_' + key).val();
    var DsicVal = 0;
    if (discTpe == 'rupees') {
        DsicVal = parseFloat(totalItemDiscount);
    } else if (discTpe == '%') {
        var f_rate = rate * qty;
        DsicVal = (totalItemDiscount / 100) * f_rate;

    } else {
        DsicVal = 0;
    }

    var finalTotalDisc = 0;
    if (typeof DsicVal != "undefined" && DsicVal != null && !isNaN(DsicVal)) {
        finalTotalDisc = DsicVal;
    }
    $('.inpt_inline_disc_' + key).val(finalTotalDisc.toFixed(2));

    // ...........
    var total = parseInt(qty) * parseFloat(rate);
    total = total - parseFloat(finalTotalDisc);
    var tax_rate = parseFloat(gst_rate);
    tax_rate = (tax_rate / 100) * total;

    var rowTotal = parseFloat(tax_rate) + parseFloat(total);

    var s_c_gst = tax_rate / 2;


    if (typeof s_c_gst != "undefined" && s_c_gst != null && !isNaN(s_c_gst)) {
        $(".cgst_" + key).val(s_c_gst.toFixed(2));
        $(".sgst_" + key).val(s_c_gst.toFixed(2));
    } else {
        $(".cgst_" + key).val('0');
        $(".sgst_" + key).val('0');

    }

    if (typeof tax_rate != "undefined" && tax_rate != null && !isNaN(tax_rate)) {
        $(".igst_" + key).val(tax_rate.toFixed(2));
    } else {
        $(".igst_" + key).val('0');
    }

    if (typeof rowTotal != "undefined" && rowTotal != null && !isNaN(rowTotal)) {
        $(".total_" + key).val(rowTotal.toFixed(2));
    } else {
        $(".total_" + key).val('0');
    }

    if (amt_change != true) {
        if (typeof total != "undefined" && total != null && !isNaN(total)) {
            $(".amount_" + key).val(total.toFixed(2));
        } else {
            $(".amount_" + key).val('0');
        }
    }
    calculateInvoiceTotal();
}



$(document).on("propertychange input", ".amt_d", function () {
    var key = $(this).attr("data-index-key");
    var amnt = $(this).val();
    var qty = $(".budle_quantity_" + key).val();
    var rate_total = parseFloat(amnt) / parseInt(qty);
    if (rate_total != undefined && !isNaN(rate_total))
        $(".rate_" + key).val(rate_total);

    calculateRowValues(key, true);
});


$(document).on("keyup", ".discount_on_total", function () {
    calculateInvoiceTotal();
});

$(document).on("change", ".discount_on_total_type", function () {
    calculateInvoiceTotal();
});

$(document).on("input", ".round_up_d", function () {
    calculateInvoiceTotal();
});
$(document).on("input", ".round_down_d", function () {
    calculateInvoiceTotal();
});
// ..Extra charges
$(document).on("input", ".extra_changes", function () {
    calculateInvoiceTotal();
});
$(document).on("change", ".extra_charges_type", function () {
    calculateInvoiceTotal();
});

function calculateInvoiceTotal() {
    // ......Total amt .........
    var itemAmt = $(".amt_d");
    var totalAmout = 0;
    for (var k = 0; k <= itemAmt.length; k++) {
        if (typeof itemAmt[k]?.value != "undefined" &&
            itemAmt[k]?.value != "" &&
            itemAmt[k]?.value != null &&
            !isNaN(itemAmt[k]?.value)) {
            totalAmout =
                parseFloat(totalAmout) +
                parseFloat(itemAmt[k]?.value);
            totalAmout = totalAmout.toFixed(2);

        }
    }
    $("#showTotal_d").html(totalAmout);
    //......Total cgst ........
    var itemTotalCgst = $(".cgst_d");
    var totalCgst = 0;
    for (var k = 0; k <= itemTotalCgst.length; k++) {
        if (
            typeof itemTotalCgst[k]?.value != "undefined" &&
            itemTotalCgst[k]?.value != "" &&
            itemTotalCgst[k]?.value != null &&
            !isNaN(itemTotalCgst[k]?.value)
        ) {
            totalCgst =
                parseFloat(totalCgst) +
                parseFloat(itemTotalCgst[k]?.value);
        }
    }

    $("#showTotalCgst_d").html(totalCgst.toFixed(2));

    // .......Total sgst .............
    var itemTotalSgst = $(".sgst_d");
    var totalSgst = 0;
    for (var k = 0; k <= itemTotalSgst.length; k++) {
        if (
            typeof itemTotalSgst[k]?.value != "undefined" &&
            itemTotalSgst[k]?.value != "" &&
            itemTotalSgst[k]?.value != null &&
            !isNaN(itemTotalSgst[k]?.value)
        ) {
            totalSgst =
                parseFloat(totalSgst) +
                parseFloat(itemTotalSgst[k]?.value);

        }
    }
    $("#showTotalSgst_d").html(totalSgst.toFixed(2));

    var itemGST = $(".gst_rate_d");
    var totalGST = 0;
    for (var k = 0; k <= itemGST.length; k++) {
        if (
            typeof itemGST[k]?.value != "undefined" &&
            itemGST[k]?.value != "" &&
            itemGST[k]?.value != null &&
            !isNaN(itemGST[k]?.value)
        ) {
            totalGST =
                parseFloat(totalGST) +
                parseFloat(itemGST[k]?.value);
        }
    }
    // $("#showTotalIGST_d").html(totalGST);
    var totalGSTtaxInpertage = 0;

    if (
        typeof totalGST != "undefined" &&
        totalGST != "" &&
        totalGST != null &&
        !isNaN(totalGST)
    ) {
        var final_totalGST = (totalGST / 100) * totalAmout;
        totalGSTtaxInpertage =
            parseFloat(totalGSTtaxInpertage) +
            parseFloat(final_totalGST);
        //   totalGSTPercentage = totalGSTPercentage.toFixed(2);

    }

    var itemGSTPerctage = $(".igst_d");
    var totalGSTPercentage = 0;
    for (var k = 0; k <= itemGSTPerctage.length; k++) {
        if (
            typeof itemGSTPerctage[k]?.value != "undefined" &&
            itemGSTPerctage[k]?.value != "" &&
            itemGSTPerctage[k]?.value != null &&
            !isNaN(itemGSTPerctage[k]?.value)
        ) {
            totalGSTPercentage =
                parseFloat(totalGSTPercentage) +
                parseFloat(itemGSTPerctage[k]?.value);
            //   totalGSTPercentage = totalGSTPercentage.toFixed(2);

        }
    }
    if (typeof totalGSTPercentage != "undefined" && totalGSTPercentage != null && !isNaN(totalGSTPercentage)) {
        $("#showTotalIGST_d").html(totalGSTPercentage.toFixed(2));
    } else {
        $("#showTotalIGST_d").html("0.00");
    }

    var totalDsic = 0;
    var totalItemDiscountPercentage = $(".discount_on_total").val();
    var discpunType = $(".discount_on_total_type").val();
    // var totalWithTax = (parseFloat(totalAmout) + parseFloat(totalGSTPercentage));

    var is_show_cgst = $("input[type='radio'][name='final_igst']:checked").val();
    var totalWithTax =0;
    if (is_show_cgst == 'CGST') {
        totalWithTax = parseFloat(totalAmout) + parseFloat(totalSgst) + parseFloat(totalCgst);
    } else if (is_show_cgst == 'IGST') {
         totalWithTax = (parseFloat(totalAmout) + parseFloat(totalGSTPercentage));

    } else {
        totalWithTax = 0;
    }

    if (discpunType == 'rupees') {
        totalDsic = parseFloat(totalItemDiscountPercentage);
    } else if (discpunType == '%') {
        totalDsic = (totalItemDiscountPercentage / 100) * totalWithTax;
    }
    var finalTotalDisc = 0;
    if (typeof totalDsic != "undefined" && totalDsic != "" && totalDsic != null && !isNaN(totalDsic)) {
        finalTotalDisc = totalDsic.toFixed(2);
    }

    //............Round up.........

    var round_up = 0;
    var is_round_up_show = $(".round_on_hide").attr("data-show");
    if (is_round_up_show == 'yes') {
        var round_up_val = $(".round_up_d").val();
        if (typeof round_up_val != "undefined" && round_up_val != "" && round_up_val != null && !isNaN(round_up_val)) {
            round_up = round_up_val;
        }

    }

    //...............Round down.....
    var round_down = 0;

    var is_round_down_show = $(".round_off_hide").attr("data-show");
    if (is_round_down_show == 'yes') {
        var round_down_val = $(".round_down_d").val();
        if (typeof round_down_val != "undefined" && round_down_val != "" && round_down_val != null && !isNaN(round_down_val)) {
            round_down = round_down_val;
        }
    }
    //........Extra charges
    var charges_type = $(".extra_charges_type").val();
    var extra_charges = 0;
    var extra_charges_val = $(".extra_changes").val();
    if (typeof extra_charges_val != "undefined" && extra_charges_val != "" && extra_charges_val != null && !isNaN(extra_charges_val)) {
        if (charges_type == '%') {
            extra_charges = (extra_charges_val / 100) * totalWithTax;
        } else if (charges_type == 'rupees') {
            extra_charges = extra_charges_val;
        }
    }

    var finalTotalGSTPercentage = 0;
    // var is_show_cgst = $("input[type='radio'][name='final_igst']:checked").val();
    if (is_show_cgst == 'CGST') {
        finalTotalGSTPercentage = parseFloat(totalSgst) + parseFloat(totalCgst);
    } else if (is_show_cgst == 'IGST') {
        finalTotalGSTPercentage = totalGSTPercentage;

    } else {
        finalTotalGSTPercentage = 0;
    }

    // .......Grand total..........
    // var totalFinalGst = (totalGST / 100) * totalAmout;
    var fGrandTotal = (parseFloat(totalAmout) + parseFloat(finalTotalGSTPercentage) + parseFloat(extra_charges) + parseFloat(round_up)) - finalTotalDisc - parseFloat(round_down);
    $("#finalGrandTotal").html(fGrandTotal.toFixed(2));
    numberToWordsWithDecimal(fGrandTotal.toFixed(2));

}

function changeClassCounter(obj, searchClass, searchClassFull, referenceClass, newNumber) {
    var regex1 = new RegExp(searchClass + '(\\d+)');
    var regex2 = new RegExp(searchClass + '\\d+');

    $(obj).find('.' + referenceClass).each(function () {
        var classNames = $(this).attr('class').split(' ');
        var updatedClassNames = classNames.map(function (className) {
            var matches = className.match(regex1);
            if (matches && matches.length > 1 && matches[0] === searchClassFull) {
                return className.replace(regex2, searchClass + newNumber);
            }
            return className;
        });

        $(this).attr('class', updatedClassNames.join(' '));
        $(this).attr("data-index-key", newNumber);
        $(this).attr("data-key", newNumber);
    });
}

function changeClassCounterOfFields(obj, current_listing_index, updatedIndex) {

    $(obj).find(".listing-item").each(function () {
        if(typeof($(this).attr("data-unique_key")) != "undefined"){
            var uniqueKey = $(this).attr("data-unique_key");
            changeClassCounter(obj, uniqueKey+'_field', uniqueKey+'_field' + current_listing_index, uniqueKey+'_field', updatedIndex);
        }
    });

    if ($(obj).hasClass("group_rw_d")) {
        changeClassCounter(obj, 'group_nm_', 'group_nm_' + current_listing_index, 'group_name_d', updatedIndex);
    } else {
        changeClassCounter(obj, 'item_inp_', 'item_inp_' + current_listing_index, 'first_item_field', updatedIndex);
        changeClassCounter(obj, 'hsn_', 'hsn_' + current_listing_index, 'HSN_SAC_field', updatedIndex);
        changeClassCounter(obj, 'gst_rate_', 'gst_rate_' + current_listing_index, 'GST_Rate_field', updatedIndex);
        changeClassCounter(obj, 'budle_quantity_', 'budle_quantity_' + current_listing_index, 'Quantity_field', updatedIndex);
        changeClassCounter(obj, 'rate_', 'rate_' + current_listing_index, 'Rate_field', updatedIndex);
        changeClassCounter(obj, 'amount_', 'amount_' + current_listing_index, 'Amount_field', updatedIndex);
        changeClassCounter(obj, 'igst_', 'igst_' + current_listing_index, 'IGST_field', updatedIndex);
        changeClassCounter(obj, 'total_', 'total_' + current_listing_index, 'Total_field', updatedIndex);
        changeClassCounter(obj, 'cgst_', 'cgst_' + current_listing_index, 'CGST_field', updatedIndex);
        changeClassCounter(obj, 'sgst_', 'sgst_' + current_listing_index, 'SGST_field', updatedIndex);
        changeClassCounter(obj, 'inpt_inline_disc_', 'inpt_inline_disc_' + current_listing_index, 'Discount_field', updatedIndex);
        changeClassCounter(obj, 'discount_td_', 'discount_td_' + current_listing_index, 'inline_disc_td', updatedIndex);
    }
}