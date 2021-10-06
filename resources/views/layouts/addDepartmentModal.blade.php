<div class="modal fade" id="addDepartmentModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">افزودن دپارتمان جدید</h4>
            </div>
            <form action="#" role="form" id="addDepartmentForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" placeholder="عنوان" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <select class="select2 select2-multiple" multiple="multiple" multiple data-placeholder="سرپرست">
                                    <option value="0">سرپرست 1</option>
                                    <option value="0">سرپرست 2</option>
                                    <option value="0">سرپرست 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="checkbox checkbox-primary float-right">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup">
                                        مخفی باشد
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-sm m-l-5" type="submit">افزودن</button>
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">بستن</button>
                </div>
            </form>
        </div>
    </div>
</div>
