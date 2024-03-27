<div class="modal fade twoside_modal" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                    </button>
                    <div class="modal-body">
                        <div class="setup_wrapper">
                            <h2>Crop Image</h2>
                            <div style="height: 400px; width: 100%;">
                                <div class="img-container">
                                    <img id="imageToCrop" class="image-to-crop" crossorigin="anonymous" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="replaceImage"><iconify-icon icon="material-symbols:upload-rounded"></iconify-icon> Upload Different Image</button>
                        <button type="button" class="btn btn-primary" id="cropAndSave">Save Cropped Image</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- ........modal 2 -->
        
    <div class="modal fade twoside_modal" id="cropModal2" tabindex="-1" aria-labelledby="cropModal2Label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <iconify-icon icon="material-symbols:close-rounded"></iconify-icon>
                </button>
                <div class="modal-body">
                    <div class="setup_wrapper">
                        <h2>Crop Image</h2>
                        <div style="height: 400px; width: 100%;">
                            <div class="img-container">
                                <img id="imageToCrop2" class="image-to-crop" crossorigin="anonymous" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="replaceImage2"><iconify-icon
                            icon="material-symbols:upload-rounded"></iconify-icon> Upload Different Image</button>
                    <button type="button" class="btn btn-primary" id="cropAndSave2">Save Cropped Image</button>
                </div>
            </div>
        </div>
    </div>