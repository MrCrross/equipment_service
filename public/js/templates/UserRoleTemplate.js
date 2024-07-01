class UserRoleTemplate {
    static btnAddLineSelector = '.add-line-UserRole';
    static btnRemoveLineSelector = '.remove-line-UserRole';
    static containerLineSelector = '.container-line-UserRole';
    static lineUserRoleClass = 'line-UserRole';
    static lineUserRoleCloneSelector = '#line-clone-UserRole';
    static searchText = 'Поиск'

    constructor(searchText) {
        UserRoleTemplate.addListeners();
        UserRoleTemplate.searchText = searchText
    }

    static addListeners()
    {
        const addBtns = document.querySelectorAll(UserRoleTemplate.btnAddLineSelector);
        const removeBtns = document.querySelectorAll(UserRoleTemplate.btnRemoveLineSelector);
        const inputCheckBox = document.querySelectorAll('.input_checkbox');

        if (addBtns) {
            addBtns.forEach((btn) => {
                btn.addEventListener('click', (event) => UserRoleTemplate.addNewLine(event));
            });
        }
        if (removeBtns) {
            removeBtns.forEach((btn) => {
                btn.addEventListener('click', (event) => UserRoleTemplate.removeLine(event));
            });
        }
        if (inputCheckBox) {
            inputCheckBox.forEach((checkBox) => {
                checkBox.addEventListener('change', (event) => {
                    const target = event.target;
                    if (target.checked) {
                        target.value = 1;
                    } else {
                        target.value = 0;
                    }
                });
            })
        }
    }

    static addNewLine(event)
    {
        const clone = UserRoleTemplate.getClone();
        const container = document.querySelector(UserRoleTemplate.containerLineSelector);
        container.append(clone);
    }

    static removeLine(event)
    {
        const line = UserRoleTemplate.getLineUserRole(event.target);
        line.remove()
    }

    static getLineUserRole(element)
    {
        while(element = element.parentElement) {
            if (element.classList.contains(UserRoleTemplate.lineUserRoleClass)) {
                return element;
            }
        }
    }

    static getClone()
    {
        const clone = document.querySelector(UserRoleTemplate.lineUserRoleCloneSelector).cloneNode(true);
        clone.querySelector('div.nice-select').remove()
        const addBtn = clone.querySelector(UserRoleTemplate.btnAddLineSelector);
        const removeBtn = clone.querySelector(UserRoleTemplate.btnRemoveLineSelector);
        const select =  clone.querySelector('select#role_id')
        clone.id = '';
        clone.classList.remove('hidden');
        addBtn.remove();
        removeBtn.addEventListener('click', (event) => UserRoleTemplate.removeLine(event));
        removeBtn.classList.remove('hidden');
        NiceSelect.bind(select, {
            searchable: true,
            searchtext: UserRoleTemplate.searchText
        });

        return clone;
    }
}
