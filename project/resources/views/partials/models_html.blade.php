<div style="display: none;" class="modal fade modal-custom-styling" id="app-integration-modal" role="dialog">
    <div class="modal-dialog">
    <input type="hidden" id="webhook_event_id" value="0">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-head__content-section">
                    <h3 class="modal-title">Channels</h3>
                    <span class="separate"></span>
                    <div class="serach-filter">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input id="channels-search" value="" type="text" placeholder="Search all apps">
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="tabs--with-category-dropdown">
                    <section id="app-tab-section">
                            <div class="">
                                <div class="papular-apps-tab-secton">
                                    <div class="">
                                        <nav class="nav-top-head">
                                        <div class="tabbable-line">
                                            <ul class="nav nav-tabs ">
                                                <li>
                                                    <a href="#popular-app-tab" data-toggle="tab">
                                                        Popular Apps  </a>
                                                </li>
                                                <li>
                                                    <a href="#all-app-tabs" data-toggle="tab">
                                                        All Apps </a>
                                                </li>
                                            </ul>
                                        </div>
                                            <div class="category-dorpdown col-md-4">

                                                <select class="form-control form-control-lg" name="category" id="channel-category">
                                                    <option value=""> All Categories</option>
                                                </select>
                                            </div>
                                        </nav>
                                            <div id="channels-list-div" class="tab-content">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-offline-settings">Save</button>
            </div>
        </div>

    </div>
</div>