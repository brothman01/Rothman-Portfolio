import {
    useBlockProps,
    RichText,
    InspectorControls
} from '@wordpress/block-editor';

import {
    TextControl,
    ToggleControl,
    PanelBody,
    PanelRow
} from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {

    const blockProps = useBlockProps();

    return (
        <>
            <InspectorControls>
                <PanelBody title="Cool Settings" initialOpen={false}>
                    <PanelRow>
                        <TextControl
                            label="List ID"
                            onChange={(list_id) => setAttributes({ list_id })}
                            value={attributes.list_id}
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label="Double Opt In"
                            onChange={() => setAttributes({ doubleoptin: !attributes.doubleoptin })}
                            checked={attributes.doubleoptin}
                        />
                    </PanelRow>
                </PanelBody>
            </InspectorControls>
            <div {...blockProps}>
                <RichText
                    tagName="h3"
                    value={attributes.heading}
                    allowedFormats={['core/bold', 'core/italic']}
                    onChange={(heading) => setAttributes({ heading })}
                    placeholder="Enter heading here..."
                />
                <p>
                    <span>Email address</span>
                    <RichText
                        tagName="span"
                        value={attributes.buttonText}
                        allowedFormats={[]}
                        onChange={(buttonText) => setAttributes({ buttonText })}
                        placeholder="Button text..."
                    />
                </p>
            </div>
        </>
    )
}