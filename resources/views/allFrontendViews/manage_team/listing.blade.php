<div class="table-responsive">
    <table id="user-list-table" class="table" role="grid" aria-describedby="user-list-page-info">
        <thead>
            <tr>
                <!-- <th scope="col" style="width: 4%;">
                    <div class="sd_check">
                        <input type="checkbox" name="layout" id="tb1" />
                        <label class="pull-right text" for="tb1"></label>
                    </div>
                </th> -->
                <th scope="col" style="width: 4%;">
                        <div class="sd_check">
                            <input type="checkbox" name="layout" id="checkAllCustomer" />
                            <label class="pull-right text" for="checkAllCustomer"></label>
                        </div>
                    </th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Status</th>
                <th scope="col" style="width: 4%; text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invitees as $key=>$invitee)
            <tr>
                <td>
                <div class="sd_check">
                            <input type="checkbox" class="customerChkBox" name="customerChkBox" data-id="<?= $key ?>" value="{{$invitee->id}}" id="tb{{$key}}" />
                            <label class="pull-right text" for="tb{{$key}}"></label>
                        </div>
                </td>
                <td class="offcanvasTeamEditView" data-id="{{@$invitee->id}}">{{@$invitee->name}}</td>
                <td class="offcanvasTeamEditView" data-id="{{@$invitee->id}}">{{@$invitee->email}}</td>
                <td  class="offcanvasTeamEditView" data-id="{{@$invitee->id}}"><span class="{{!empty($invitee->invitee_status) && $invitee->invitee_status == 'Pending' ? 'st_yellow' : 'st_green'}}"> {{$invitee->invitee_status}} </span></td>
                <td>
                    <div class="action_btn_a">
                        @if($invitee->invitee_status=='Pending')
                        @if(!empty($invitee->link))
                        <input class="hide-d" type="text" value="{{@$invitee->link}}" id="linkcopborad_{{$key}}" disabled>
                        <a href="#" onclick="copyTableText(this)" data-id="{{@$key}}"><iconify-icon icon="basil:copy-outline"></iconify-icon></a>
                        @endif
                        @else
                        <a href="#" id="openeditcanvas" class="edit_cta" data-toggle="tooltip" data-placement="top" onclick="editTeamMember(this)" data-id="{{@$invitee->id}}" data-original-title="Edit"><iconify-icon icon="material-symbols:edit"></iconify-icon> Edit</a>
                        @endif
                        <!-- <a href="#" class="del_cta"data-toggle="" data-placement="top" data-original-title="Delete"><iconify-icon icon="mingcute:delete-2-line"></iconify-icon></a> -->
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if($invitees->hasPages())
<div class="tfooter">
    <div id="user-list-page-info" class="col-md-6">
        <span>Showing {{$invitees->firstItem()}} to {{$invitees->lastItem()}} of {{$invitees->total()}} invitees</span>
    </div>
    <div class="col-md-6">
        <ul class="pagination justify-content-end mb-0">
            {!! $invitees->links( "pagination::bootstrap-4") !!}
        </ul>
    </div>
</div>
@endif
</div>