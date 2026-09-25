
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import './editor.scss';


export default function Edit() {
	return (
		<p { ...useBlockProps() }>
			{ __(
				'Blocks Book Catalog – hello from the editor!',
				'blocks-bookcatalog'
			) }
		</p>
	);
}
