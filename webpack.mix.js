/* eslint-disable no-undef */
const mix = require('laravel-mix');
const fs = require('fs');
const ESLintPlugin = require('eslint-webpack-plugin');
const configEslint = {
	fix: false,
	extensions: ['js'],
};

require('laravel-mix-clean');
require('laravel-mix-versionhash');

function mixMultiple(folder, method, srcExt, outputExt) {
	const paths = fs.readdirSync(folder);

	for (let i = 0; i < paths.length; i++) {
		if (paths[i].indexOf('.' + srcExt) > 0 && paths[i].charAt(0) !== '_') {
			const filePath = folder + paths[i];

			mix[method](filePath, outputExt);
		}
	}
}

mix.setPublicPath('./assets');

mix.js('src/js/script.js', 'js');
mixMultiple('src/js/blocks/', 'js', 'js', 'js');
mixMultiple('src/js/templates/', 'js', 'js', 'js');

mix.sass('src/scss/style.scss', 'css');
mixMultiple('src/scss/blocks/', 'sass', 'scss', 'css');
mixMultiple('src/scss/templates/', 'sass', 'scss', 'css');

mix.extract();

mix.options({
	processCssUrls: false,
	postCss: [
		// eslint-disable-next-line no-undef
		require('postcss-discard-comments')({
			removeAll: true,
		}),
	],
	uglify: {
		comments: false,
	},
	terser: {
		extractComments: false,
	},
});

mix.browserSync({
	proxy: 'local.mosqueirawp.com',
	port: 3000,
	open: false,
	files: ['./**/*.php', './**/*.js', './**/*.scss'],
	ignore: ['./.git', './**/node_modules', './build', './vendor'],
});

mix.clean({
	cleanOnceBeforeBuildPatterns: ['./js/*', './css/*'],
});

if (mix.inProduction()) {
	mix.versionHash();
} else {
	mix.sourceMaps();
	mix.webpackConfig({
		plugins: [new ESLintPlugin(configEslint)],
		devtool: 'source-map',
	});
}

mix.disableNotifications();
