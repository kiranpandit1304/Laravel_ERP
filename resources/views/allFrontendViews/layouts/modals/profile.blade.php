 <!-- Complete Profile Popup -->
 <div class="modal fade twoside_modal" id="cprofilePopup" tabindex="-1" role="dialog" aria-labelledby="cprofilePopupLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">×</span>
             </button>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-lg-5 col-sm-5 col-xs-12">
                         <div class="team_list">
                             <div class="tl_header">
                                 <h5>Process</h5>
                             </div>
                             <div class="tlist">
                                 <ul class="step-tab-items">
                                     <li class="step-item active">
                                         <span>
                                             <iconify-icon icon="iconoir:profile-circle"></iconify-icon>
                                         </span>
                                         <div class="side_text">
                                             <h6>Personal Information</h6>
                                             <p>Enter your personal information</p>
                                         </div>
                                     </li>
                                     <li class="step-item">
                                         <span>
                                             <iconify-icon icon="material-symbols:business-center-outline"></iconify-icon>
                                         </span>
                                         <div class="side_text">
                                             <h6>Business information</h6>
                                             <p>Enter your business information</p>
                                         </div>
                                     </li>
                                     <li class="step-item hidden">
                                         <span>
                                             <iconify-icon icon="mdi:theme-outline"></iconify-icon>
                                         </span>
                                         <div class="side_text">
                                             <h6>Business information</h6>
                                             <p>Personalization your profile</p>
                                         </div>
                                     </li>
                                     <li class="step-item hidden">
                                         <span>
                                             <iconify-icon icon="mdi:theme-outline"></iconify-icon>
                                         </span>
                                         <div class="side_text">
                                             <h6>Business information</h6>
                                             <p>Personalization your profile</p>
                                         </div>
                                     </li>
                                     <li class="step-item">
                                         <span>
                                             <iconify-icon icon="mdi:theme-outline"></iconify-icon>
                                         </span>
                                         <div class="side_text">
                                             <h6>Personalization</h6>
                                             <p>Personalization your profile</p>
                                         </div>
                                     </li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-7 col-sm-7 col-xs-12 flush">
                         <div class="shinvite">
                             <div class="shi_header">
                                 <h5>Edit Profile</h5>
                                 <a href="#"><iconify-icon icon="ph:info"></iconify-icon></a>
                             </div>
                             <div class="shi_body">
                                 <div class="steps">
                                     <form action="javascript:void(0)" method="post" id="profileForm">
                                         <div class="step-tabs">
                                             <div class="step-tab active" id="step-01">
                                                 <div class="row">
                                                     <div class="form-group col-sm-6">
                                                         <input type="text" class="form-control" name="first_name" id="fname" value="" placeholder="First Name" required>
                                                     </div>
                                                     <div class="form-group col-sm-6">
                                                         <input type="text" class="form-control" name="last_name" id="lname" value="" placeholder="Last Name" required>
                                                     </div>
                                                 </div>
                                                 <div class="row">
                                                     <div class="form-group col-sm-12">
                                                         <!-- <label for="fname">Email:</label> -->
                                                         <input type="email" class="form-control" name="email" id="email" value="" placeholder="Email" required>
                                                     </div>
                                                 </div>
                                                 <div class="form-submit text-right">
                                                 <button class="form-btn prof_first_btn" type="button">Next <iconify-icon icon="material-symbols:arrow-forward-rounded"></iconify-icon></button>
                                                     <!-- <button class="form-btn" type="button" tab-target="step-02">Next <iconify-icon icon="material-symbols:arrow-forward-rounded"></iconify-icon></button> -->
                                                 </div>
                                             </div>
                                             <div class="step-tab" id="step-02">
                                                 <div class="gst_btns">
                                                     <a href="#" tab-target="step-022" class="is_gst" data-val="yes">
                                                         <span><img src="{{ asset('unsync_assets/assets/images/taxes.png') }}" /></span>
                                                         Yes, I have GST number
                                                     </a>
                                                     <a href="#" tab-target="step-03" class="is_gst" data-val="no">
                                                         <span><img src="{{ asset('unsync_assets/assets/images/taxes.png') }}" /></span>
                                                         No, I don't have GST number
                                                     </a>
                                                 </div>
                                                 <div class="form-submit grid-2">
                                                     <button type="button" class="form-btn" tab-target="step-01"><iconify-icon icon="material-symbols:arrow-back-rounded"></iconify-icon> Previous</button>
                                                     <!-- <button type="button" class="form-btn" tab-target="step-022">Next <iconify-icon icon="material-symbols:arrow-forward-rounded"></iconify-icon></button> -->
                                                 </div>
                                             </div>
                                             <div class="step-tab" id="step-022">
                                                 <div class="row">
                                                     <div class="form-group col-sm-12">
                                                         <!-- <label for="fname">Enter GST number</label> -->
                                                         <input type="text" class="form-control" name="gst_no" id="gst_number" value="" placeholder="Enter GST number">
                                                     </div>
                                                 </div>
                                                 <div class="form-submit grid-2">
                                                     <button type="button" class="form-btn" tab-target="step-02"><iconify-icon icon="material-symbols:arrow-back-rounded"></iconify-icon> Previous</button>
                                                     <button type="button" class="form-btn get_gst_data">Next <iconify-icon icon="material-symbols:arrow-forward-rounded"></iconify-icon></button>
                                                     <!-- <button type="button" class="form-btn get_gst_data" tab-target="step-03">Next <iconify-icon icon="material-symbols:arrow-forward-rounded"></iconify-icon></button> -->
                                                 </div>
                                             </div>
                                             <div class="step-tab" id="step-03">
                                                 <div class="row">
                                                     <div class="form-group col-sm-6">
                                                         <!-- <label for="fname">Business Name:</label> -->
                                                         <input type="text" class="form-control" name="business_name" id="business_name" value="" placeholder="Business Name">
                                                     </div>
                                                     <div class="form-group col-sm-6">
                                                         <!-- <label for="fname">Brand Name:</label> -->
                                                         <input type="text" class="form-control" name="brand_name" id="brand_name" value="" placeholder="Brand Name">
                                                     </div>
                                                 </div>
                                                 <div class="row">
                                                     <div class="form-group col-sm-12">
                                                         <!-- <label for="fname">Address:</label> -->
                                                         <input type="text" name="address" id="address" placeholder="Enter Street Address">
                                                     </div>
                                                 </div>
                                                 <div class="row">
                                                     <div class="form-group col-sm-6">
                                                         <select class="form-select profileCountry  " id="profilecountrydropdown" name="country_id" aria-label="Default select shipping_country">
                                                         @foreach($countryList as $country)
                                                             <option value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                                             @endforeach
                                                         </select>
                                                     </div>
                                                     <div class="form-group col-sm-6">
                                                         <select class="form-select  profileState " id="profilestatedropdown" name="state_id" aria-label="Default select state_id">
                                                         <option value="">Select State</option>
                                                             @foreach($stateList as $state)
                                                             <option value="{{$state->id}}">{{$state->name}}</option>
                                                             @endforeach
                                                         </select>
                                                     </div>
                                                 </div>
                                                 <div class="row mt-4">
                                                     <div class="form-group col-sm-12">
                                                         <!-- <label for="fname">Address:</label> -->
                                                         <input type="text" name="pan_card" id="pan_card" placeholder="PAN">
                                                     </div>
                                                 </div>
                                                 <div class="form-submit grid-2">
                                                     <button type="button" class="form-btn" tab-target="step-02"><iconify-icon icon="material-symbols:arrow-back-rounded"></iconify-icon> Previous</button>
                                                     <button type="button" class="form-btn sec_last_btn" >Next <iconify-icon icon="material-symbols:arrow-forward-rounded"></iconify-icon></button>
                                                 </div>
                                             </div>
                                             <div class="step-tab" id="step-04">
                                                 <label class="cabinet center-block">
                                                     <figure>
                                                         <img src="" class="gambar img-responsive img-thumbnail" id="item-img-output" />
                                                         <figcaption>
                                                             <iconify-icon icon="material-symbols:image-outline"></iconify-icon>
                                                             Upload Logo
                                                         </figcaption>
                                                     </figure>
                                                     <input type="file" class="item-img file center-block" id="profile_photo" name="profile" />
                                                 </label>

                                                 <div class="form-submit grid-2">
                                                     <button type="button" class="form-btn" tab-target="step-03"><iconify-icon icon="material-symbols:arrow-back-rounded"></iconify-icon> Previous</button>
                                                     <button type="submit" class="form-btn">Submit <iconify-icon icon="charm:tick"></iconify-icon></button>
                                                 </div>
                                             </div>
                                         </div>
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @push('custom-scripts')
 <!-- <script src="https://code.jquery.com/jquery-3.6.3.min.js"
  integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
  crossorigin="anonymous"></script> -->
  <script>
    var state_list = <?= json_encode($stateList) ?>;
    </script>
 <script src="{{asset('js/custom/jquery.validate.min.js')}}"></script>
 <script src="{{asset('js/custom/profile.js')}}"></script>
 @endpush