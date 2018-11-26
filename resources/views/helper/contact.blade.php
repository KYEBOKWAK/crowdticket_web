<div class="form-group clear">
    <p class="project_form_create_title" for="input-contact">{{ $label }}</p>
    <div class="form-inline concatable project_form_phone_wrapper">
      <div class="flex_layer">
        <select class="concatable-source project_form_create_input">
            <option>010</option>
            <option>011</option>
            <option>016</option>
            <option>017</option>
            <option>018</option>
            <option>070</option>
        </select>
        <input type="text" maxlength="4" class="project_form_create_input contact concatable-source project_form_phone_input_radius"
               pattern="^\d{3,4}$" {{ $required or '' }} />
        <input type="text" maxlength="4" class="project_form_create_input contact concatable-source project_form_phone_input_radius"
               pattern="^\d{4}$" {{ $required or '' }} />
        <input type="hidden" name="{{ $name }}" class="concatable-target"/>
      </div>
    </div>
    <p class="help-block">{{ $help }}</p>
</div>
