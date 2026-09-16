import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const { cartLink } = attributes;
	return (
		<div { ...useBlockProps.save() }>
			<div className='inner-header'>
				<InnerBlocks.Content />
				<div className='right-section'>
					<div className='header-search'></div>
					<div className='header-mode-switcher'>
						<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none">
							<circle cx="12" cy="12" r="4" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.8"/>
							<path d="M12 2V4" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.8" stroke-linecap="round"/>
							<path d="M12 20V22" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.8" stroke-linecap="round"/>
							<path d="M4.93 4.93L6.34 6.34" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.8" stroke-linecap="round"/>
							<path d="M17.66 17.66L19.07 19.07" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.8" stroke-linecap="round"/>
							<path d="M2 12H4" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.8" stroke-linecap="round"/>
							<path d="M20 12H22" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.8" stroke-linecap="round"/>
							<path d="M4.93 19.07L6.34 17.66" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.8" stroke-linecap="round"/>
							<path d="M17.66 6.34L19.07 4.93" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.8" stroke-linecap="round"/>
						</svg>
					</div>
					{cartLink &&
						(<div className='header-cart-link'>
							<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none">
								<path d="M8 9V6 C8 3.79 9.79 2 12 2 C14.21 2 16 3.79 16 6V9" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.8" stroke-linecap="round" />
								<path d="M4 8H20L18.5 21H5.5L4 8Z" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.8" stroke-linejoin="round" />
								<path d="M7 12H17" stroke="var(--action-main, rgba(14,13,15,0.64))" stroke-width="1.5" stroke-linecap="round" /> 
							</svg><a href={cartLink}></a> 
						</div>)
					}
				</div>
			</div>
		</div>
	);
}
