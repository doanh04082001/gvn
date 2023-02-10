const encodeMixin = {
    methods: {
        htmlEncode: (value) => {
            return $('<textarea />').html(value).text();
        }
    }
}

export {encodeMixin};
