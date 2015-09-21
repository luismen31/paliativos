function createNoty(message, type) {
    var html = '<div class="alert alert-' + type + ' alert-dismissable page-alert">';    
    html += '<button type="button" class="close"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>';
    html += message;
    html += '</div>';    
    $(html).hide().prependTo('#noty-holder').slideDown();
};