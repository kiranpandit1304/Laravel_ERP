<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
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
            $data = Customer::whereIn('customers.id',$request['id']);
            $data->where('customers.business_id',$request['business_id']);
            // $data->where('customers.platform',$request['platform']);
            // $data->where('customers.guard',$request['guard']);
            $data->leftjoin('customer_bank_details','customers.id','customer_bank_details.client_id');
            $data->select('customers.name','customers.tax_number','customers.email','customers.nature_of_business','customers.contact_person','customers.billing_phone as contact','customer_bank_details.upi','customer_bank_details.payment_terms_days');
            $data = $data->get();

        }else{
            $data = Customer::leftjoin('customer_bank_details','customers.id','customer_bank_details.client_id');
            $data->where('customers.created_by',$request['user_id']);
            $data->where('customers.business_id',$request['business_id']);
            //$data->where('customers.platform',$request['platform']);
            //$data->where('customers.guard',$request['guard']);
            $data->select('customers.name','customers.tax_number','customers.email','customers.nature_of_business','customers.contact_person','customers.billing_phone as contact','customer_bank_details.upi','customer_bank_details.payment_terms_days');
            $data = $data->get();
        }
       

        foreach($data as $k => $customer)
        {
            unset($customer->password, $customer->lang, $customer->created_by, $customer->email_verified_at, $customer->remember_token);
            $data[$k]["name"]     = $customer->name;
            $data[$k]["tax_number"]     = $customer->tax_number;
            $data[$k]["email"]     = $customer->email;
            $data[$k]["nature_of_business"]     = $customer->nature_of_business;
            $data[$k]["contact_person"]     = $customer->contact_person;
            $data[$k]["contact"]     = $customer->contact;
            $data[$k]["upi"]     = $customer->upi;
            $data[$k]["payment_terms_days"]     = $customer->payment_terms_days;
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
