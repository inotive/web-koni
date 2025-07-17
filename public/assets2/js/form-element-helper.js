class FormElementHelper {
    attribute = [];

    createAttribute(type, name, value) {
        this.attribute.push({
            type,
            name,
            value
        });

        return this;
    }

    post(action) {
        console.log(action, this.attribute);
        const formdata = document.createElement("form");
        formdata.setAttribute("method", "POST");
        formdata.setAttribute("action", action);

        for (const attributeItem of this.attribute) {
            const hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", attributeItem.type);
            hiddenField.setAttribute("name", attributeItem.name);
            hiddenField.setAttribute("value", attributeItem.value);

            formdata.appendChild(hiddenField);
        }

        document.body.appendChild(formdata);
        formdata.submit();
    }
    get(action) {
        console.log(action, this.attribute);
        const formdata = document.createElement("form");
        formdata.setAttribute("method", "GET"); 
        formdata.setAttribute("action", action);

        for (const attributeItem of this.attribute) {
            const hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", attributeItem.type);
            hiddenField.setAttribute("name", attributeItem.name);
            hiddenField.setAttribute("value", attributeItem.value);

            formdata.appendChild(hiddenField);
        }

        document.body.appendChild(formdata);
        formdata.submit();
    }
}

var formElementHelper = new FormElementHelper();