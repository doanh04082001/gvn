const onImageError = (image, defaultImage = 'square') => {
    let src = DEFAULT_SQUARE_IMAGE
    if (defaultImage == 'rectangle') {
        src = DEFAULT_RECTANGLE_IMAGE
    }

    if (defaultImage == 'rectangle_2x3') {
        src = DEFAULT_RECTANGLE_2x3_IMAGE
    }

    image.src = src;
}

module.exports = onImageError
