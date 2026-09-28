import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, MediaPlaceholder } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import './editor.scss';
import { ServerSideRender } from '@wordpress/server-side-render';

export default function Edit({ attributes, setAttributes }) {
	const { count, title, description, image } = attributes;
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'blocks-bookcatalog' ) }>
					<TextControl 
						label = { __( 'Count', 'blocks-bookcatalog' ) }
						value={ count }
						onChange={ ( val ) => setAttributes( { count: parseInt(val,10) || 0 } )}
					/>
					<TextControl 
						label = { __( 'Title', 'blocks-bookcatalog' ) }
						value={ title }
						onChange={ ( title ) => setAttributes( { title } )}
					/>
					<TextareaControl
						label = { __( 'Description', 'blocks-bookcatalog' ) }
						value={ description }
						onChange={ ( description ) => setAttributes( { description } )}
					/>
					{ image && (<img src={image} />)}
					<MediaPlaceholder
						icon = "format-image"
						labels = { { title: 'Image' } }
						onSelect={ (media) => setAttributes( { image: media.url } ) }
						accept='image/*'
						allowedTypes={ ['image'] }
						notices = { [ 'Image' ] }
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<ServerSideRender 
					block="blocks-bookcatalog/recent-news"
					attributes={attributes}
				/>
			</div>
		</>
	);
}
