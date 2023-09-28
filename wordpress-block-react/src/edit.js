/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

/**
 * Internal dependencies
 */
import './editor.scss';

/**
 * Edit Component
 */
export default function Edit() {
    return (
        <div {...useBlockProps()}>
            {__(
                'Inspector Control Groups Block',
                'inspector-control-groups'
            )}
            <InspectorControls group="color">
                <div className="full-width-control-wrapper">
                    {__(
                        "I'm in the colors group!",
                        'inspector-control-groups'
                    )}
                    < input type="text" />
                </div>
            </InspectorControls>
            <InspectorControls group="typography">
                <div className="full-width-control-wrapper">
                    {__(
                        "I'm in the typography group!",
                        'inspector-control-groups'
                    )}
                </div>
            </InspectorControls>
            <InspectorControls group="dimensions">
                <div className="full-width-control-wrapper">
                    {__(
                        "I'm in the dimensions group!",
                        'inspector-control-groups'
                    )}
                </div>
            </InspectorControls>
            <InspectorControls group="border">
                <div className="full-width-control-wrapper">
                    {__(
                        "I'm in the border group!",
                        'inspector-control-groups'
                    )}
                </div>
            </InspectorControls>
        </div>
    );
}