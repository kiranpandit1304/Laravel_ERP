 <!-- Create new Business - Bottom Full Screen Popup -->
 <div class="cibsp" id="createnewbusiness">
     <form action="javascript:void(0)" method="post" id="addBusinessForm">
         <div class="cibsp_header">
             <a href="#" class="close_cibsp" id="close_cibsp"><iconify-icon icon="material-symbols:close-rounded"></iconify-icon></a>
             <h2>Create New Business</h2>
             <button onclick="saveNewBusiness(this)">Create</button>
         </div>
         <div class="mini_continer">
             <div class="cibsp_body">
                 <div class="inner_model_wrapper">
                     <div class="create_bb comn_card">
                         <div class="row">
                             <div class="col-sm-9">
                                 <div class="form-group">
                                     <label>
                                         <input type="email" class="email" name="email" required  id="" value="" placeholder="Email">
                                         <span>Email</span>
                                     </label>
                                 </div>
                                 <div class="form-group">
                                     <label class="d-block">Have GST number?</label>
                                     <div class="custom-control custom-radio custom-control-inline">
                                         <input type="radio" id="customRadio8" name="is_gst" value="1" class="custom-control-input">
                                         <label class="custom-control-label" for="customRadio8"> Yes, I have </label>
                                     </div>
                                     <div class="custom-control custom-radio custom-control-inline">
                                         <input type="radio" id="customRadio9" name="is_gst" value="0" class="custom-control-input" checked="">
                                         <label class="custom-control-label" for="customRadio9"> No, I don't have </label>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group col-sm-3">
                                 <div class="avatar-upload">
                                     <div class="avatar-edit">
                                         <input type="file" name="business_logo" class="imageUpload" accept=".png, .jpg, .jpeg" />
                                         <a href="#" class="editLink"><iconify-icon class="editIcon" icon="bi:camera-fill"></iconify-icon> Upload Logo</a>
                                     </div>
                                     <div class="avatar-preview">
                                         <div class="imagePreview iprev" style='background-image: url("{{asset('unsync_assets/assets/images/image_placeholder.jpg')}}")'></div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="row have_gst">
                             <div class="form-group col-sm-12">
                                 <label>
                                     <input type="text" class="gst_no get_business_gst_data" name="gst_no"  id="" value="" placeholder="Enter GST number">
                                     <span>Enter GST number</span>
                                 </label>
                             </div>
                         </div>
                         <div class="row">
                             <div class="form-group col-sm-6">
                                 <label>
                                     <input type="text" class="business_name" name="business_name"  id="" value="" placeholder="Business Name">
                                     <span>Business Name</span>
                                 </label>
                             </div>
                             <div class="form-group col-sm-6">
                                 <label>
                                     <input type="text" class="brand_name" name="brand_name" required="" id="" value="" placeholder="Brand name">
                                     <span>Brand name</span>
                                 </label>
                             </div>
                         </div>

                         <div class="row">
                             <div class="form-group col-sm-12">
                                 <label>
                                     <input type="text" class="street_address" name="street_address" required="" id="" placeholder="Street Address" />
                                     <span>Street Address</span>
                                 </label>
                             </div>
                         </div>
                         <div class="row">
                             <div class="form-group col-sm-6">
                                 <select class="js-example-placeholder-single-cuntry js-states form-control country_id" name="country_id">
                                     @foreach($commonData['countryList'] as $country)
                                     <option value="{{@$country->id}}" value="{{@$country->id}}" {{ $country->id == 101 ? 'selected' : ''}}>{{@$country->name}}</option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="form-group col-sm-6">
                                 <select class="js-example-placeholder-single-state js-states form-control state_id" name="state_id">
                                     <option></option>
                                     @foreach($commonData['stateList']  as $state)
                                     <option value="{{$state->id}}">{{$state->name}}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>
                         <div class="row">
                             <div class="form-group col-sm-6">
                                 <label>
                                     <input type="text" class="zip_code" name="zip_code" required="" id="" placeholder="Code" />
                                     <span>Postal Code</span>
                                 </label>
                             </div>
                             <div class="form-group col-sm-6">
                                 <label>
                                     <input type="text" class="pan_no" name="pan_no" required="" id="" placeholder="PAN" />
                                     <span>PAN</span>
                                 </label>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </form>
 </div>

 @push('custom-scripts')

 <script>
   var stateList_d = <?=json_encode($commonData['stateList']) ?>;
  </script>
 <script src="{{asset('js/custom/business.js')}}"></script>
 @endpush