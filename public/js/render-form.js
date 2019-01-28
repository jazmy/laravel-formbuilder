jQuery(function() {
	var fbRenderOptions = {
		container: false,
		dataType: 'json',
		formData: window._form_builder_content ? window._form_builder_content : '',
		render: true,
	}

	$('#fb-render').formRender(fbRenderOptions)
})