window.setInterval(function () {

    jQuery.ajax(location.href, {
        dataType: 'html'
    })
    .done(function (html) {
        html = jQuery.parseHTML(html);
        html.forEach(function (node) {
            if (node.className && node.className == 'page-wrapper') {
                var newEl, currentEl;
                if ((newEl = node.querySelector('.row')) && (currentEl = document.querySelector('.row'))) {
                    currentEl.innerHTML = newEl.innerHTML;
                }
            }
        });
    });

}, 30000);