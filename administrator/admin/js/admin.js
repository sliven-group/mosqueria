// justify-paragraph.js

const { Fragment } = wp.element;
const { BlockControls, AlignmentToolbar } = wp.blockEditor;
const { createHigherOrderComponent } = wp.compose;

// Agrega el botón "Justificar" al toolbar de párrafos
const withJustifyButton = createHigherOrderComponent((BlockEdit) => {
  return (props) => {
    if (props.name !== 'core/paragraph') {
      return <BlockEdit {...props} />;
    }

    const { align } = props.attributes;

    return (
      <Fragment>
        <BlockEdit {...props} />
        <BlockControls group="block">
          <AlignmentToolbar
            value={align}
            onChange={(newAlign) => props.setAttributes({ align: newAlign })}
            alignmentControls={[
              {
                icon: 'editor-alignleft',
                title: 'Alinear a la izquierda',
                align: 'left',
              },
              {
                icon: 'editor-aligncenter',
                title: 'Centrar',
                align: 'center',
              },
              {
                icon: 'editor-alignright',
                title: 'Alinear a la derecha',
                align: 'right',
              },
              {
                icon: 'editor-justify',
                title: 'Justificar',
                align: 'justify',
              },
            ]}
          />
        </BlockControls>
      </Fragment>
    );
  };
}, 'withJustifyButton');

// Filtro para insertar el botón en el editor
wp.hooks.addFilter(
  'editor.BlockEdit',
  'custom/with-justify-button',
  withJustifyButton
);

// Permitir el atributo 'justify' en core/paragraph
wp.hooks.addFilter(
  'blocks.registerBlockType',
  'custom/extend-paragraph-align',
  (settings, name) => {
    if (name === 'core/paragraph') {
      if (!settings.attributes) settings.attributes = {};
      settings.attributes.align = {
        type: 'string',
        default: 'left',
      };
    }
    return settings;
  }
);

// Agregar la clase .has-text-align-justify al guardar
wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'custom/add-justify-class',
  (extraProps, blockType, attributes) => {
    if (blockType.name === 'core/paragraph' && attributes.align === 'justify') {
      extraProps.className = (extraProps.className || '') + ' has-text-align-justify';
    }
    return extraProps;
  }
);
