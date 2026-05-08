jQuery(function ($) {
    $('[data-cb-showcase]').each(function () {
        const $slider = $(this);
        const $content = $slider.find('.cb-vshowcase__content');
        const $images = $slider.find('.cb-vshowcase__image');
        const $thumbs = $slider.find('.cb-vshowcase__thumb');
        const $lightbox = $slider.find('.cb-vshowcase__lightbox');
        const $lightboxImg = $slider.find('.cb-vshowcase__lightbox-img');
        const total = $images.length;

        if (!total) return;

        let current = 0;

        function goToSlide(index) {
            current = (index + total) % total;

            $content.removeClass('is-active').eq(current).addClass('is-active');
            $images.removeClass('is-active').eq(current).addClass('is-active');
            $thumbs.removeClass('is-active').eq(current).addClass('is-active');
        }

        function openLightbox() {
            const $activeImage = $images.eq(current);
            const fullImage = $activeImage.attr('data-full-image');
            const imageTitle = $activeImage.attr('data-image-title') || '';

            if (!fullImage) return;

            $lightboxImg.attr('src', fullImage).attr('alt', imageTitle);

            // Move lightbox outside the block so fixed positioning works correctly
            if (!$lightbox.parent().is('body')) {
                $lightbox.appendTo('body');
            }

            $lightbox.addClass('is-active').attr('aria-hidden', 'false');
            $('body').addClass('cb-lightbox-open');
        }

        function closeLightbox() {
            $lightbox.removeClass('is-active').attr('aria-hidden', 'true');
            $('body').removeClass('cb-lightbox-open');

            setTimeout(function () {
                $lightboxImg.attr('src', '').attr('alt', '');

                // Move it back into this slider after closing
                $slider.append($lightbox);
            }, 200);
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

            const slideIndex = parseInt($(this).attr('data-slide'), 10);

            if (!isNaN(slideIndex)) {
                goToSlide(slideIndex);
            }
        });

        $slider.find('.cb-vshowcase__lightbox-open').on('click', function (e) {
            e.preventDefault();
            openLightbox();
        });

        $(document).on('click', '.cb-vshowcase__lightbox-close', function (e) {
            e.preventDefault();
            closeLightbox();
        });

        $(document).on('click', '.cb-vshowcase__lightbox', function (e) {
            if ($(e.target).hasClass('cb-vshowcase__lightbox')) {
                closeLightbox();
            }
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && $lightbox.hasClass('is-active')) {
                closeLightbox();
            }
        });

        goToSlide(0);
    });
});