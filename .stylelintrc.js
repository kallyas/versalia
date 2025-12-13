/**
 * Stylelint Configuration
 *
 * @package Versalia
 * @since 1.0.0
 */

module.exports = {
	extends: 'stylelint-config-standard',
	rules: {
		'indentation': 'tab',
		'color-hex-case': 'upper',
		'color-hex-length': 'long',
		'selector-class-pattern': null,
		'custom-property-pattern': null,
		'declaration-block-no-redundant-longhand-properties': null,
		'no-descending-specificity': null,
		'at-rule-no-unknown': [
			true,
			{
				ignoreAtRules: ['import']
			}
		]
	}
};
