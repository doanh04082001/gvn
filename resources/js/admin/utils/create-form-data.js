const isFile = input => 'File' in window && input instanceof File;
const isBlob = input => 'Blob' in window && input instanceof Blob;

export const createFormData = (data, formData = null, globalKey = null) => {
    if (!formData) {
        formData = new FormData();
    }

    Object.keys(data).forEach(key => {
        const value = data[key];
        const currrentKey = globalKey ? globalKey + '[' + key + ']' : key;
        if (_.isObject(value) && !isFile(value) && !isBlob(value)) {
            createFormData(
                value,
                formData,
                currrentKey,
            );
        } else {
            formData.append(currrentKey, value);
        }
    })

    return formData;
}
