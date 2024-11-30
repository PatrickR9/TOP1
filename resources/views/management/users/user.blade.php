<div>
    <form action = "" wire:submit="update({{$id}})">
        <div class = "management_edit_table">
            <div class = "management_edit_table_header">
                <div class = "management_edit_table_row right">
                    <a><button class = "management_button" type = "button" onclick="location.reload()">{{__('cancel')}}</button></a>
                    <button class = "management_button" type = "submit">{{__('save')}}</button>
                </div>
            </div>
            <div class = "management_edit_table_body">
                <div class = "management_edit_table_row">
                    <div class = "management_edit_row_label">Benutzername</div>
                    <div class = "management_edit_row_input">
                        <input class = "input_long" type = "text" wire:model="name">
                        @error('name')
                            <span class="input_error">{{ $message }}</span>
                        @enderror 
                    </div>
                </div>
                <div class = "management_edit_table_row">
                    <div class = "management_edit_row_label">E-Mail</div>
                    <div class = "management_edit_row_input">
                        <input class = "input_long" type = "text" wire:model="email">
                        @error('email')
                            <span class="input_error">{{ $message }}</span>
                        @enderror 
                    </div>
                </div>
                <div class = "management_edit_table_row">
                    <div class = "management_edit_row_label">Vorname</div>
                    <div class = "management_edit_row_input">
                        <input class = "input_long" type = "text" wire:model="firstname">
                        @error('firstname')
                            <span class="input_error">{{ $message }}</span>
                        @enderror 
                    </div>
                </div>
                <div class = "management_edit_table_row">
                    <div class = "management_edit_row_label">Nachname</div>
                    <div class = "management_edit_row_input">
                        <input class = "input_long" type = "text" wire:model="lastname">
                        @error('lastname')
                            <span class="input_error">{{ $message }}</span>
                        @enderror 
                    </div>
                </div>
                <div class = "management_edit_table_row">
                    <div class = "management_edit_row_label">Strasse, Hausnr.</div>
                    <div class = "management_edit_row_input">
                        <input class = "input_long" type = "text" wire:model="street">
                        @error('street')
                            <span class="input_error">{{ $message }}</span>
                        @enderror 
                    </div>
                </div>
                <div class = "management_edit_table_row">
                    <div class = "management_edit_row_label">PLZ</div>
                    <div class = "management_edit_row_input">
                        <input class = "input_short" type = "text" wire:model="zip">
                        @error('zip')
                            <span class="input_error">{{ $message }}</span>
                        @enderror 
                    </div>
                </div>
                <div class = "management_edit_table_row">
                    <div class = "management_edit_row_label">Ort</div>
                    <div class = "management_edit_row_input">
                        <input class = "input_long" type = "text" wire:model="city">
                        @error('city')
                            <span class="input_error">{{ $message }}</span>
                        @enderror 
                    </div>
                </div>
                <div class = "management_edit_table_row">
                    <div class = "management_edit_row_label">Land</div>
                    <div class = "management_edit_row_input">
                        <input class = "input_short" type = "text" wire:model="country">
                        @error('country')
                            <span class="input_error">{{ $message }}</span>
                        @enderror 
                    </div>
                </div>
                <div class = "management_edit_table_row">
                    <div class = "management_edit_row_label">Geburtsdatum</div>
                    <div class = "management_edit_row_input">
                        <input class = "input_short" type = "date" wire:model="birthdate">
                        @error('birthdate')
                            <span class="input_error">{{ $message }}</span>
                        @enderror 
                    </div>
                </div>
                <div class = "management_edit_table_row">
                    <div class = "management_edit_row_label">Webseite</div>
                    <div class = "management_edit_row_input">
                        <input class = "input_long" type = "text" wire:model="website">
                        @error('website')
                            <span class="input_error">{{ $message }}</span>
                        @enderror 
                    </div>
                </div>
            </div>
            <div class = "management_edit_table_footer">
                <div class = "management_edit_table_row right">
                    <button class = "management_button" type = "button" onclick="location.reload()">{{__('cancel')}}</button>
                    <button class = "management_button" type = "submit">{{__('save')}}</button>
                </div>
            </div>
        </div>
    </form>
</div>