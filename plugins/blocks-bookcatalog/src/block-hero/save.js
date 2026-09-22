import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes}) {
	const {title, description, link, linkAnchor, video, image, isVideo, slides} = attributes;
	return (
		<div { ...useBlockProps.save() }>
			{isVideo ? (
				<video className='video-bg' loop="loop" autoPlay="" muted playsInline width='100%' height='100%'>
					<source className="source-element" src={video} type="video/mp4" />
				</video>
				) : (
					<img className="image-bg" src={image} alt="" />
			)}
			<div className='hero-mask'></div>
			<div className='hero-content'>
				<RichText.Content tagName='h1' className='hero_title' value={title}/>
				<RichText.Content tagName='p' className='hero_description' value={description}/>
				<a href={link} className='hero-button shadow'>{linkAnchor}</a>
			</div>
			{slides &&
				<div className='hero-slider'>
					<div className='slider_container'>
						<div className='swiper-wrapper'>
							{slides.map((slide, index) => (
								<div key={index} className='swiper-slide slide-item'>
									<img src={slide.lightImage} alt={slide.title} className='light-logo'/>
									<img src={slide.darkImage} alt={slide.title} className='dark-logo'/>
								</div>
							))}
						</div>
					</div>
				</div>
			}
		</div>
	);
}
