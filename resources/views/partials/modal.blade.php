<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="popup text-left">
                    <h4 class="mb-3">New Order</h4>
                    <div class="content create-workform bg-body">
                        <form id="myForm" name="myForm">
                            @csrf
                            <input type="text" name="hid" id="hid" hidden>
                            <input type="text" name="iid" id="iid" hidden>
                            <div class="pb-3">
                                <label class="mb-2">SBU Name</label>
                                <input name="sbuname" id="sbuname"type="text" class="form-control">
                            </div>
                            <div class="pb-3">
                                <label class="mb-2">Ring</label>
                                <input name="idring" id="idring"type="text" class="form-control">
                            </div>
                            <div class="pb-3">
                                <label class="mb-2">Hostname</label>
                                <input name="hostname" id="hostname"type="text" class="form-control">
                            </div>
                            <div class="pb-3">
                                <label class="mb-2">Interface Name</label>
                                <input name="interfacename" id="interfacename"type="text" class="form-control">
                            </div>
                            <div class="pb-3">
                                <label class="mb-2">Description</label>
                                <input name="description" id="description"type="text" class="form-control">
                            </div>
                            <div class="pb-3">
                                <label class="mb-2">Capacity</label>
                                <input name="capacity" id="capacity"type="text" class="form-control">
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                    <button class="btn btn-primary mr-4" data-dismiss="modal" type="button"
                                        onclick="closeModal()">Cancel</button>
                                    <button class="btn btn-outline-primary" type="submit">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
