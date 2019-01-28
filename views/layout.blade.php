@extends(config('formbuilder.layout_file', 'layouts.app'))

@prepend(config('formbuilder.layout_js_stack', 'scripts'))
	<script type="text/javascript">
		window.FormBuilder = {
			csrfToken: '{{ csrf_token() }}',
		}
	</script>
	<script src="{{ asset('vendor/formbuilder/js/jquery-ui.min.js') }}" defer></script>
	<script src="{{ asset('vendor/formbuilder/js/sweetalert.min.js') }}" defer></script>
	<script src="{{ asset('vendor/formbuilder/js/jquery-formbuilder/form-builder.min.js') }}" defer></script>
	<script src="{{ asset('vendor/formbuilder/js/jquery-formbuilder/form-render.min.js') }}" defer></script>
	<script src="{{ asset('vendor/formbuilder/js/parsleyjs/parsley.min.js') }}" defer></script>
	<script src="{{ asset('vendor/formbuilder/js/clipboard/clipboard.min.js') }}?b=ck24" defer></script>
	<script src="{{ asset('vendor/formbuilder/js/moment.js') }}"></script>
	<script src="{{ asset('vendor/formbuilder/js/footable/js/footable.min.js') }}" defer></script>
	<script src="{{ asset('vendor/formbuilder/js/script.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endprepend

@prepend(config('formbuilder.layout_css_stack', 'scripts'))
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/formbuilder/js/footable/css/footable.standalone.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/formbuilder/css/styles.css') }}{{ jazmy\FormBuilder\Helper::bustCache() }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endprepend
