import { MediaUpload, RichText } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { SortableContainer, SortableElement } from 'react-sortable-hoc';
import arrayMove from 'array-move';

const DraggableImage = SortableElement(({ credits, description, image, removeImage, setDescription, setCredits }) => {
    return (
        <div className="gallery-item-container">
            <img className='gallery-item' src={image.url} key={image.id} />
            <RichText
                tagName="span"
                className="description-field"
                value={description}
                allowedFormats={['core/bold', 'core/italic']}
                onChange={setDescription}
                placeholder={__('Type here your description', 'jeo')}
            />
            <RichText
                tagName="span"
                className="credit-field"
                value={credits}
                allowedFormats={['core/bold', 'core/italic']}
                onChange={setCredits}
                placeholder={__('Type the credits here', 'jeo')}
            />
            <div className="remove-item" onClick={removeImage}><span class="dashicons dashicons-trash"></span></div>
        </div>
    );
});

const ImageGallery = SortableContainer(({ images, imagesCredits, imagesDescriptions, setAttributes }) => {
    const removeImage = (index) => {
        return () => {
            const newImages = images.filter((image, i) => {
                if (i != index) {
                    return image;
                }
            });

            imagesDescriptions.splice(index, 1);
            imagesCredits.splice(index, 1);

            setAttributes({
                images: newImages,
                imagesDescriptions,
                imagesCredits,
            });
        }
    };

    const updateItem = (key, collection, index) => {
        return (content) => {
            setAttributes({
                [key]: collection.map((item, i) => {
                    if (i == index) {
                        return content;
                    } else {
                        return item;
                    }
                })
            });
        };
    };

    return (
        <div className="gallery-grid">
            {images.map((image, index) => {
                return (
                    <DraggableImage
                        collection={images}
                        credits={imagesCredits[index]}
                        description={imagesDescriptions[index]}
                        image={image}
                        index={index}
                        key={image.id}
                        removeImage={removeImage(index)}
                        setCredits={updateItem('imagesCredits', imagesCredits, index)}
                        setDescription={updateItem('imagesDescriptions', imagesDescriptions, index)}
                    />
                );
            })}
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
    );
});

wp.blocks.registerBlockType('jeo-theme/custom-image-gallery-block', {
    title: __('Image Gallery', 'jeo'),
    icon: 'format-gallery',
    category: 'media',
    keywords: [
        __('materialtheme', 'jeo'),
        __('photos', 'jeo'),
        __('images', 'jeo')
    ],
    attributes: {
        galleryTitle: {
            type: 'string',
        },

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

    edit({ attributes, className, setAttributes }) {
        const { galleryTitle = "", images = [], imagesDescriptions = [], imagesCredits = [] } = attributes;

        images.forEach((image, index) => {
            if ( ! imagesDescriptions[index] && imagesDescriptions[index] != '' ) {
                imagesDescriptions[index] = image.description;
            }

            if ( ! imagesCredits[index] && imagesCredits[index] != '') {
                imagesCredits[index] = image.caption;
            }
        });

        const onSortEnd = ({ newIndex, oldIndex }) => {
            setAttributes({
                images: arrayMove(images, oldIndex, newIndex),
                imagesCredits: arrayMove(imagesCredits, oldIndex, newIndex),
                imagesDescriptions: arrayMove(imagesDescriptions, oldIndex, newIndex),
            });
        };

        if ( imagesCredits != attributes.imagesCredits ) {
            setAttributes( { ...attributes, imagesCredits } );
        }

        if ( imagesDescriptions != attributes.imagesDescriptions ) {
            setAttributes( { ...attributes, imagesDescriptions } );
        }

        return (
            <div className="image-gallery">
                <RichText
                    tagName="h2"
                    className="gallery-title"
                    value={galleryTitle}
                    formattingControls={['bold', 'italic']}
                    onChange={(galleryTitle) => {setAttributes({ galleryTitle })}}
                    placeholder={__('Type a title', 'jeo')}
                />
                <ImageGallery
                    axis="xy"
                    helperClass="moving"
                    helperContainer={document.querySelector('.gallery-grid')}
                    images={images}
                    imagesCredits={imagesCredits}
                    imagesDescriptions={imagesDescriptions}
                    onSortEnd={onSortEnd}
                    pressDelay={200}
                    setAttributes={setAttributes}
                />
            </div>
        );
    },

    save: ({ attributes }) => {
        const { galleryTitle = "", images = [], imagesDescriptions = [], imagesCredits = [] } = attributes;

        const displayImages = (images) => {
            return (
                images.map((image, index) => {

                    return (
                        <div className="gallery-item-container">
                            <div className="gallery-item-wrap">
                                <img
                                    className='gallery-item'
                                    key={images.id}
                                    src={image.url}
                                    alt={image.alt}
                                />
                            </div>

                            <div class="image-meta">
                                <div class="image-description">
                                    <RichText.Content tagName="span" value={imagesDescriptions[index]} />
                                </div>
                                <div class="image-credit">
                                    <i class="fas fa-camera"></i>
                                    <RichText.Content tagName="span" value={imagesCredits[index]} />\
                                </div>
                            </div>

                        </div>
                    )
                })
            )
        }

        return (
            <div className="image-gallery">
                <div className="image-gallery-wrapper">
                    <div className="gallery-title">
                        <RichText.Content tagName="h2" value={galleryTitle} />
                    </div>
                    <div className="actions">
                        <button action="display-grid">
                            <i class="fas fa-th"></i>
                        </button>

                        <button action="fullsreen">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>

                    <div className="gallery-grid" data-total-slides={images.length}>
                        {displayImages(images)}
                    </div>
                </div>
            </div>
        );

    },
});