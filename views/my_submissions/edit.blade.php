@extends('formbuilder::layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card rounded-0">
                <div class="card-header">
                    <h5 class="card-title">
                        {{ $pageTitle }}

                        <a href="{{ route('formbuilder::my-submissions.index') }}" class="btn btn-primary float-md-right btn-sm" title="Back To My Submissions">
                            <i class="fa fa-arrow-left"></i> 
                        </a>
                    </h5>
                </div>

                <form action="{{ route('formbuilder::my-submissions.update', $submission->id) }}" method="POST" id="submitForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div id="fb-render"></div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary confirm-form" data-form="submitForm" data-message="Submit update to your entry for '{{ $submission->form->name }}'?">
                            <i class="fa fa-submit"></i> Submit Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push(config('formbuilder.layout_js_stack', 'scripts'))
    <script type="text/javascript">
        window._form_builder_content = {!! json_encode($submission->form->form_builder_json) !!}
    </script>
    <script src="{{ asset('vendor/formbuilder/js/render-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endpush
