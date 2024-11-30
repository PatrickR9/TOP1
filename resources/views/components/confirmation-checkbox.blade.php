<div class="confirmation_checkbox_wrapper" onclick="updateCheckboxColor(this)">
    <input type="checkbox" id="{{ $id }}" onclick="event.stopPropagation(); updateCheckboxColor(this.parentElement);" />
    <label for="{{ $id }}">{{ $label }}</label>
</div>