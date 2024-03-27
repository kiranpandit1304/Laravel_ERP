<?php

namespace App\Exports;

use App\Models\Send_invite;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InviteExport implements FromCollection, WithHeadings
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
            $data = Send_invite::whereIn('send_invite.id',$request['id']);
            $data->where('send_invite.business_id',$request['business_id']);
            $data->select('name','email','invitee_status');
            $data = $data->get();

        }else{
            $data = Send_invite::where('send_invite.business_id',$request['business_id']);
            $data->select('name','email','invitee_status');
            $data = $data->get();
        }
       

        foreach($data as $k => $invite)
        {
            $data[$k]["name"]     = $invite->name;
            $data[$k]["email"]     = $invite->email;
            $data[$k]["invitee_status"]     = $invite->invitee_status;
        }
       
        return $data;
    }

    public function headings(): array
    {
        return [
            "Name",
            "Email",
            "Status",
        ];
    }
}
