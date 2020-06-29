import {
    RichText,
    MediaUpload,
    BlockControls,
    AlignmentToolbar,
} from "@wordpress/block-editor";
import Vue from "vue";

import ImageBlock from "../../components/imageBlock/ImageBlock";

import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";
import { Button } from "@wordpress/components";

wp.blocks.registerBlockType("jeo-theme/custom-image-block-editor", {
    title: "Credited Image",
    icon: "format-image",
    category: "media",
    supports: {
        align: true,
    },
    attributes: {
        title: {
            type: "array",
            source: "children",
            selector: ".callout-title",
        },
        mediaID: {
            type: "number",
        },
        mediaURL: {
            type: "string",
            source: "attribute",
            selector: "img",
            attribute: "src",
        },

        mediaDescription: {
            type: "string",
        },
        body: {
            type: "array",
            source: "children",
            selector: ".callout-body",
        },
        alignment: {
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
                body,
                alignment,
                title,
                mediaDescription,
            },
            setAttributes,
        } = props;

        // useEffect(() => {
        //   // console.log(props);
        // });

        const onChangeTitle = (value) => {
            setAttributes({ title: value });
        };

        const onChangeDescription = (value) => {
            setAttributes({ mediaDescription: value });
        };

        const onSelectImage = (media) => {
            setAttributes({
                mediaURL: media.url,
                mediaID: media.id,
            });
        };

        const onChangeBody = (value) => {
            setAttributes({ body: value });
        };

        const onIconClick = () => { };

        const [imageClasses, textClasses, wrapClass] = [
            alignment || "left",
            className,
            "image-block-container",
        ];

        return (
            <>
                <div className={wrapClass} key="container">
                    <div className={imageClasses}>
                        <div className="callout-image">
                            <MediaUpload
                                onSelect={onSelectImage}
                                type="image"
                                value={mediaID}
                                render={({ open }) => (
                                    <>
                                        <Button
                                            isSecondary
                                            className={
                                                mediaID
                                                    ? "image-button margin-auto"
                                                    : "image-button button-large margin-auto"
                                            }
                                            onClick={open}
                                        >
                                            {!mediaID ? __("Upload Image") : __("Replace image")}
                                        </Button>
                                        {mediaID ? (
                                            <div className="image-wrapper">
                                                <img src={mediaURL} />
                                                <div class="image-info-wrapper">
                                                    <span
                                                        class="dashicons image-icon dashicons-camera-alt"
                                                        onclick={onIconClick}
                                                    ></span>
                                                    <RichText
                                                        tagName="span"
                                                        className="image-meta"
                                                        placeholder={__("Write a info here.")}
                                                        value={mediaDescription}
                                                        onChange={onChangeDescription}
                                                    />
                                                </div>
                                            </div>
                                        ) : (
                                                ""
                                            )}
                                    </>
                                )}
                            />
                        </div>
                    </div>
                    <div className={textClasses}>
                        <RichText
                            tagName="span"
                            className="callout-title image-description margin-auto"
                            placeholder={__("Write a description here.")}
                            value={title}
                            onChange={onChangeTitle}
                        />
                    </div>
                </div>
            </>
        );
    },

    save: (props) => {
        const {
            className,
            attributes: { title, mediaURL, mediaDescription },
        } = props;

        return (
            <>
                <div className="image-block-container" key="container">
                    <div>
                        <div className="callout-image">
                            {mediaURL ? (
                                <div className="image-wrapper">
                                    <img src={mediaURL} />
                                    <div class="image-info-wrapper">
                                        <span
                                            class="dashicons image-icon dashicons-camera-alt"
                                        ></span>
                                        <span class="image-meta">{mediaDescription}</span>
                                    </div>
                                </div>
                            ) : (
                                    ""
                                )}
                        </div>
                    </div>
                    <div>{title}</div>
                </div>
            </>
        );
    },
});
