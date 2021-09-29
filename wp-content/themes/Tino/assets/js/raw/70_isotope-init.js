$(document).ready(function () {
    // external js: isotope.pkgd.js

    setTimeout(function () {
    // init Isotope
        // external js: isotope.pkgd.js

    // init Isotope
        var $grid = $('.grid').isotope({
            itemSelector: '.element-item',
            percentPosition: true,
            layoutMode: 'vertical',
            resize: true
        });
    // bind filter button click
        $('.filter-faq').on( 'click', 'button', function() {
            var filterValue = $( this ).attr('data-filter');
            $grid.isotope({ filter: filterValue });
        });
    // change is-checked class on buttons
        $('.filter-faq-btn').each( function( i, buttonGroup ) {
            var $buttonGroup = $( buttonGroup );
            $buttonGroup.on( 'click', 'button', function() {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
                $( this ).addClass('is-checked');
            });
        });
        $('.tiger-child-faq').on('click',function (e) {
            e.preventDefault();
            $(this).parents('.child-faq').toggleClass('active').find('.child-faq-content').stop().slideToggle(400,function () {
                $grid.isotope('layout');
            });
            $(this).parents('.child-faq-item').toggleClass('active');
        });
        $('.button.is-checked').click();
    },100);

});