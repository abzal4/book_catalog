
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import './editor.scss';
import placeholder from "./img/default.png";

export default function Edit({ attributes, setAttributes }) {
	const { count } = attributes;
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'blocks-bookcatalog' ) }>
					<TextControl 
						label = { __( 'Count', 'blocks-bookcatalog' ) }
						value={ count }
						onChange={ ( val ) => setAttributes( { count: parseInt(val,10) || 0 } )}
					/>
				</PanelBody>
			</InspectorControls>
			<p { ...useBlockProps() }>
				<img src={placeholder} />
			</p>
		</>
	);
}
