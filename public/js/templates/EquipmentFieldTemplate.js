class EquipmentFieldTemplate {
    static btnAddLineSelector = '.add-line-EquipmentField';
    static selectSelector = '.select-EquipmentField';
    static btnRemoveLineSelector = '.remove-line-EquipmentField';
    static containerLineSelector = '.container-line-EquipmentField';
    static lineEquipmentFieldClass = 'line-EquipmentField';
    static lineEquipmentFieldCloneSelector = '#line-clone-EquipmentField';
    static keyLine = 0;

    constructor() {
        EquipmentFieldTemplate.addListeners();
    }

    static addListeners()
    {
        const selects = document.querySelectorAll(EquipmentFieldTemplate.selectSelector);
        const addBtns = document.querySelectorAll(EquipmentFieldTemplate.btnAddLineSelector);
        const removeBtns = document.querySelectorAll(EquipmentFieldTemplate.btnRemoveLineSelector);

        if (addBtns) {
            addBtns.forEach((btn) => {
                btn.addEventListener('click', (event) => EquipmentFieldTemplate.addNewLine(event));
            });
        }
        if (removeBtns) {
            removeBtns.forEach((btn) => {
                btn.addEventListener('click', (event) => EquipmentFieldTemplate.removeLine(event));
            });
        }
        if (selects) {
            selects.forEach((select) => {
                select.addEventListener('change', (event) => EquipmentFieldTemplate.changeInputByCode(event));
            });
        }
    }

    static addNewLine(event)
    {
        const clone = EquipmentFieldTemplate.getClone();
        const container = document.querySelector(EquipmentFieldTemplate.containerLineSelector);
        container.append(clone);
    }

    static removeLine(event)
    {
        const line = EquipmentFieldTemplate.getLineEquipmentField(event.target);
        line.remove()
    }

    static getLineEquipmentField(element)
    {
        while(element = element.parentElement) {
            if (element.classList.contains(EquipmentFieldTemplate.lineEquipmentFieldClass)) {
                return element;
            }
        }
    }

    static changeInputByCode(event)
    {
        const line = EquipmentFieldTemplate.getLineEquipmentField(event.target);
        const code = event.target.selectedOptions[0].getAttribute('data-code');
        const inputContainer = line.querySelector('.inputContainer-EquipmentField');
        inputContainer.innerHTML = '';
        inputContainer.append(EquipmentFieldTemplate.createInput(code));
    }

    static getClone()
    {
        EquipmentFieldTemplate.keyLine++;
        const clone = document.querySelector(EquipmentFieldTemplate.lineEquipmentFieldCloneSelector).cloneNode(true);
        const addBtn = clone.querySelector(EquipmentFieldTemplate.btnAddLineSelector);
        const removeBtn = clone.querySelector(EquipmentFieldTemplate.btnRemoveLineSelector);
        clone.id = '';
        clone.classList.remove('hidden');
        addBtn.remove();
        removeBtn.addEventListener('click', (event) => EquipmentFieldTemplate.removeLine(event));
        removeBtn.classList.remove('hidden');

        return clone;
    }

    static createInput(type)
    {
        const input = document.createElement('input');
        let className = 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50';
        input.type = type;
        if (type === 'checkbox') {
            className = 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm';
        }
        input.className = className;
        input.name = `fields[${EquipmentFieldTemplate.keyLine}][value]`;

        return input;
    }
}
