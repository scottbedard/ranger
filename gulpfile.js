// Get modules
var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minify = require('gulp-minify-css');

gulp.task('css', function () {
	// Main style
	gulp.src('app/assets/scss/main.scss')
		.pipe(sass())
		.pipe(autoprefixer('last 10 version'))
		.pipe(minify())
		.pipe(gulp.dest('public/assets/css'));
});

gulp.task('watch', function () {
	gulp.watch('app/assets/scss/**/*.scss', ['css']);
});

gulp.task('default', ['watch']);