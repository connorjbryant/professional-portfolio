window.addEventListener('DOMContentLoaded', function() {
    const { __ } = wp.i18n;
    const { useBlockProps } = wp.blockEditor;

    wp.blocks.registerBlockType('brutalist-portfolio/hero-blob', {
        apiVersion: 2,
        title: __('Hero Blob', 'brutalist-portfolio'),
        icon: 'universal-access-alt',
        category: 'layout',
        edit() {
            return (
                wp.element.createElement(
                    'section',
                    {
                        ...useBlockProps({ className: 'hero-blob-block' }),
                        style: {
                            position: 'relative',
                            // Full width handled by alignfull class
                            background: '#fff',
                            overflow: 'hidden',
                            minHeight: '260px',
                            display: 'flex',
                            alignItems: 'center',
                        }
                    },
                    wp.element.createElement('div', {
                        className: 'hero-blob-blobs',
                        style: {
                            position: 'absolute',
                            top: 0,
                            left: 0,
                            width: '100%',
                            height: '100%',
                            zIndex: 0,
                            pointerEvents: 'none',
                            overflow: 'hidden',
                        }
                    },
                        wp.element.createElement('div', { className: 'hero-blob-blob blob1' }),
                        wp.element.createElement('div', { className: 'hero-blob-blob blob2' }),
                        wp.element.createElement('div', { className: 'hero-blob-blob blob3' })
                    ),
                    wp.element.createElement(
                        'div',
                        {
                            className: 'hero-blob-content',
                            style: {
                                position: 'relative',
                                zIndex: 1,
                                width: '100%',
                                display: 'flex',
                                justifyContent: 'center',
                                alignItems: 'center',
                            }
                        },
                        wp.element.createElement('div', {
                            style: {
                                maxWidth: 'var(--global-max-width, 900px)',
                                width: '100%',
                                margin: '0 auto',
                                padding: '3rem 1.5rem',
                                textAlign: 'center',
                            }
                        },
                            wp.element.createElement('h1', {
                                style: {
                                    fontSize: 'clamp(2.5rem, 8vw, 5rem)',
                                    color: 'var(--accent, #fcb07a)', // Changed to accent color
                                    margin: 0,
                                    fontWeight: 700,
                                    letterSpacing: '-0.03em',
                                }
                            }, __('About', 'brutalist-portfolio'))
                        )
                    )
                )
            );
        },
        save() {
            // Rendering handled by PHP
            return null;
        },
    });
});
