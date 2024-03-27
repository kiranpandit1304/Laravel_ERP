<div class="table_upper_wrapper">
    <div class="table-responsive">
        <table id="user-list-table" class="invoice_table_main table" role="grid" aria-describedby="user-list-page-info">
            <thead>
                <tr>
                    <th scope="col" style="width: 2%;">
                        <div class="sd_check">
                            <input type="checkbox" name="layout" id="checkAllCustomer" />
                            <label class="pull-right text" for="checkAllCustomer"></label>
                        </div>
                    </th>
                    <th scope="col" style="">Date</th>
                    <th scope="col">Invoice#</th>
                    <th scope="col" style="width: 5%;">Billed To</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                    <th scope="col">Payment Date</th>
                    <th scope="col">GSTIN/UIN of Recipient</th>
                    <th scope="col">PAN</th>
                    <th scope="col">IRN Status</th>
                    <th scope="col">Invoice Email</th>
                    <th scope="col">Amount Paid in INR</th>
                    <th scope="col">TCS</th>
                    <th scope="col">TDS</th>
                    <th scope="col">Amount Due in INR</th>
                    <th scope="col">Invoice Amount in INR</th>
                    <th scope="col" style="width: 8%; text-align: right; padding-right: 3%;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($saleInvoices))
                @foreach($saleInvoices as $key=>$invoiceData)
                @php
                $amount_recived_sum = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoiceData->id)
                ->sum('amount_received');
                $total_tcs_amount = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoiceData->id)->sum('tcs_amount');
                $total_tds_amount = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoiceData->id)->sum('tds_amount');
                $total_transaction_charge = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoiceData->id)->sum('transaction_charge');
                $amount_recived = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$invoiceData->id)
                ->orderBy('id',"DESC")
                ->first();
                $final_total = (!empty($invoiceData->final_total) ? $invoiceData->final_total : 0);
                $grand_total_paid = $amount_recived_sum + $total_tcs_amount + $total_tds_amount + $total_transaction_charge;
                $due_amount = (float)$final_total - (float)$grand_total_paid;
                @endphp
                <tr>
                    <td>
                        <div class="sd_check">
                            <input type="checkbox" class="customerChkBox" name="customerChkBox" data-id="<?= $key ?>" value="{{$invoiceData->id}}" id="tb{{$key}}" />
                            <label class="pull-right text" for="tb{{$key}}"></label>
                        </div>
                    </td>
                    <td>{{@$invoiceData->invoice_date}}</td>
                    <td>{{@$invoiceData->invoice_no}}</td>
                    <td>{{@$invoiceData->customer_name}}</td>
                    <td>{{number_format(@$invoiceData->final_total, 2)}}</td>
                    @php
                    $statusClass = 'st_yellow';
                    if($invoiceData->payment_status == 'Paid'){
                    $statusClass = 'st_green';
                    }elseif($invoiceData->payment_status == 'Unpaid'){
                    $statusClass = 'st_red';
                    }

                    $is_over_due = '' ;
                    if(!empty($invoiceData->due_date)){
                    $current_date1 = date("Y-m-d");
                    $current_date = date("Y-m-d", strtotime($current_date1));
                    $due_date = date("Y-m-d", strtotime($invoiceData->due_date));
                    if($current_date > $due_date){
                    $is_over_due='Overdue';
                    }
                    }
                    @endphp
                    <td>
                        @if(!empty($is_over_due) && $invoiceData->payment_status != 'Paid')
                        <span class="st_red">Overdue</span>
                        @endif
                        <span class="{{$statusClass}}">{{!empty($invoiceData->payment_status) ? $invoiceData->payment_status : 'Pending'}}</span><br />{{@$invoiceData->due_date}}
                    </td>
                    <td>{{ !empty($grand_total_paid) ? @$invoiceData->invoice_date : ''}}</td>
                    <td>{{@$invoiceData->gst_no}}</td>
                    <td>{{@$invoiceData->pan_no}}</td>
                    <td>-</td>
                    <td>Not Sent</td>
                    <td>{{number_format(@$grand_total_paid, 2)}}</td>
                    <td>{{ number_format(@$total_tcs_amount, 2) }}</td>
                    <td>{{ number_format(@$total_tds_amount, 2) }}</td>
                    @php
                    $due_amount = $due_amount > 0 ? $due_amount : 0;
                    @endphp
                    <td>{{  number_format(@$due_amount, 2) }}</td>
                    <td>{{number_format(@$invoiceData->final_total, 2)}}</td>
                    <td style="width: 8%; text-align: right; padding-right: 3%;">
                        <div class="action_btn_a">
                            <a href="{{route('fn.invoice_step3', [$enypt_id, $invoiceData->id])}}" target="_blank" class="edit_cta"><iconify-icon icon="ion:open-outline"></iconify-icon> Open</a>
                            @if($is_deleted)
                            <a href="javascript:void(0)" class="edit_cta recover_inv" data-id="{{@$invoiceData->id}}"><iconify-icon icon="mdi:restore"></iconify-icon> Recover</a>
                            <a href="{{route('fn.invoice_step1', [$enypt_id, $invoiceData->id, 'inv_status=duplicate'])}}" class="edit_cta" title="{{@$invoiceData->id}}"><iconify-icon icon="fad:duplicate"></iconify-icon> Duplicate</a>
                            @else
                            @if($invoiceData->payment_status != 'Cancelled')
                            <a href="{{route('fn.invoice_step1', [$enypt_id, $invoiceData->id])}}" target="_blank" class="edit_cta {{!empty($grand_total_paid) ? 'showEditConfirmAlert' : ''}}"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a>
                            @endif
                            @if(!empty($invoiceData->payment_status) && $invoiceData->payment_status != 'Paid')
                            <a href="javascript:void(0)" class="edit_cta show_payment_btn" title="{{@$invoiceData->id}}" data-page="first" data-pid="{{@$invoiceData->invoice_no}}" data-total="{{@$invoiceData->final_total}}" data-cust="{{@$invoiceData->company_name}}"><iconify-icon icon="teenyicons:tick-circle-outline"></iconify-icon> Mark Paid</a>
                            @endif
                            <a href="{{route('fn.invoice_step1', [$enypt_id, $invoiceData->id, 'inv_status=duplicate'])}}" target="_blank" class="edit_cta "><iconify-icon icon="fad:duplicate"></iconify-icon> Duplicate</a>

                            <!-- <a href="javascript:void(0)" class="edit_cta duplicate_inv" title="{{@$invoiceData->id}}"><iconify-icon icon="fad:duplicate"></iconify-icon> Duplicate</a> -->
                            <!-- <a href="javascript:void(0)" class="edit_cta delte_invoice_btn" data-id="{{@$invoiceData->id}}"><iconify-icon icon="typcn:delete"></iconify-icon> Delete</a>
                            <a href="javascript:void(0)" class="edit_cta remove_invoice_payment_btn" data-id="{{@$invoiceData->id}}"><iconify-icon icon="ep:remove"></iconify-icon> Remove payment</a>
                            <a href="javascript:void(0)" class="edit_cta cancel_invoice_btn " data-id="{{@$invoiceData->id}}"><iconify-icon icon="material-symbols:cancel-outline"></iconify-icon> Cancel</a>
                            <a href="javascript:void(0)" class="edit_cta copyToClipboard1"  onclick="copyToClipboard(this)" data-id="{{@$invoiceData->id}}"><iconify-icon icon="basil:copy-solid"></iconify-icon> Copy</a> -->
                            <input class="hidden" type="text" value="{{route('fn.invoice_show', [$enypt_id, $invoiceData->id])}}" id="linkInvloicecopborad_{{$invoiceData->id}}">
                            <?php
                            $inv_url  =  urlencode(route('fn.invoice_with_shorturl', [$invoiceData->id]));
                            $link  = '<a href="' . $inv_url . '"> click here</a>';
                            $whats_text = ' Dear ' . @$invoiceData->customer_name . ', kindly note that Invoice no: ' . $invoiceData->invoice_no . ' from ' . @$commonData['active_business_data']->business_name . ' remains outstanding.Link to access invoice: ' . $inv_url;
                            // $whats_text = $whats_text;
                            // https://wa.me/{{@$invoiceData->billing_phone}}/?text={{$whats_text}}
                            ?>
                            <div class="popover-block-container">
                                <!-- <button class="btn" data-toggle="popover" data-id="{{@$invoiceData->id}}" data-popover-content="#popover-content-1">Click Me</button> -->
                                <button class="edit_cta pop_dynamic_data" type="button" data-id="{{@$invoiceData->id}}" data-popover-content="#unique-id-{{@$invoiceData->id}}" data-toggle="popover" data-placement="left"><iconify-icon icon="ri:more-2-fill"></iconify-icon> More</button>
                                <div id="unique-id-{{@$invoiceData->id}}" style="display:none;">
                                    <div class="popover-body">
                                        <ul>
                                            <li class="menu_list_item">
                                                <a href="{{route('fn.invoice_step3', [$enypt_id, $invoiceData->id])}}" target="_blank">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined">open_in_new</i>
                                                        <span>Open</span>
                                                    </div>
                                                </a>
                                            </li>
                                            @if($invoiceData->payment_status != 'Cancelled')
                                            <li class="menu_list_item">
                                                <a href="{{route('fn.invoice_step1', [$enypt_id, $invoiceData->id])}}" target="_blank">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined">edit</i>
                                                        <span>Edit</span>
                                                    </div>
                                                </a>
                                            </li>
                                            @endif
                                   
                                            <li class="menu_list_item">
                                                <a href="javascript:void(0" class="shareInvoiceOnMail" title="{{@$invoiceData->id}}" >
                                                    <div class="inner_item" >
                                                        <i class="material-symbols-outlined">mail</i>
                                                        <span>Send Email</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="menu_list_item">
                                                <a href="javascript:void(0)" class="shareInvoiceOnWhatsApp" title="{{@$invoiceData->id}}">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined">chat</i>
                                                        <span>Send Whatsapp</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="menu_list_item">
                                                <a href="#">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined">note_add</i>
                                                        <span>Create Credit Note</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="menu_list_item">
                                                <a href="#">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined">difference</i>
                                                        <span>Create Debit Note</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="menu_list_item">
                                                <a href="#">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined">description</i>
                                                        <span>Generate Delivery Challan</span>
                                                    </div>
                                                </a>
                                            </li>
                                        @if(!empty($invoiceData->payment_status) && $invoiceData->payment_status != 'Paid')
                                            <li class="menu_list_item">
                                                <a href="javascript:void(0)" class="show_payment_btn" title="{{@$invoiceData->id}}" data-page="first" data-pid="{{@$invoiceData->invoice_no}}">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined">check_circle</i>
                                                        <span>Mark Paid</span>
                                                    </div>
                                                </a>
                                            </li>
                                            @endif
                                            <li class="menu_list_item">
                                                <a href="{{route('fn.invoice_step1', [$enypt_id, $invoiceData->id, 'inv_status=duplicate'])}}" target="_blank">
                                                    <div class="inner_item">
                                                    <i class="material-symbols-outlined" title="{{@$invoiceData->id}}">content_copy</i>
                                                        <!-- <i class="material-symbols-outlined duplicate_inv" title="{{@$invoiceData->id}}">content_copy</i> -->
                                                        <span>Duplicate</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="menu_list_item">
                                                <a href="javascript:void()" class="copyToClipboard" onclick="copyToClipboard(this)" title="{{@$invoiceData->id}}">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined ">share</i>
                                                        <span>Copy Invoice link1</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="menu_list_item">
                                                <a target="_blank" href="{{url('/api/SaleInvoice/Pdf/'.$invoiceData->id .'/1/'.$auth_user->id)}}">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined">file_download</i>
                                                        <span>Download</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="menu_list_item">
                                                <a href="javascript:void(0)" title="{{@$invoiceData->id}}" class="delte_invoice_btn">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined">delete</i>
                                                        <span>Delete</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="menu_list_item">
                                                <a href="javascript:void(0)" class="cancel_invoice_btn" title="{{@$invoiceData->id}}">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined">cancel</i>
                                                        <span>Cancel</span>
                                                    </div>
                                                </a>
                                            </li>
                                            @if(!empty($grand_total_paid))
                                            <li class="menu_list_item">
                                                <a href="javascript:void(0)" class="remove_invoice_payment_btn" title="{{@$invoiceData->id}}">
                                                    <div class="inner_item">
                                                        <i class="material-symbols-outlined">cancel</i>
                                                        <span>Remove Payment</span>
                                                    </div>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>

                                    </div>

                                </div>
                            </div>
                            @endif
                        </div>
                        <input type="hidden" class="delte_invoice_btn2" value="{{@$invoiceData->id}}" />

                    </td>

                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@if($saleInvoices->hasPages())
<div class="tfooter">
    <div id="user-list-page-info" class="col-md-6">
        <span>Showing {{$saleInvoices->firstItem()}} to {{$saleInvoices->lastItem()}} of {{$saleInvoices->total()}} saleInvoices</span>
    </div>
    <div class="col-md-6">
        <ul class="pagination justify-content-end mb-0">
            {!! $saleInvoices->links( "pagination::bootstrap-4") !!}
        </ul>
    </div>
</div>
@endif
@push('custom-scripts')
@endpush