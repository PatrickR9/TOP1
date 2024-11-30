<div>
    <style>
        .management_edit_card_bar {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 20px;
            background-image: linear-gradient(#4b4b4b, #282828, #1b1b1b);
            color: #FFF;
        }

        .management_edit_card {
            padding: 20px;
        }

        .management_edit_select {
            position: relative;
            width: 250px;
            cursor: pointer;
        }

        .select_box {
            border: 1px solid #6b7280;
            border-radius: 4px;
            padding: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .select_arrow {
            border: solid #333;
            border-width: 0 2px 2px 0;
            display: inline-block;
            padding: 3px;
            transform: rotate(45deg);
            transition: transform 0.3s ease;
            margin-left: 10px;
            margin-right: 10px;
        }

        .select_box.open .select_arrow {
            transform: rotate(-135deg);
        }

        .select_dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            display: none;
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
        }

        .select_dropdown label {
            display: block;
            padding: 5px;
            cursor: pointer;
            user-select: none;
        }

        .select_dropdown input {
            margin-right: 5px;
        }

        .select_dropdown label:hover {
            background-color: #f1f1f1;
        }
    </style>
    <form wire:submit.prevent="updateUserRoles">
        <div class="management_edit_card">
            <div class="management_edit_select">
                <div class="select_box">
                    <span class="select_text">Benutzerrollen auswählen</span>
                    <div class="select_arrow"></div>
                </div>
                <div class="select_dropdown">
                    @foreach($allRoles as $role)
                    <label>
                        <input type="checkbox" wire:model="selectedUserRoles" data-value="{{ $role->name }}" value="{{ $role->id }}" />
                        {{ $role->name }}
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="management_edit_card_bar">
            <a><button class="management_button" type="button" onclick="location.reload()">{{__('cancel')}}</button></a>
            <button class="management_button" type="submit">{{__('save')}}</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectBox = document.querySelector('.select_box');
            const selectDropdown = document.querySelector('.select_dropdown');
            const selectText = document.querySelector('.select_text');

            selectBox.addEventListener('click', function() {
                selectDropdown.style.display = selectDropdown.style.display === 'block' ? 'none' : 'block';
                selectBox.classList.toggle('open');
            });

            selectDropdown.addEventListener('change', function() {
                const selectedOptions = Array.from(selectDropdown.querySelectorAll('input:checked'))
                    .map(checkbox => checkbox.getAttribute('data-value'));
                selectText.textContent = selectedOptions.length > 0 ? selectedOptions.join(', ') : 'Benutzerrollen auswählen';
            });

            document.addEventListener('click', function(event) {
                if (!selectBox.contains(event.target) && !selectDropdown.contains(event.target)) {
                    selectDropdown.style.display = 'none';
                    selectBox.classList.remove('open');
                }
            });
        });
    </script>
</div>