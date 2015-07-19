<div class="tab-content {{ $tab_content_class or '' }}">
	@foreach ($contents as $content)
		<div id="{{ $content['id'] }}" role="tabpanel" class="tab-pane {{ $content['class'] or '' }}">
			@include($content['include'])
		</div>
	@endforeach
</div>