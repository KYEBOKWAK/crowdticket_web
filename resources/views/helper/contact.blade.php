<div class="form-group clear">
    <label for="input-contact">{{ $label }}</label>
    <div class="form-inline concatable">
        <select class="form-control concatable-source">
            <option>010</option>
            <option>011</option>
            <option>016</option>
            <option>017</option>
            <option>018</option>
        </select>
        <input type="text" maxlength="4" class="form-control contact concatable-source"
               pattern="^\d{3,4}$" {{ $required or '' }} />
        <input type="text" maxlength="4" class="form-control contact concatable-source"
               pattern="^\d{4}$" {{ $required or '' }} />
        <input type="hidden" name="{{ $name }}" class="concatable-target"/>
    </div>
    <p class="help-block">{{ $help }}</p>
</div>
