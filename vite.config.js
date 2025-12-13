/**
 * Vite Configuration
 *
 * @package Versalia
 * @since 1.0.0
 */

import { defineConfig } from 'vite';
import legacy from '@vitejs/plugin-legacy';
import { resolve } from 'path';

export default defineConfig({
	plugins: [
		legacy({
			targets: ['defaults', 'not IE 11']
		})
	],

	build: {
		// Output directory
		outDir: 'assets/dist',

		// Generate source maps for debugging
		sourcemap: true,

		// Rollup options
		rollupOptions: {
			input: {
				// JavaScript entry points
				navigation: resolve(__dirname, 'assets/js/navigation.js'),
				'reading-mode': resolve(__dirname, 'assets/js/reading-mode.js'),
				'poem-navigation': resolve(__dirname, 'assets/js/poem-navigation.js'),
				'customizer-preview': resolve(__dirname, 'assets/js/customizer-preview.js'),
			},

			output: {
				// Output filenames
				entryFileNames: '[name].js',
				chunkFileNames: '[name].js',
				assetFileNames: '[name].[ext]'
			}
		},

		// Minification
		minify: 'terser',
		terserOptions: {
			compress: {
				drop_console: true
			}
		}
	},

	// Development server configuration
	server: {
		port: 3000,
		strictPort: false,
		open: false
	},

	// CSS configuration
	css: {
		devSourcemap: true
	}
});
