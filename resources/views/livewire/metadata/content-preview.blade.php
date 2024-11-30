<div x-data="{ message: '{{ $value }}', maxLength: @js($maxLength) }">
    <textarea
        class="content_preview_textarea"
        x-model="message"
        rows="4"
        cols="50"
        :maxlength="maxLength"
        wire:model="value"
        wire:change="valueUpdated(message)">
    </textarea>
    <p class="char_count"><span x-text="message.length"></span>/<span class="max_char_number">{{ $maxLength }}</span></p>
</div>