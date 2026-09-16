document.addEventListener('DOMContentLoaded', () => {
	//Dark mode style
    let styleMode = localStorage.getItem('styleMode');
    const styleToggle = document.querySelector('.header-mode-switcher');

    const enableDarkStyle = () => {
        document.body.classList.add('dark-mode-bookcatalog');
        localStorage.setItem('styleMode', 'dark')
    }

    const disableDarkStyle = () => {
        document.body.classList.remove('dark-mode-bookcatalog');
        localStorage.setItem('styleMode', null)
    }

    if (styleToggle) {
        styleToggle.addEventListener('click' , () => {
            styleMode = localStorage.getItem('styleMode');
            if (styleMode !== 'dark') {
                enableDarkStyle();
            }
            else {
                disableDarkStyle();
            }
        });
    }

    if (styleMode === 'dark' ) {
        enableDarkStyle();
    }
});
