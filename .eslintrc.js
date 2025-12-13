/**
 * ESLint Configuration
 *
 * @package Versalia
 * @since 1.0.0
 */

module.exports = {
	env: {
		browser: true,
		es2021: true,
		node: true
	},
	extends: 'eslint:recommended',
	parserOptions: {
		ecmaVersion: 'latest',
		sourceType: 'module'
	},
	rules: {
		'indent': ['error', 'tab'],
		'linebreak-style': ['error', 'unix'],
		'quotes': ['error', 'single'],
		'semi': ['error', 'always'],
		'no-unused-vars': 'warn',
		'no-console': 'warn'
	}
};
