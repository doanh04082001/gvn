export const myInformation = {
    listenMyInformationEvent: () => {
        document.getElementById('avatar').onchange = evt => {
            const [file] = evt.target.files;
            if (file) {
                document.getElementById('preview').src = URL.createObjectURL(file);
            }
        };

        document.getElementById('form-data').onsubmit = e => document.getElementById('submit').disabled = true;
    },
};
