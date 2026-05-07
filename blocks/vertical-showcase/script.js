jQuery(function ($) {
    console.log('CB Showcase JS initialized');

    $('[data-cb-showcase]').each(function () {
        const $slider = $(this);
        const $content = $slider.find('.cb-vshowcase__content');
        const $images  = $slider.find('.cb-vshowcase__image');
        const $thumbs  = $slider.find('.cb-vshowcase__thumb');
        const total    = $content.length;

        console.log(`Found ${total} slides for showcase`);

        let current = 0;

        function goToSlide(index) {
            current = (index + total) % total;

            $content.removeClass('is-active').eq(current).addClass('is-active');
            $images.removeClass('is-active').eq(current).addClass('is-active');
            $thumbs.removeClass('is-active').eq(current).addClass('is-active');

            console.log('→ Switched to slide', current);
        }

        // Navigation
        $slider.find('.cb-vshowcase__next').on('click', () => goToSlide(current + 1));
        $slider.find('.cb-vshowcase__prev').on('click', () => goToSlide(current - 1));

        // Thumbnails
        $thumbs.on('click', function () {
            const index = parseInt($(this).data('slide'), 10);
            goToSlide(index);
        });

        // Initialize
        goToSlide(0);
    });
});