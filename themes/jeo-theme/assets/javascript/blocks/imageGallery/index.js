const { MediaUpload, RichText } = wp.editor;
const { Button } = wp.components;
const { __ }                = wp.i18n;
const { registerBlockType } = wp.blocks;





registerBlockType('jeo-theme/custom-image-gallery-block', {
    title: __('Image Gallery'),
    icon: 'format-gallery',
    category: 'common',
    keywords: [
        __('materialtheme'),
        __('photos'),
        __('images')
    ],
    attributes: {
        images: {
            type: 'array',
        },   

        imagesDescriptions: {
            type: 'array',
        },

        imagesCredits: {
            type: 'array',
        }
    },

    edit({ attributes, className, setAttributes}) {
        const { images = [], imagesDescriptions = [], imagesCredits = [] } = attributes;
        console.log(attributes);

        images.forEach( (element, index) => {
            if(!imagesDescriptions[index]) {
                imagesDescriptions[index] = "";
            }

            if(!imagesCredits[index]) {
                imagesCredits[index] = "";
            }
        });

        const removeImage = (removeImageIndex) => {
            const newImages = images.filter((image, index) => {
                if (index != removeImageIndex) {
                    return image;
                }
            });

            imagesDescriptions.splice(removeImageIndex, 1);
            imagesCredits.splice(removeImageIndex, 1);

            setAttributes({
                images: newImages,
                imagesDescriptions,
                imagesCredits,
            })
        }

        const displayImages = (images) => {
            
            //console.log(external_link_api); 
            return (
                images.map((image, index) => {
                    //console.log(image);
                    return (
                        <div className="gallery-item-container">
                            <img className='gallery-item' src={image.url} key={image.id} />
                            <RichText
                                tagName="span"
                                className="description-field"
                                value={ imagesDescriptions[index] }
                                formattingControls={ [ 'bold', 'italic' ] } 
                                onChange={ ( content ) => {
                                    setAttributes( { imagesDescriptions: imagesDescriptions.map( (item, i) => {
                                        if (i == index) {
                                            return content;
                                        } else {
                                            return item;
                                        }
                                    }) } )
                                } }
                                placeholder={ __( 'Type here your description' ) } 
                            />

                            <RichText
                                tagName="span"
                                className="credit-field"
                                value={ imagesCredits[index] }
                                formattingControls={ [ 'bold', 'italic' ] } 
                                onChange={ ( content ) => {
                                    setAttributes( { imagesCredits: imagesCredits.map( (item, i) => {
                                        if (i == index) {
                                            return content;
                                        } else {
                                            return item;
                                        }
                                    }) } )
                                } }
                                placeholder={ __( 'Type the credits here' ) } 
                            />
                            <div className='remove-item' onClick={() => removeImage(index)}><span class="dashicons dashicons-trash"></span></div>
                        </div>
                    )
                })

            )
        }

        return (
            <div className="image-gallery">
                <div className="gallery-grid">
                    {displayImages(images)}
                    <MediaUpload
                        onSelect={(media) => { setAttributes({ images: [...images, ...media] }); }}
                        type="image"
                        multiple={true}
                        value={images}
                        render={({ open }) => (
                            <div className="select-images-button is-button is-default is-large" onClick={open}>
                                <span class="dashicons dashicons-plus"></span>
                            </div>
                        )}
                    />
                </div>

            </div>

        );
    },

    save: ({ attributes }) => {
        const { images = [], imagesDescriptions = [] } = attributes;
        //console.log(imagesDescriptions);


        const displayImages = (images) => {
            return (
                images.map((image, index) => {

                    return (
                        <div className="gallery-item-container">
                            <img
                                className='gallery-item'
                                key={images.id}
                                src={image.url}
                                alt={image.alt}
                            />

                            <span> <RichText.Content tagName="span" value={ imagesDescriptions[index] } /></span>

                        </div>
                    )
                })
            )
        }

        return (
            <div className="image-gallery">
                <div className="gallery-grid" data-total-slides={images.length}>{displayImages(images)}</div>
            </div>
        );

    },
});