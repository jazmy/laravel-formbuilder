@extends('formbuilder::layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card rounded-0">
                <div class="card-header">
                    <h5 class="card-title">
                        {{ $pageTitle }} ({{ $submissions->count() }})

                        <a href="{{ route('formbuilder::forms.index') }}" class="btn btn-primary float-md-right btn-sm" title="Back To My Forms">
                            <i class="fa fa-th-list"></i> My Forms
                        </a>
                    </h5>
                </div>

                @if($submissions->count())
                    <div class="table-responsive">
                        <table class="table table-bordered d-table table-striped pb-0 mb-0">
                            <thead>
                                <tr>
                                    <th class="five">#</th>
                                    <th class="">Form</th>
                                    <th class="twenty-five">Updated On</th>
                                    <th class="twenty-five">Created On</th>
                                    <th class="fifteen">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $submission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $submission->form->name }}</td>
                                        <td>{{ $submission->updated_at->toDayDateTimeString() }}</td>
                                        <td>{{ $submission->created_at->toDayDateTimeString() }}</td>
                                        <td>
                                            <a href="{{ route('formbuilder::my-submissions.show', [$submission->id]) }}" class="btn btn-primary btn-sm" title="View submission">
                                                <i class="fa fa-eye"></i> View
                                            </a> 

                                            @if($submission->form->allowsEdit())
                                                <a href="{{ route('formbuilder::my-submissions.edit', [$submission->id]) }}" class="btn btn-primary btn-sm" title="Edit submission">
                                                    <i class="fa fa-pencil"></i> 
                                                </a> 
                                            @endif

                                            {{-- <form action="{{ route('formbuilder::my-submissions.destroy', [$submission]) }}" method="POST" id="deleteSubmissionForm_{{ $submission->id }}" class="d-inline-block">
                                                @csrf 
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm confirm-form" data-form="deleteSubmissionForm_{{ $submission->id }}" data-message="Delete this submission?" title="Delete submission">
                                                    <i class="fa fa-trash-o"></i> 
                                                </button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($submissions->hasPages())
                        <div class="card-footer mb-0 pb-0">
                            <div>{{ $submissions->links() }}</div>
                        </div>
                    @endif
                @else
                    <div class="card-body">
                        <h4 class="text-danger text-center">
                            No submission to display.
                        </h4>
                    </div>  
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
