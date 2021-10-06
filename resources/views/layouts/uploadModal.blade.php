<div class="modal fade" role="dialog" id="uploadModal" aria-labelledby="uploadModalLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="uploadModalLabel">افزودن فایل</h4>
            </div>
            <div class="modal-body">
                <p class="text-muted">
                    <span>حداکثر می توانید</span>
                    <span class="text-danger"> {{ config('ticket.attachment.file.count') }} فایل </span>
                    <span>آپلود کنید</span>
                </p>
                <p class="text-muted">
                    <span> حجم هر فایل نباید بیشتر از</span>
                    <span class="text-danger"> {{ config('ticket.attachment.file.size') }} مگابایت </span>
                    <span class="text-danger"> ({{ config('ticket.attachment.file.size') }} MB) </span>
                    <span>باشد</span>
                </p>

                @include('layouts.dropzonePreviewTemplate')

                <form class="dropzone" id="dropzone" method="POST" action="{{ route('media.storeChunk') }}" enctype="multipart/form-data">
                    <div class="fallback">
                        <input name="media" type="file"/>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>
