const buttonAnimate = {};

buttonAnimate.config = {
    oldContent: "",
    oldWidth: "",
};

buttonAnimate.configurate = (elementTarget) => {
    buttonAnimate.config.oldContent = $(elementTarget).text();
    buttonAnimate.config.oldWidth = $(elementTarget).css('width');
}

buttonAnimate.createAnimationElement = () => {
    let element = $(document.createElement('img'))
    
    element.prop('src', '/assets/Rolling-1s-200px.gif')
    element.css('width', '20px')
    element.css('height', '20px')

    return element;
}

buttonAnimate.initAnimation = (elementTarget) => {
    buttonAnimate.configurate(elementTarget);

    $(elementTarget).css('width', buttonAnimate.config.oldWidth);
    $(elementTarget).text('');
    $(elementTarget).append(buttonAnimate.createAnimationElement());
}

buttonAnimate.releaseAnimation = (elementTarget) => {
    $(elementTarget).css('width', '');
    $(elementTarget).text(buttonAnimate.config.oldContent);
}