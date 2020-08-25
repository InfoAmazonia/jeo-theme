import { MediaUpload, RichText } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";

registerBlockType('jeo-theme/custom-team-block', {
    title: __('Team'),
    icon: 'buddicons-buddypress-logo',
    category: 'common',
    keywords: [
        __('Team'),
        __('Members'),
	],
	supports: {
		align: ['center'],
	},
    attributes: {
        teamTitle: {
            type: 'string',
        },

        profilePictures: {
            type: 'array',
        },   

        profileNames: {
            type: 'array',
        },

        memberFunctions: {
            type: 'array'
        },
    },

    edit({ attributes, className, setAttributes}) {
        const { teamTitle = "", profilePictures = [], profileNames = [], memberFunctions = [] } = attributes;

        profilePictures.forEach( (element, index) => {
            if(!profileNames[index]) {
                profileNames[index] = "";
            }

            if(!memberFunctions[index]) {
                memberFunctions[index] = "";
            }
        });

        const removeProfilePicture = (removeProfilePictureIndex) => {
            const newProfilePictures = profilePictures.filter((profilePicture, index) => {
                if (index != removeProfilePictureIndex) {
                    return profilePicture;
                }
            });

            profileNames.splice(removeProfilePictureIndex, 1);
            memberFunctions.splice(removeProfilePictureIndex, 1);

            setAttributes({
                profilePictures: newProfilePictures,
                profileNames,
                memberFunctions
            })
        }

        const displayTeam = (profilePictures) => {
            
            return (
                profilePictures.map((profilePicture, index) => {
                    return (
                        <div className="gallery-item-container">
                            <img className='gallery-item' src={profilePicture.url} key={profilePicture.id} />
                            <RichText
                                tagName="span"
                                className="description-field"
                                value={ profileNames[index] }
                                formattingControls={ [ 'bold', 'italic' ] } 
                                onChange={ ( content ) => {
                                    setAttributes( { profileNames: profileNames.map( (item, i) => {
                                        if (i == index) {
                                            return content;
                                        } else {
                                            return item;
                                        }
                                    }) } )
                                } }
                                placeholder={ __( 'Member name' ) } 
                            />
                            <RichText
                                tagName="span"
                                className="description-field member-function"
                                value={ memberFunctions[index] }
                                formattingControls={ [ 'bold', 'italic' ] } 
                                onChange={ ( content ) => {
                                    setAttributes( { memberFunctions: memberFunctions.map( (item, i) => {
                                        if (i == index) {
                                            return content;
                                        } else {
                                            return item;
                                        }
                                    }) } )
                                } }
                                placeholder={ __( 'Member function' ) } 
                            />
                            <div className='remove-item' onClick={() => removeProfilePicture(index)}><span class="dashicons dashicons-trash"></span></div>
                        </div>
                    )
                })

            )
        }

        return (
            <div className="image-gallery">
                <RichText
                    tagName="h2"
                    className="gallery-title"
                    value={ teamTitle }
                    formattingControls={ [ 'bold', 'italic' ] } 
                    onChange={ ( teamTitle ) => {
                        setAttributes( { teamTitle } )
                    } }
                    placeholder={ __( 'Team Title' ) } 
                />
                <div className="gallery-grid">
                    {displayTeam(profilePictures)}
                    <MediaUpload
                        onSelect={(media) => { setAttributes({ profilePictures: [...profilePictures, ...media] }); }}
                        type="image"
                        multiple={true}
                        value={profilePictures}
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
        const { teamTitle = "", profilePictures = [], profileNames = [], memberFunctions = [] } = attributes;

        const displayTeam = (profilePictures) => {
            return (
                profilePictures.map((profilePicture, index) => {

                    return (
                        <div className="member">
                            <div className="picture-container">
                                <img
                                    className="member-picture"
                                    key={profilePicture.id}
                                    src={profilePicture.url}
                                    alt={profilePicture.alt}
                                />
                            </div>
                            <div className="member-info">
                                <RichText.Content className="member-name" tagName="p" value={ profileNames[index] } />
                                <RichText.Content className="member-function" tagName="p" value={ memberFunctions[index] } />
                            </div>
                        </div>
                    )
                })
            )
        }

        return (
            <div className="team-block">
                <div className="teamBlock-wrapper">
                    <div className="title-container">
                        <RichText.Content className="title" tagName="h2" value={ teamTitle } />
                    </div>
                    <div className="team-container">
                        {displayTeam(profilePictures)}
                    </div>
                </div>
            </div>
        );

    },
});