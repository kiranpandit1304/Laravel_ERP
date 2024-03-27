<!-- >Share Your Invoice Popup -->
<div class="modal fade twoside_modal" id="shareInvoice" tabindex="-1" role="dialog" aria-labelledby="shareInvoiceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
            </button>
            <div class="modal-body">
                <div class="setup_wrapper">
                    <h2>Share Your Invoice</h2>

                    <div class="inner_model_wrapper">
                        <div class="model_body_content">
                            <h3>Share this link via</h3>
                            <ul>
                                <li>
                                    <a href="javascript:void(0)" class="gmail share_inv_btn" onclick="shareNewInvoice(this)" data-id="email">
                                        <iconify-icon icon="clarity:email-solid"></iconify-icon>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="wp share_inv_btn" onclick="shareNewInvoice(this)" data-id="whatsup">
                                        <iconify-icon icon="logos:whatsapp-icon"></iconify-icon>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="insta share_inv_btn" onclick="shareNewInvoice(this)" data-id="sms">
                                        <iconify-icon icon="material-symbols:sms-outline"></iconify-icon>
                                    </a>
                                </li>
                            </ul>
                            <h3>Or copy link</h3>
                            <div class="input_share">
                                <input type="text" value="{{route('fn.invoice_show', [$enypt_id, $invoiceData->id])}}" id="linkInvloicecopborad_1d">
                                <button class="copyToClipboard">Copy</button>
                            </div>
                        </div>
                        <!-- <div class="com_action">
                                    <button class="nobgc" data-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button class="click_next">Done</button>
                                </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')
<script>
    function shareNewInvoice(event) {
        var share_type = $(event).attr("data-id");
        var formData = new FormData();
        formData.append('mesg_type', share_type);
        formData.append('invoice_id', $('.save_inv_id').val());

        $.ajax({
            url: APP_URL + '/api/SaleInvoiceShareAdd',
            data: formData,
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                block_gui_start();
                xhr.setRequestHeader('Authorization', 'Bearer ' + tokenString);
            },
            success: function(response) {
                block_gui_end();
                if (response.status == true) {
                    toastr.success(response?.message);
                    var data = response?.data;
                    var mesg_type = '-';
                    if(data?.mesg_type!= '' && data?.mesg_type != undefined &&  data?.mesg_type != null){
                       mesg_type = data?.mesg_type;
                    }
                    var created_at = '-';
                    if(data?.created_at!= '' && data?.created_at != undefined && data?.created_at != null){
                       created_at = data?.created_at;
                    }
                    var recipient = '-';
                    if(data?.recipient!= '' && data?.recipient != undefined && data?.recipient != null){
                       recipient = data?.recipient;
                    }
                    var mobile_no = '-';
                    if(data?.mobile_no!= '' && data?.mobile_no != undefined && !isNaN(data?.mobile_no)){
                       mobile_no = data?.mobile_no;
                    }
                    var html = '';
                    html+=' <tr>';
                    html+='                         <td>'+mesg_type+'</td>';
                    html+='                         <td>'+created_at+'</td>';
                    html+='                         <td>'+recipient+'</td>';
                    html+='                         <td>'+mobile_no+'</td>';
                    html+='                     </tr>';
                    $(".clnt_msg_body").append(html);
                    if (share_type == 'whatsup') {
                        var whats_text = response?.whats_text;
                        var customer_number = response?.customeer_number;
                        window.open(
                            'https://wa.me/' + customer_number + '/?text=' + whats_text,
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }
                } else {
                    toastr.error(response?.message)
                }
            },
            error: function(response) {
                block_gui_end();
                console.log("server side error");
            }
        })
    }

    $(document).on("click", ".copyToClipboard", function() {

        // Get the text field
        var copyText = document.getElementById("linkInvloicecopborad_1d");
        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);
        toastr.success("Link copied");
    });
</script>
@endpush