const { MediaUpload, RichText } = wp.editor;
const { Button } = wp.components;
const { __ }                = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType('jeo-theme/custom-link-dropdown', {
    title: __('Link Dropdown'),
    icon: 'editor-ul',
    category: 'common',
    keywords: [
        __('link'),
        __('dropdown'),
	],
	supports: {
		align: ['left', 'right'],
	},
    attributes: {
        dropdownTitle: {
            type: 'string',
		},
		newSectionTitle: {
			type: 'string',
		},
		newSectionURL: {
			type: 'string',
		},
        sections: {
            type: 'array',
        },   

        sectionsLinks: {
            type: 'array',
        },
    },

    edit({ attributes, setAttributes}) {
        const { dropdownTitle = "", sections = [], sectionsLinks = [], newSectionTitle = '', newSectionURL = ''} = attributes;

        sections.forEach( (element, index) => {
            if(!sectionsLinks[index]) {
                sectionsLinks[index] = "";
            }
        });

        const removeSection = (removeSectionIndex) => {
            const newSections = sections.filter((section, index) => {
                if (index != removeSectionIndex) {
                    return section;
                }
            });

            sectionsLinks.splice(removeSectionIndex, 1);

            setAttributes({
                sections: newSections,
                sectionsLinks,
            });
        }

        const displaySections = (sections) => {
            
            return (
                sections.map((section, index) => {
                    return (
                        <div className="section">
                            <a href={sectionsLinks[index]} target="_blank">{section}</a>
                            <RichText
                                tagName="p"
                                className="section-url"
                                value={ sectionsLinks[index] }
                                formattingControls={ [ 'bold', 'italic' ] } 
                                onChange={ ( content ) => {
                                    setAttributes( { sectionsLinks: sectionsLinks.map( (item, i) => {
                                        if (i == index) {
                                            return content;
                                        } else {
                                            return item;
                                        }
                                    }) } )
                                } }
                            />
                            <div className='remove-item' onClick={() => removeSection(index)}><span class="dashicons dashicons-trash"></span></div>
                        </div>
                    )
                })
			);
        }

        return (
            <div className="link-dropdown">
				<div className="controls">
					<RichText
						tagName="h2"
						className="dropdown-title"
						value={ dropdownTitle }
						formattingControls={ [ 'bold', 'italic' ] } 
						onChange={ ( dropdownTitle ) => {
							setAttributes( { dropdownTitle } )
						} }
						placeholder={ __( 'Type a title' ) } 
					/>
					<i class="arrow-icon fas fa-angle-down"></i>
				</div>
                <div className="sections">
                    {displaySections(sections)}
                </div>
				<div class="inputs">
					<RichText
						tagName="p"
						className="title-input"
						value={ newSectionTitle }
						formattingControls={ [ 'bold', 'italic' ] } 
						onChange={ ( newSectionTitle ) => {
							setAttributes( { newSectionTitle } )
						} }
						placeholder={ __( 'Section title' ) } 
					/>
					<RichText
						tagName="p"
						className="url-input"
						value={ newSectionURL }
						formattingControls={ [ 'bold', 'italic' ] } 
						onChange={ ( newSectionURL ) => {
							setAttributes( { newSectionURL } )
						} }
						placeholder={ __( 'Section URL (requires HTTPS)' ) } 
					/>
				</div>
				<Button
					onClick={() => {
						if ( !newSectionURL || !newSectionTitle ) {
							alert(__('Please, fill all the fields.'));
							return;
						}

						let newSections = [...sections, newSectionTitle];
						let newSectionsLinks = [...sectionsLinks, newSectionURL];
						setAttributes({
							sections: newSections,
							sectionsLinks: newSectionsLinks,
							newSectionTitle: '',
							newSectionURL: '',
						});
					}}
					isSecondary
				>
					{__('Add new section')}
				</Button>

			</div>
        );
    },

    save: ({ attributes }) => {
        const { dropdownTitle = "", sections = [], sectionsLinks = []} = attributes;

        const displaySections = (sections) => {
            return (
                sections.map((section, index) => {
                    return (
                        <div className="section">
                            <a href={sectionsLinks[index]} target="_blank">{sections[index]}</a>
                        </div>
                    )
                })
            )
        }

        return (
            <div className="link-dropdown">
				<div className="controls saved-block">
					<RichText.Content className="dropdown-title" tagName="h2" value={ dropdownTitle } />
					<i class="arrow-icon fas fa-angle-down"></i>
				</div>
				<div className="sections saved-block">
					{displaySections(sections)}
				</div>
            </div>
		);
    },
});