function showMod(divMod, contentMargin = 200){
    $(divMod).css('visibility', 'visible').css('opacity', '1');
    $(divMod).children().css('margin-top', `${contentMargin}px`);
}

function hideMod(divMod){
    $(divMod).css('visibility', 'hidden').css('opacity', '0');
    $(divMod).children().css('margin-top', `0`);
}