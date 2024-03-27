<div class="table_upper_wrapper">
    <div class="add_field_drop">
        <a href="#" class="search-toggle dropdown-toggle circle-hover" id="dropdownMenuButton01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <iconify-icon icon="pajamas:plus"></iconify-icon>
        </a>
        <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton01">
            <div class="card shadow-none m-0">
                <div class="card-body p-0">
                    <div class="p-3">
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="business_col" name="name" id="showshipping" checked />
                                <label class="pull-right text" for="showshipping">Business/Customer name</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="gst_col" name="tax_number" id="showshipping1" checked />
                                <label class="pull-right text" for="showshipping1">GST</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="email_col" name="email" id="showshipping2" checked />
                                <label class="pull-right text" for="showshipping2">Email</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="nature_col" name="nature_of_business" id="showshipping3" checked />
                                <label class="pull-right text" for="showshipping3">Nature of Business</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="contact_col" name="contact_person" id="showshipping4" />
                                <label class="pull-right text" for="showshipping4">Contact Person</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="phone_col" name="contact_number" id="showshipping5" />
                                <label class="pull-right text" for="showshipping5">Contact Number</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="upi_col" name="upi_col" id="showshipping6" checked />
                                <label class="pull-right text" for="showshipping6">UPI</label>
                            </div>
                        </a>
                        <a href="#" class="iq-sub-card pt-0">
                            <div class="sd_check">
                                <input type="checkbox" class="tabel_col_sorting" value="payment_col" name="payment_col" id="showshipping7" checked />
                                <label class="pull-right text" for="showshipping7">Payment Terms</label>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="user-list-table" class="table" role="grid" aria-describedby="user-list-page-info">
            <thead>
                <tr>
                    <th scope="col" style="width: 4%;">
                        <div class="sd_check">
                            <input type="checkbox" name="layout" id="checkAllCustomer" />
                            <label class="pull-right text" for="checkAllCustomer"></label>
                        </div>
                    </th>
                    <th class="business_col" scope="col">Business/Vendor name</th>
                    <th class="gst_col" scope="col">GST</th>
                    <th class="email_col" scope="col">Email</th>
                    <th class="nature_col" scope="col">Nature of Business</th>
                    <th class="upi_col" scope="col">UPI</th>
                    <th class="payment_col" scope="col">Payment Terms</th>
                    <th class="contact_col hide-d" scope="col">Contact Person</th>
                    <th class="phone_col hide-d" scope="col">Contact Number</th>
                    <th scope="col" style="width: 8%;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venders as $key=>$customer)
                @php
                $is_register_user = \App\Models\User::where('email',$customer->email)->first();
                @endphp
                <tr data-bs-toggle="offcanvas" href="#offcanvasExample1" role="button" aria-controls="offcanvasExample">
                    <td>
                        <div class="sd_check">
                            <input type="checkbox" class="customerChkBox" name="customerChkBox" data-id="<?= $key ?>" value="{{$customer->customer_id}}" id="tb{{$key}}" />
                            <label class="pull-right text" for="tb{{$key}}"></label>
                        </div>
                    </td>
                    <td class="business_col offcanvasModal" data-id="{{@$customer->customer_id}}"> {{@$customer->name}}
                        @if(!empty($customer->email) && !empty($is_register_user))
                        <span class="veryfied" data-toggle="tooltip" data-placement="top" data-original-title="This is unesync user"><iconify-icon icon="mdi:tick-decagram"></iconify-icon></span>
                        @endif
                    </td>
                   <td class="gst_col offcanvasModal" data-id="{{@$customer->customer_id}}"  data-id="{{@$customer->customer_id}}" >{{!empty($customer->tax_number) ? $customer->tax_number : '-' }}</td>
                    <td class="email_col offcanvasModal" data-id="{{@$customer->customer_id}}" >{{!empty($customer->email) ? $customer->email : '-'}}</td>
                    <td class="nature_col offcanvasModal" data-id="{{@$customer->customer_id}}" >{{!empty($customer->nature_of_business) ? $customer->nature_of_business : '-' }}</td>
                    <td class="upi_col offcanvasModal" data-id="{{@$customer->customer_id}}" >{{!empty($customer->upi) ? $customer->upi : '-'}}</td>
                    <td class="payment_col offcanvasModal" data-id="{{@$customer->customer_id}}" >{{ !empty($customer->payment_terms_days) ? $customer->payment_terms_days : '-' }}</td>
                    <td class="contact_col hide-d offcanvasModal" data-id="{{@$customer->customer_id}}" >{{!empty($customer->contact_person) ? $customer->contact_person : '-' }}</td>
                    <td class="phone_col hide-d offcanvasModal" data-id="{{@$customer->customer_id}}" >{{!empty($customer->billing_phone) ? $customer->billing_phone : '-' }}</td>
                    
                    <td>
                        <div class="action_btn_a">
                         @if(@$has_edit_permission)
                            <a href="javascript:void(0)" class="edit_cta offcanvasModal" data-id="{{@$customer->customer_id}}" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a>
                           @else
                           <a href="javascript:void(0)" class="edit_cta offcanvasModal" data-id="{{@$customer->customer_id}}" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><iconify-icon icon="material-symbols:edit"></iconify-icon> View</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($venders->hasPages())
    <div class="tfooter">
        <div id="user-list-page-info" class="col-md-6">
            <span>Showing {{$venders->firstItem()}} to {{$venders->lastItem()}} of {{$venders->total()}} venders</span>
        </div>
        <div class="col-md-6">
            <ul class="pagination justify-content-end mb-0">
                {!! $venders->links( "pagination::bootstrap-4") !!}
            </ul>
        </div>
    </div>
    @endif
</div>