import { compose, ifCondition } from '@wordpress/compose';
import { registerFormatType } from '@wordpress/rich-text';
import { RichTextToolbarButton } from '@wordpress/block-editor';
import { withSelect } from '@wordpress/data';
 
const MyCustomButton = props => {
    alert('asdasd');
    return <RichTextToolbarButton
        icon='editor-code'
        title='Sample output'
        onClick={ () => {
            console.log( 'toggle format' );
        } }
    />
};
 
const ConditionalButton = compose(
    withSelect( function( select ) {
        return {
            selectedBlock: select( 'core/editor' ).getSelectedBlock()
        }
    } ),
    ifCondition( function( props ) {
        return true
    } )
)( MyCustomButton );
 
registerFormatType(
    'my-custom-format/sample-output', {
        title: 'Sample output',
        tagName: 'samp',
        className: null,
        edit: ConditionalButton,
    }
);