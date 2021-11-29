(function () {
    const objectActions = {
        'input[name=search]': search,
        'input[name=sort]': sort,
        'input[name=limit]': limit
    }

    for (const key in objectActions) {
        if (!Object.hasOwnProperty.call(objectActions, key)) {
            continue;
        }

        const elements = document.querySelectorAll(key);
        let pairEventFn = {
            'change': null
        };

        if (typeof objectActions[key] !== 'function') {
            pairEventFn = objectActions[key];
        } else {
            pairEventFn.change = objectActions[key];
        }

        elements.forEach(element => {
            for (const event in pairEventFn) {
                if (!Object.hasOwnProperty.call(pairEventFn, event)) {
                    continue;
                }

                element.addEventListener(event, pairEventFn[event]);
            }
        });
    }


    function setParams(name, value) {
        const regexp = new RegExp(`^${name}=?[\\w|]*$`);

        return location
            .search
            .slice(1)
            .split('&')
            .filter(function (param) {
                return !regexp.test(param) && param
            })
            .concat([`${name}=${value}`])
            .join('&');
    }

    function search(event) {
        location.search = setParams('search', event.currentTarget.value);
    }

    function sort(event) {
        location.search = setParams('sort', event.currentTarget.value);
    }

    function limit(event) {
        location.search = setParams('limit', event.currentTarget.value);
    }
})();