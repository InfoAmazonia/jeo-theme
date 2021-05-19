import { MediaUpload, RichText } from "@wordpress/block-editor";
import { Button, ServerSideRender, Disabled } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

wp.blocks.registerBlockType("jeo-theme/custom-image-block-editor", {
    title: "Credited Image",
    icon: "format-image",
    category: "media",
    supports: {
        align: true,
    },
    attributes: {
        mediaID: {
            type: "number",
        },
        mediaURL: {
            type: "string",
        },
    },

    edit: (props) => {
        const {
            className,
            isSelected,
            attributes: {
                mediaID,
                mediaURL,
            },
            setAttributes,
        } = props;

        const onChangeTitle = (value) => {
            setAttributes({ title: value });
        };

        const onSelectImage = (media) => {
            setAttributes({
                mediaURL: media.url,
                mediaID: media.id,
                updated: Date.now(),
            });
        };

        const [imageClasses, textClasses, wrapClass] = [
            "left",
            className,
            "image-block-container",
        ];

        return (
            <>
                <div className={wrapClass} key="container">
                    <div className={ "callout-image" + (!mediaID ? ' not-selected' : ' selected-image') } >
                        <MediaUpload
                            onSelect={onSelectImage}
                            type="image"
                            value={mediaID}
                            render={({ open }) => (
                                <>
                                    <Button
                                        isPrimary
                                        className={
                                            mediaID
                                                ? "image-button margin-auto"
                                                : "image-button button-large margin-auto"
                                        }
                                        onClick={open}
                                    >
                                        {!mediaID ? __("Upload Image", "jeo") : __("Edit image", "jeo")}
                                    </Button>
                                </>
                            )}
                        />
                    </div>
                    <Disabled>
                        <ServerSideRender
                            block="jeo-theme/custom-image-block-editor"
                            attributes={ {...props.attributes }}
                        />
                    </Disabled>
                </div>

                
            </>
        );
    },

    save: (props) => {
        const {
            className,
            attributes: {
                mediaID,
                mediaURL,
                title,
                mediaDescription,
                align,
            },
        } = props;

        return null;
    },
});
