<?php

namespace App\Exports;

use App\Models\Vender;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VendorExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;
    public function __construct($request = '')
    {
        $this->request = $request;
    }
    public function collection()
    {
        $request = $this->request;
        if(!empty($request) && $request['id'] != '')
        {
            $data = Vender::whereIn('venders.id',$request['id']);
            $data->where('venders.business_id',$request['business_id']);
            //$data->where('venders.platform',$request['platform']);
           // $data->where('venders.guard',$request['guard']);
            $data->leftjoin('venders_bank_details','venders.id','venders_bank_details.vendor_id');
            $data->select('venders.name','venders.tax_number','venders.email','venders.nature_of_business','venders.contact_person','venders.billing_phone as contact','venders_bank_details.upi','venders_bank_details.payment_terms_days');
            $data = $data->get();

        }else{
            $data = Vender::leftjoin('venders_bank_details','venders.id','venders_bank_details.vendor_id');
            $data->where('venders.business_id',$request['business_id']);
            //$data->where('venders.created_by',$request['user_id']);
            //$data->where('venders.platform',$request['platform']);
            $data->where('venders.guard',$request['guard']);
            $data->select('venders.name','venders.tax_number','venders.email','venders.nature_of_business','venders.contact_person','venders.billing_phone as contact','venders_bank_details.upi','venders_bank_details.payment_terms_days');
            $data = $data->get();
        }
       

        foreach($data as $k => $vendor)
        {
            unset($vendor->password, $vendor->lang, $vendor->created_by, $vendor->email_verified_at, $vendor->remember_token);
            $data[$k]["name"]     = $vendor->name;
            $data[$k]["tax_number"]     = $vendor->tax_number;
            $data[$k]["email"]     = $vendor->email;
            $data[$k]["nature_of_business"]     = $vendor->nature_of_business;
            $data[$k]["contact_person"]     = $vendor->contact_person;
            $data[$k]["contact"]     = $vendor->contact;
            $data[$k]["upi"]     = $vendor->upi;
            $data[$k]["payment_terms_days"]     = $vendor->payment_terms_days;
        }
       
        return $data;
    }

    public function headings(): array
    {
        return [
            "Name",
            "Gst No",
            "Email",
            "Nature of Business",
            "Contact Person",
            "Contact Number",
            "UPI",
            "Payment Terms",
        ];
    }
}
