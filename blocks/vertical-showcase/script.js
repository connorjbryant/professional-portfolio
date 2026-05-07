jQuery(function ($) {
    $('[data-cb-showcase]').each(function () {
        const $slider = $(this);
        const $content = $slider.find('.cb-vshowcase__content');
        const $images  = $slider.find('.cb-vshowcase__image');
        const $thumbs  = $slider.find('.cb-vshowcase__thumb');
        const total    = $content.length;

        if (!total) {
            return;
        }

        let current = 0;

        function goToSlide(index) {
            current = (index + total) % total;

            $content.removeClass('is-active').eq(current).addClass('is-active');
            $images.removeClass('is-active').eq(current).addClass('is-active');
            $thumbs.removeClass('is-active').eq(current).addClass('is-active');
        }

        $slider.find('.cb-vshowcase__next').on('click', function (e) {
            e.preventDefault();
            goToSlide(current + 1);
        });

        $slider.find('.cb-vshowcase__prev').on('click', function (e) {
            e.preventDefault();
            goToSlide(current - 1);
        });

        $thumbs.on('click', function (e) {
            e.preventDefault();
            goToSlide(parseInt($(this).attr('data-slide'), 10));
        });

        goToSlide(0);
    });
});