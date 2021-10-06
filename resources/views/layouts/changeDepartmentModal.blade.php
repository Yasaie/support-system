<div class="modal fade" role="dialog" id="changeDepartmentModal" aria-labelledby="changeDepartmentModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="changeDepartmentModalLabel">تعویض دپارتمان تیکت</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('ticket.department.update',$ticket) }}" id="changeDepartmentForm" role="form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12">

                            @inject('departmentModel','App\Department')
                            @if(Auth::user()->owner() || Auth::user()->admin() || Auth::user()->leader() || Auth::user()->staff())
                                @php
                                    $departments=$departmentModel::orderBy('name')->get();
                                @endphp
                            @else
                                @php
                                    $departments=$departmentModel::whereNull('hidden_at')->orderBy('name')->get();
                                @endphp
                            @endif

                            @unless($departments->isEmpty())
                            <div class="form-group {{ $errors->has('department') ? ' has-error' : '' }} row">
                                <label class="col-sm-2 col-form-label" for="department">دپارتمان</label>
                                <div class="col-sm-10">
                                    <select name="department" id="department" class="form-control" data-placeholder="دپارتمان تیکت را انتخاب کنید">
                                        @unless($departments->isEmpty())
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ (($ticket->department->id==$department->id) ?' selected ':'') }}>{{ $department->name }}</option>
                                            @endforeach
                                        @endunless
                                    </select>
                                    @if ($errors->has('department'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('department') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endunless

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm float-left changeDepartment m-r-5">تعویض دپارتمان</button>
                <button class="btn btn-secondary btn-sm float-left" data-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>