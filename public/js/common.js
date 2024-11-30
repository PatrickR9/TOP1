/* Category dropdown (topics and target-groups) */
function toggleSubEntries(prefix, categoryId) {
    const subEntries = document.getElementById(`${prefix}SubEntries${categoryId}`);
    const arrow = document.getElementById(`${prefix}Arrow${categoryId}`);
    const mainCategory = document.getElementById(`${prefix}MainCategory${categoryId}`);

    if (subEntries.style.display === "none" || subEntries.style.display === "") {
        subEntries.style.display = "block";
        arrow.classList.add("category_chevron_rotated");
        mainCategory.classList.add("main_category_dd_opened");
    } else {
        subEntries.style.display = "none";
        arrow.classList.remove("category_chevron_rotated");
        mainCategory.classList.remove("main_category_dd_opened");
    }
}

document.addEventListener('livewire:init', () => {
    Livewire.on('triggerHandleCategorySelect', (data) => {
        const { prefix, checkbox } = data[0];
        handleCategorySelect(prefix, checkbox, true);
    });
});

function handleCategorySelect(prefix, checkbox, init) {
    const selectedList = document.getElementById(`${prefix}SelectedList`);

    if (init) {
        if (checkbox.component === 'topic') {
            checkbox = document.getElementById('topic' + checkbox.id);
        }
        else if (checkbox.component === 'targetGroup') {
            checkbox = document.getElementById('targetGroup' + checkbox.id);
        }
        if (checkbox) {
            checkbox.checked = true;
        }
    }

    if (checkbox.checked) {
        const item = document.createElement("div");
        item.className = "category_selected_item";
        item.id = `${prefix}Selected-${checkbox.id}`;
        item.onclick = function() {
            removeSelectedCategory(prefix, checkbox.id, checkbox);
        };

        const itemText = document.createElement("span");
        itemText.textContent = checkbox.value;

        const itemIcon = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        itemIcon.setAttribute("xmlns", "http://www.w3.org/2000/svg");
        itemIcon.setAttribute("viewBox", "0 -960 960 960");
        itemIcon.setAttribute("width", "12");
        itemIcon.setAttribute("height", "12");
        itemIcon.classList.add("category_selected_item_remove");

        const svgPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
        svgPath.setAttribute("d", "m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z");
        svgPath.setAttribute("fill", "#fff");

        itemIcon.appendChild(svgPath);

        item.appendChild(itemText);
        item.appendChild(itemIcon);
        selectedList.appendChild(item);
        if (!init) {
            if (checkbox.id.startsWith('topic')) {
                let topicId = checkbox.id.slice(5);
                Livewire.dispatch('topicStateUpdated', {'topicId':topicId})
            }
            else if (checkbox.id.startsWith('targetGroup')) {
                let targetGroupId = checkbox.id.slice(11);
                Livewire.dispatch('targetGroupStateUpdated', {'targetGroupId':targetGroupId})
            }
        }
    } else {
        removeSelectedCategory(prefix, checkbox.id, checkbox);
    }
}

function removeSelectedCategory(prefix, id, checkbox) {
    const selectedItem = document.getElementById(`${prefix}Selected-${id}`);
    if (selectedItem) {
        selectedItem.remove();
    }
    checkbox.checked = false;
    if (checkbox.id.startsWith('topic')) {
        let topicId = checkbox.id.slice(5);
        Livewire.dispatch('topicStateUpdated', {'topicId':topicId})
    }
    else if (checkbox.id.startsWith('targetGroup')) {
        let targetGroupId = checkbox.id.slice(11);
        Livewire.dispatch('targetGroupStateUpdated', {'targetGroupId':targetGroupId})
    }
}

/* Confirmation checkbox (metadata) */
function updateCheckboxColor(wrapper) {
    const checkbox = wrapper.querySelector("input[type='checkbox']");
    if (checkbox.checked) {
        wrapper.classList.add("checked_confirmation");
    } else {
        wrapper.classList.remove("checked_confirmation");
    }
}