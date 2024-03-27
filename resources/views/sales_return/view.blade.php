@extends('layouts.admin')
@section('page-title')
    {{__('Sale Return Detail')}}
@endsection
@push('script-page')
    <script>
        $(document).on('click', '#shipping', function () {
            var url = $(this).data('url');
            var is_display = $("#shipping").is(":checked");
            $.ajax({
                url: url,
                type: 'get',
                data: {
                    'is_display': is_display,
                },
                success: function (data) {
                    // console.log(data);
                }
            });
        })



    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('sale.index')}}">{{__('Sale Return')}}</a></li>
    <li class="breadcrumb-item">{{ Auth::user()->saleReturnNumberFormat($sales_return->sale_id) }}</li>
@endsection

@section('content')

    @can('send purchase')
        @if($sales_return->status!=4)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row timeline-wrapper">
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-plus text-primary"></i>
                                    </div>
                                    <h6 class="text-primary my-3">{{__('Create Sale Return')}}</h6>
                                    <p class="text-muted text-sm mb-3"><i class="ti ti-clock mr-2"></i>{{__('Created on ')}}{{\Auth::user()->dateFormat($sales_return->sale_date)}}</p>
                                    @can('edit purchase')
                                        <a href="{{ route('sale_return.edit',\Crypt::encrypt($sales_return->id)) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="ti ti-pencil mr-2"></i>{{__('Edit')}}</a>

                                    @endcan
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-mail text-warning"></i>
                                    </div>
                                    <h6 class="text-warning my-3">{{__('Send Sale Return')}}</h6>
                                    <p class="text-muted text-sm mb-3">
                                        @if($sales_return->status!=0)
                                            <i class="ti ti-clock mr-2"></i>{{__('Sent on')}} {{\Auth::user()->dateFormat($sales_return->sale_date)}}
                                        @else
                                            @can('send purchase')
                                                <small>{{__('Status')}} : {{__('Not Sent')}}</small>
                                            @endcan
                                        @endif
                                    </p>

                                    @if($sales_return->status==0)
                                        @can('send purchase')
                                            <a href="{{ route('sale_return.sent',$sales_return->id) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-original-title="{{__('Mark Sent')}}"><i class="ti ti-send mr-2"></i>{{__('Send')}}</a>
                                        @endcan
                                    @endif
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="timeline-icons"><span class="timeline-dots"></span>
                                        <i class="ti ti-report-money text-info"></i>
                                    </div>
                                    <h6 class="text-info my-3">{{__('Get Paid')}}</h6>
                                    <p class="text-muted text-sm mb-3">{{__('Status')}} : {{__('Awaiting payment')}} </p>
                                    @if($sales_return->status!= 0)
                                        @can('create payment purchase')
                                            <a href="#" data-url="{{ route('sale_return.payment',$sales_return->id) }}" data-ajax-popup="true" data-title="{{__('Add Payment')}}" class="btn btn-sm btn-info" data-original-title="{{__('Add Payment')}}"><i class="ti ti-report-money mr-2"></i>{{__('Add Payment')}}</a> <br>
                                        @endcan
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endcan

    @if(\Auth::user()->type=='company')
        @if($sales->status!=0)
            <div class="row justify-content-between align-items-center mb-3">
                <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
{{--                    @if(!empty($purchasePayment))--}}
{{--                        <div class="all-button-box mx-2">--}}
{{--                            <a href="#" data-url="{{ route('bill.debit.note',$sales->id) }}" data-ajax-popup="true" data-title="{{__('Add Debit Note')}}" class="btn btn-sm btn-primary">--}}
{{--                                {{__('Add Debit Note')}}--}}
{{--                            </a>--}}
{{--                        </div>--}}

