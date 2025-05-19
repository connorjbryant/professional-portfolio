const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');

function styles() {
  return gulp.src('./sass/style.scss')
    .pipe(sass({ outputStyle: 'expanded' }).on('error', sass.logError))
    .pipe(gulp.dest('./build/css/')) // Output regular CSS
    .pipe(cleanCSS())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('./build/css/')); // Output minified CSS
}

function scripts() {
  return gulp.src('./js/**/*.js')
    .pipe(gulp.dest('./build/js/')) // Output regular JS
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('./build/js/')); // Output minified JS
}

function watch() {
  gulp.watch('./sass/**/*.scss', styles);
  gulp.watch('./js/**/*.js', scripts);
}

exports.styles = styles;
exports.scripts = scripts;
exports.watch = watch;
exports.default = gulp.series(styles, scripts, watch);
exports.default = gulp.series(styles, scripts, watch);