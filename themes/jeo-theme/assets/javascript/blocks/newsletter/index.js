import {
  RichText,
  MediaUpload,
  BlockControls,
  AlignmentToolbar,
  InnerBlocks,
} from "@wordpress/block-editor";

import { __ } from "@wordpress/i18n";
import { Button } from "@wordpress/components";
//const {  } = wp.editor;

wp.blocks.registerBlockType("jeo-theme/custom-newsletter-block", {
  title: "Newsletter",
  icon: "email",
  category: "common",
  supports: {
    align: true,
  },
  attributes: {
    title: {
      type: "string",
    },
    subtitle: {
      type: "string",
    },

    newsletterShortcode: {
      type: "string",
    },

    lastEditionLink: {
      type: "string",
    },

    adicionalContent: {
      type: "string",
    },

    customStyle: {
      type: "string",
    },
  },

  edit: (props) => {
    const {
      className,
      isSelected,
      attributes: {
        title,
        subtitle,
        newsletterShortcode,
        adicionalContent,
        customStyle,
      },
      setAttributes,
    } = props;

    const onSelectImage = (media) => {
      setAttributes({
        mediaURL: media.url,
        mediaID: media.id,
      });
    };

    return (
      <>
        <div className="newsletter-wrapper" key="container">
          <div class="category-page-sidebar">
            <div class="newsletter">
              <div>
                <i class="fa fa-envelope fa-3x" aria-hidden="true"></i>
                <div class="newsletter-header">
                  
                    <RichText
                      tagName="p"
                      placeholder={__("Title")}
                      value={title}
                      onChange={(value) => setAttributes({ title: value })}
                    />
                  
                </div>

                <div class="customized-content">
                    <RichText
                        tagName="p"
                        className="anchor-text"
                        placeholder={__("Subtitle")}
                        value={subtitle}
                        onChange={(value) => setAttributes({ subtitle: value })}
                    />
                </div>

              </div>

              <div>
                <InnerBlocks
                    allowedBlocks={['core/shortcode']}
                    template={[['core/shortcode', {placeholder: 'Newsletter shortcode'}]]}
			    />
                <RichText
                        tagName="p"
                        className="link"
                        placeholder={__("Adicional Information")}
                        value={adicionalContent}
                        onChange={(value) => setAttributes({ adicionalContent: value })}
                />
              </div>
            </div>
          </div>
        </div>
      </>
    );
  },

  save: (props) => {
    const {
      className,
      isSelected,
      attributes: {
        title,
        subtitle,
        newsletterShortcode,
        adicionalContent,
        align,
      },
      setAttributes,
    } = props;

    return (
        <>
            <div className="newsletter-wrapper" key="container">
                <div class="category-page-sidebar">
                    <div class="newsletter horizontal">
                    <div>
                        <i class="fa fa-envelope fa-3x" aria-hidden="true"></i>
                        <div class="newsletter-header">
                            <p><RichText.Content value={title}/></p> 
                        </div>

                        <p class="anchor-text"><RichText.Content value={subtitle}/></p>
                    </div>

                    <div>
                        <InnerBlocks.Content />
                        <RichText.Content
                                tagName="p"
                                className="link"
                                value={adicionalContent}
                        />
                    </div>
                    </div>
                </div>
            </div>
            
        </>);
  },
});

// [mc4wp_form id="65"]
