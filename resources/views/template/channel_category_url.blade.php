<script type="text/template" id="template_channel">
  <div data-channel-id="<%= channel.id %>" class="channel project-form-channel-category-container-grid">
    <select id="channel_category" name="channel_category<%= index %>" class="form-control">
      @foreach ($categories_channel as $category_channel)
        <option value="{{ $category_channel->id }}">{{ $category_channel->title }}</option>
      @endforeach
    </select>
    <!-- index 값을 유동적으로 수정하기 위해 form.js setChannelAddBtn에서 수정해준다. -->
    <input id="channel_category_url_input" name="channel_category_url_input<%= index %>" type="text" style="width: 100%;" value="<%= channel.url %>" />
    <input id="channelId" type="hidden" name="channelId<%= index %>" value="<%= channel.id %>">
    <div class="project-form-chaanel-button-container">
      <button type="button" class="btn btn-primary add-channel">추가</button>
      <!--<button id="add-channel" class="btn btn-primary add-channel">추가</button>-->
      <button type="button" class="btn btn-primary delete-channel">삭제</button>
    </div>
	</div>
</script>