{{--                    @endif--}}
                    <div class="all-button-box mx-2">
                        <a href="{{ route('sale_return.resent',$sales_return->id) }}" class="btn btn-sm btn-primary">
                            {{__('Resend Sale Return')}}
                        </a>
                    </div>
                    <div class="all-button-box">
                        <a href="{{ route('sale_return.pdf', Crypt::encrypt($sales_return->id))}}" target="_blank" class="btn btn-sm btn-primary">
                            {{__('Download')}}
                        </a>
                    </div>
                </div>
            </div>
        @endif

    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-print">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                                    <h4>{{__('Sale Return')}}</h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                    <h4 class="invoice-number">{{ Auth::user()->saleReturnNumberFormat($sales_return->sale_id) }}</h4>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col text-end">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <div class="me-4">
                                            <small>
                                                <strong>{{__('Issue Date')}} :</strong><br>
                                                {{\Auth::user()->dateFormat($sales_return->sale_date)}}<br><br>
                                            </small>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="row">
                            @if(!empty($customer->billing_name))
                                    <div class="col">
                                        <small class="font-style">
                                            <strong>{{__('Billed To')}} :</strong><br>
                                            {{!empty($customer->billing_name)?$customer->billing_name:''}}<br>
                                            {{!empty($customer->billing_phone)?$customer->billing_phone:''}}<br>
                                            {{!empty($customer->billing_address)?$customer->billing_address:''}}<br>
                                            {{!empty($customer->billing_zip)?$customer->billing_zip:''}}<br>
                                            {{!empty($customer->billing_city)?$customer->billing_city:'' .', '}} {{!empty($customer->billing_state)?$customer->billing_state:'',', '}} {{!empty($customer->billing_country)?$customer->billing_country:''}}<br>
                                            <strong>{{__('Tax Number ')}} : </strong>{{!empty($customer->tax_number)?$customer->tax_number:''}}
                                        </small>
                                    </div>
                                @endif
                                @if(App\Models\Utility::getValByName('shipping_display')=='on')
                                    <div class="col">
                                        <small>
                                            <strong>{{__('Shipped To')}} :</strong><br>
                                            {{!empty($customer->shipping_name)?$customer->shipping_name:''}}<br>
                                            {{!empty($customer->shipping_phone)?$customer->shipping_phone:''}}<br>
                                            {{!empty($customer->shipping_address)?$customer->shipping_address:''}}<br>
                                            {{!empty($customer->shipping_zip)?$customer->shipping_zip:''}}<br>
                                            {{!empty($customer->shipping_city)?$customer->shipping_city:'' .', '}} {{!empty($customer->shipping_state)?$customer->shipping_state:'',', '}} {{!empty($customer->shipping_country)?$customer->shipping_country:''}}<br>
                                            <strong>{{__('Tax Number ')}} : </strong>{{!empty($customer->tax_number)?$customer->tax_number:''}}

                                        </small>
                                    </div>
                                @endif

                                <div class="col">
                                    <div class="float-end mt-3">

                                        {!! DNS2D::getBarcodeHTML(route('sale_return.link.copy',\Illuminate\Support\Facades\Crypt::encrypt($sales->id)), "QRCODE",2,2) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <small>
                                        <strong>{{__('Status')}} :</strong><br>
                                        <span class="purchase_status badge bg-primary p-2 px-3 rounded">{{ !empty($status->name )? $status->name :'Sent'}} </span>
                                    </small>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="font-bold mb-2">{{__('Product Summary')}}</div>
                                    <small class="mb-2">{{__('All items here cannot be deleted.')}}</small>
                                    <div class="table-responsive mt-3">
                                        <table class="table ">
                                        <tr>
                                                <th class="text-dark" data-width="40">#</th>
                                                <th class="text-dark">{{__('Product')}}</th>
                                                <th class="text-dark">{{__('Quantity')}}</th>
                                                <th class="text-dark">{{__('Rate')}}</th>
                                                <th class="text-dark"></th>
                                                <th class="text-end text-dark" width="12%">{{__('Price')}}<br>
                                                    <small class="text-danger font-weight-bold">{{__('before tax & discount')}}</small>
                                                </th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            @php
                                                $totalQuantity=0;
                                                $totalRate=0;
                                                $totalTaxPrice=0;
                                                $totalDiscount=0;
                                                $taxesData=[];
                                            @endphp

                                            @foreach($iteams as $key =>$iteam)
                                                   @php
                                                        $totalQuantity+=$iteam->quantity;
                                                        $totalRate+=$iteam->price;
                                                       
                                                    @endphp
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{!empty($iteam->product())?$iteam->product()->name:''}}</td>
                                                    <td>{{$iteam->quantity}}</td>
                                                    <td>{{number_format($iteam->price,2)}}</td>
                                                   
                                                    <td>{{!empty($iteam->description)?$iteam->description:'-'}}</td>
                                                    <td class="text-end">{{number_format(($iteam->price*$iteam->quantity),2)}}</td>
                                                </tr>
                                            @endforeach
                                            <tfoot>
                                            <tr>
                                                <td></td>
                                                <td><b>{{__('Total')}}</b></td>
                                                <td><b>{{$totalQuantity}}</b></td>
                                                <td><b>{{$totalRate}}</b></td>
                                                <td></td>
                                                <td class="text-end">{{number_format($sales_return->getSubTotal(),2)}}</td>

                                            </tr>
                                            <tr>
                                                <td colspan="6"></td>
                                                <td class="text-end"><b>{{__('Sub Total')}}</b></td>
                                                <td class="text-end">{{number_format($sales_return->getSubTotal(),2)}}</td>
                                            </tr>

                                                 <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end"><b>{{__('Discount')}}</b></td>
                                                    @php
                                                    $discount_in_pertage = ($sales_return->getSubTotal()/100) * @$sales_return->discount;
                                                    @endphp
                                                    <td class="text-end">{{number_format($discount_in_pertage,2)}} ( {{  @$sales_return->discount }} ) %</td>
                                                </tr>
                                                @php
                                                $total_tax_charges=0;
                                                $tax_in_pertage=0;
                                                @endphp

                                                @if(!empty($TaxChargesDBValues) && count($TaxChargesDBValues))
                                                   @foreach($TaxChargesDBValues as $key=>$DBchargesValues)
                                                   @php
                                                    $sub_total = $sales_return->getSubTotal();
                                                    $tax_rate = (!empty($DBchargesValues->tax_rate) ? $DBchargesValues->tax_rate : 0);
                                                    $tax_in_pertage = ($sub_total/100) * $tax_rate;
                                                    $total_tax_charges = $total_tax_charges + $tax_in_pertage;
                                                   @endphp
                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td class="text-end"><b>{{ @$DBchargesValues->charges_type_name}}</b></td>
                                                        <td class="text-end">{{number_format($tax_in_pertage, 2)}} ( {{ $tax_rate}} ) %</td>
                                                    </tr>
                                                @endforeach
                                                @endif

                                                @php
                                                  $total_shipping_charges=0;
                                                  $ship_rate=0;
                                                @endphp
                                                @if(!empty($ShippigChargesDBValues) && count($ShippigChargesDBValues))
                                                   @foreach($ShippigChargesDBValues as $key=>$DBShipValues)
                                                   @php
                                                     $ship_rate = (!empty($DBShipValues->tax_rate) ? $DBShipValues->tax_rate : 0);
                                                     $total_shipping_charges = $total_shipping_charges + $ship_rate;
                                                   @endphp
                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td class="text-end"><b>{{$DBShipValues->charges_type_name}}</b></td>
                                                        <td class="text-end">{{ number_format($ship_rate, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                                @php
                                                $grandTotal =0;
                                                $grandTotal = $sales_return->getSubTotal() + $total_tax_charges +$total_shipping_charges;
                                                $grandTotal = $grandTotal - $discount_in_pertage;
                                                @endphp
                                            <tr>
                                                <td colspan="6"></td>
                                                <td class="blue-text text-end"><b>{{__('Total')}}</b></td>
                                                <td class="blue-text text-end">{{number_format($grandTotal, 2)}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"></td>
                                                <td class="text-end"><b>{{__('Paid')}}</b></td>
                                                <td class="text-end">{{number_format(($sales_return->getTotal()-$sales_return->getDue()),2)}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"></td>
                                                <td class="text-end"><b>{{__('Due')}}</b></td>
                                                <td class="text-end">{{number_format($sales_return->getDue(),2)}}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
