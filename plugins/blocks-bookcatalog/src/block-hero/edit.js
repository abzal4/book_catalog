import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaPlaceholder } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, ToggleControl } from '@wordpress/components';
import { useState } from '@wordpress/element';
import './editor.scss';
import { Button } from '@wordpress/components';

const SlideItem = ({index, slide, onImageChange, onRemove}) => {
	return (
		<div className='slide-item'>
			<div className='slide-item-image'>
				<p>Светлая версия Лого</p>
				{slide.lightImage && <div className='image-box'><img src={slide.lightImage} alt='Slide Image' /></div>}
				<MediaPlaceholder 
					icon='format-image'
					onSelect={(media) => onImageChange(media.url, index, "lightImage") }
					onSelectURL={(url) => onImageChange(url, index, "lightImage")}
					labels={{
						title: 'Светлое изображение слайда',
						instructions: 'Загрузите изображение для слайда'
					}}
					accept='image/*'
					allowedTypes={['image']}
					multiple={false}
				/>
			</div>
			<div className='slide-item-image'>
				<p>Темная версия Лого</p>
				{slide.darkImage && <div className='image-box'><img src={slide.darkImage} alt='Slide Image' /></div>}
				<MediaPlaceholder 
					icon='format-image'
					onSelect={(media) => onImageChange(media.url, index, "darkImage") }
					onSelectURL={(url) => onImageChange(url, index, "darkImage")}
					labels={{
						title: 'Темное изображение слайда',
						instructions: 'Загрузите изображение для слайда'
					}}
					accept='image/*'
					allowedTypes={['image']}
					multiple={false}
				/>
			</div>
			<Button className='components-button is-destructive' onClick={()=> onRemove(index)}>Удалить</Button>
		</div>
	)
};

export default function Edit({ attributes, setAttributes }) {
	const { title, description, link, video, linkAnchor, image, isVideo, slides: initialSlides } = attributes;
	const [isVideoUpload, setIsVideoUploaded] = useState(isVideo);
	const [slides, setSlides] = useState( initialSlides || []);

	const onSlideChange = (updatedSlide, index) => {
		const updatedSlides = [...slides];
		updatedSlides[index] = updatedSlide;
		setSlides(updatedSlides);
		setAttributes({slides: updatedSlides});
	};

	const addSlide = () => {
		const newSlide = { lightImage: '', darkImage: ''};
		const updatedSlides = [...slides, newSlide]
		setSlides(updatedSlides);
		setAttributes({ slides: updatedSlides });
	};

	const removeSlide = (index) => {
		const updatedSlides = [...slides];
		updatedSlides.splice(index, 1);
		setSlides(updatedSlides);
		setAttributes({slides: updatedSlides});
	}

	const handleImageChange = (url, index, imageType) => {
		const updatedSlide = {...slides[index], [imageType]: url };
		onSlideChange(updatedSlide, index);
	}

	return (
		<>
			<InspectorControls>
				<PanelBody title="Настройки Hero">
					<TextControl label="Заголовок" value={title} onChange={(title)=>setAttributes({title})}/>
					<TextareaControl label="Описание" value={description} onChange={(description)=>setAttributes({description})}/>
					<TextControl label="Ссылка кнопки" value={link} onChange={(link)=>setAttributes({link})}/>
					<TextControl label="Название кнопки" value={linkAnchor} onChange={(linkAnchor)=>setAttributes({linkAnchor})}/>
					<ToggleControl label="Загрузить видео" checked={isVideoUpload} 
					onChange={(value)=> {
						setIsVideoUploaded(value);
						setAttributes({isVideo: value, video: '', image: ''});
					}} />

					{isVideoUpload ? (
					video &&
						<video controls muted>
							<source src={video} type="video/mp4" />
						</video>
					) : (
						image && <img src={image} alt='Uploaded' />
					)}
					<MediaUpload onSelect={(media)=>{
						if (isVideoUpload) { setAttributes({video: media.url}); } 
						else { setAttributes({image: media.url}); } 
					}}
					type={isVideoUpload ? ['video'] : ['image']}
					render={({open})=>(
						<button className='components-button is-secondary video-upload' onClick={open}>
							{isVideoUpload ? 'Загрузить видео' : 'Загрузить изображение'}
						</button>
					)}/>
				</PanelBody>
				<PanelBody title='Слайдер Hero'>
					{slides.map((slide, index) => (
						<SlideItem 
							key={index}
							index={index}
							slide={slide}
							onImageChange={handleImageChange}
							onRemove={removeSlide}
						/>
					))}
					<Button className='components-button is-primary' onClick={addSlide}>Добавить слайд</Button>
				</PanelBody>	
			</InspectorControls>
			<div { ...useBlockProps() }>
				{isVideo ? (
					<video className='video-bg' loop="loop" autoPlay="" muted playsInline width='100%' height='100%'>
						<source className="source-element" src={video} type="video/mp4" />
					</video>
					) : (
					 <img className="image-bg" src={image} alt="" />
				)}
				<div className='hero-mask'></div>
				<div className='hero-content'>
					<RichText tagName='h1' className='hero_title' value={title} onChange={(title)=>setAttributes({title})} />
					<RichText tagName='p' className='hero_description' value={description} onChange={(title)=>setAttributes({description})} />
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
		</>
	);
}
