<script type="text/template" id="template_channel">
  <div data-channel-id="<%= channel.id %>" class="channel">
    <div class="flex_layer">
      <select id="channel_category<%= index %>" name="channel_category<%= index %>" class="project_form_input_base project_form_creator_channel_input">
        @foreach ($categories_channel as $category_channel)
          <option value="{{ $category_channel->id }}">{{ $category_channel->title }}</option>
        @endforeach
      </select>
      <!-- index 값을 유동적으로 수정하기 위해 form.js setChannelAddBtn에서 수정해준다. -->
      <input id="channel_category_url_input" name="channel_category_url_input<%= index %>" class="project_form_input_base project_form_creator_channel_url_input" type="text" value="<%= channel.url %>" placeholder="페이지 주소" />
      <input id="channelId" type="hidden" name="channelId<%= index %>" value="<%= channel.id %>">
      <div class="project-form-chaanel-button-container">
        <a href="javascript:void(0);" id="add-channel<%= index %>"><img class="add-channel" style="margin-left: 0px;" src="https://img.icons8.com/windows/40/EF4D5D/plus-2-math.png"></a>
        <a href="javascript:void(0);" id="delete-channel<%= index %>"><img class="delete-channel" style="margin-left: 0px;" src="https://img.icons8.com/windows/40/EF4D5D/minus-2-math.png"></a>
      </div>
    </div>
	</div>
</script>
