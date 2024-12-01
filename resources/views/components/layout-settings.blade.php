<div class="layout-settings">

    <div class="layout-settings__title">
        Layout-Einstellungen
    </div>

    <div class="layout-settings__checkbox-group">
        <div>
            <input type="checkbox" id="setting1" name="setting1">
            <label for="setting1">Zeige Meta Box</label>
        </div>
        <div>
            <input type="checkbox" id="setting2" name="setting2">
            <label for="setting2">Zeige Autor(en)</label>
        </div>
        <div>
            <input type="checkbox" id="setting3" name="setting3">
            <label for="setting3">Zeige Copyright</label>
        </div>
    </div>

    <div class="layout-settings__textarea-group">
        <label for="additional-info" class="layout-settings__textarea-label">Template-Postfix</label>
        <textarea id="additional-info" name="additional-info" rows="4" class="layout-settings__textarea"></textarea>
    </div>

    <div class="layout-settings__checkbox-icon">
        <input type="checkbox" id="setting4" name="setting4">
        <label for="setting4" class="layout-settings__icon-label">
            Zeige Verband in Brotkrumen-Navigation
            <x-tooltip text="Der Verband wird nur angezeigt sofern das Konzept einem Verband zugeordnet ist">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512" fill="currentColor" aria-hidden="true">
                    <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                </svg>
            </x-tooltip>
        </label>
    </div>
</div>
