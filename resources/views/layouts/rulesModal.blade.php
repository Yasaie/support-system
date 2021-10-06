<div class="modal fade" role="dialog" id="rulesModal" aria-labelledby="rulesModalLabel">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="uploadModalLabel">قوانین و مقررات</h4>
            </div>
            <div class="modal-body text-justify">
                {{ config('app.rules') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>
