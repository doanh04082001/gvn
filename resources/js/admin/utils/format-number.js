export const encodeNumber = number => {
    return number?.toString()
        .replace(/,/g, '')
        .replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,') || '';
}

export const decodeNumber = number => number?.replaceAll(',', '');
