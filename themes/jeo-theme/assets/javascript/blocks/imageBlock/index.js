alert('wdeasdasd');


wp.blocks.registerBlockType( 'jeo-theme/custom-image-block-editor', {
    title: 'Featured Image',
    icon: 'format-image',
    category: 'media',
    example: {},
    attributes: {
        title: {
            type: "array",
            source: "children",
            selector: ".callout-title"
        },
        mediaID: {
            type: "number"
        },
        mediaURL: {
            type: "string",
            source: "attribute",
            selector: "img",
            attribute: "src"
        },
        body: {
            type: "array",
            source: "children",
            selector: ".callout-body"
        },
        alignment: {
            type: "string"
        }
    },
    edit() {
        return (<div>Hello</div>);
    },
    save() {
        return (<div>Hello</div>)
    },
} );