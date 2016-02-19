$(function () {
    $('.tree li:has(ul)').addClass('parent_li').find(' > span');
    $('.tree li ul > li').hide();
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).find(' > i').addClass('fa-plus').removeClass('fa-minus');
        } else {
            children.show('fast');
            $(this).find(' > i').addClass('fa-minus').removeClass('fa-plus');
        }
        e.stopPropagation();
    });
});