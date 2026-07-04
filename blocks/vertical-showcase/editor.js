(function (wp) {
  const { registerBlockType } = wp.blocks;
  const { __ } = wp.i18n;
  const { useBlockProps, RichText, InspectorControls } = wp.blockEditor;
  const { PanelBody, SelectControl } = wp.components;
  const { useSelect } = wp.data;
  const { createElement, Fragment } = wp.element;

  registerBlockType('brutalist-portfolio/vertical-showcase', {
    edit({ attributes = {}, setAttributes }) {
      const groups = useSelect((select) => {
        return select('core').getEntityRecords('taxonomy', 'showcase_group', {
          per_page: -1,
          hide_empty: false
        });
      }, []);

      const groupOptions = [
        { label: __('All showcase slides', 'brutalist-portfolio'), value: '' },
        ...(groups || []).map((group) => ({
          label: group.name,
          value: group.slug
        }))
      ];

      return createElement(
        Fragment,
        {},
        createElement(
          InspectorControls,
          {},
          createElement(
            PanelBody,
            {
              title: __('Showcase Settings', 'brutalist-portfolio'),
              initialOpen: true
            },
            createElement(SelectControl, {
              label: __('Showcase Group', 'brutalist-portfolio'),
              value: attributes.showcaseGroup || '',
              options: groupOptions,
              onChange: (value) => setAttributes({ showcaseGroup: value }),
              help: __('Choose which showcase slides this block should display.', 'brutalist-portfolio')
            })
          )
        ),
        createElement(
          'section',
          useBlockProps({ className: 'cb-vshowcase-editor' }),
          createElement(RichText, {
            tagName: 'p',
            className: 'cb-vshowcase__kicker',
            value: attributes.kicker,
            placeholder: __('Add kicker…', 'brutalist-portfolio'),
            onChange: (value) => setAttributes({ kicker: value })
          }),
          createElement('strong', {}, __('Vertical Showcase Slider', 'brutalist-portfolio')),
          createElement(
            'p',
            {},
            attributes.showcaseGroup
              ? __('Frontend renders slides from the selected showcase group.', 'brutalist-portfolio')
              : __('Frontend renders all showcase slides.', 'brutalist-portfolio')
          )
        )
      );
    },

    save() {
      return null;
    }
  });
})(window.wp);