const gulp = require('gulp');
const clean = require('gulp-clean');
const sass = require('gulp-sass')(require('sass'));
const imagemin = require('gulp-imagemin');
const svgmin = require('gulp-svgmin');
const newer = require('gulp-newer');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const jshint = require('gulp-jshint');
const plumber = require('gulp-plumber');
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');

const onError = (err) => {
    console.error(err.message);
    this.emit ? this.emit('end') : null;
};

/**
 * STYLES TASK
 */
function styles() {
    return gulp.src('assets/styles/**/*.scss')
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sourcemaps.init())
        .pipe(sass({ includePaths: ['node_modules'] }).on('error', sass.logError))
        .pipe(postcss([autoprefixer()]))
        .pipe(sourcemaps.write('maps', { includeContent: false, sourceRoot: 'source' }))
        .pipe(cleanCSS())
        .pipe(gulp.dest('../_dist/css/'));
}

/**
 * ADMIN (LOGIN SCREEN) STYLES TASK
 */
function adminStyles() {
    return gulp.src('assets/styles/client.scss')
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sourcemaps.init())
        .pipe(sass({ includePaths: ['node_modules'] }).on('error', sass.logError))
        .pipe(postcss([autoprefixer()]))
        .pipe(sourcemaps.write('maps', { includeContent: false, sourceRoot: 'source' }))
        .pipe(cleanCSS())
        .pipe(gulp.dest('../_dist/css/'));
}

/**
 * JAVASCRIPT TASKS
 */
function scriptsLinter() {
    return gulp.src('assets/scripts/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
}

function scripts() {
    return gulp.src(['assets/scripts/bundler/*'])
        .pipe(plumber({ errorHandler: onError }))
        .pipe(concat('main.js'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest('../_dist/js'));
}

function scriptsIndividual() {
    return gulp.src(['assets/scripts/libs/*'])
        .pipe(plumber({ errorHandler: onError }))
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest('../_dist/js/libs'));
}

/**
 * IMAGE TASKS
 */
function images() {
    return gulp.src(['assets/images/**/*', '!assets/images/**/*.svg', '!**/Thumbs.db'])
        .pipe(plumber({ errorHandler: onError }))
        .pipe(newer('../_dist/images'))
        .pipe(imagemin())
        .pipe(gulp.dest('../_dist/images'));
}

function svgImages() {
    return gulp.src('assets/images/**/*.svg')
        .pipe(svgmin())
        .pipe(gulp.dest('../_dist/images'));
}

/**
 * FONTS AND FAVICONS TASKS
 */
function fonts() {
    return gulp.src('assets/fonts/**/*')
        .pipe(plumber({ errorHandler: onError }))
        .pipe(gulp.dest('../_dist/fonts'));
}

function favicons() {
    return gulp.src('assets/favicons/**/*')
        .pipe(gulp.dest('../_dist/favicons'));
}

/**
 * CLEAN TASKS
 */
function cleanDist() {
    return gulp.src(['../_dist/css', '../_dist/js'], { read: false, allowEmpty: true })
        .pipe(clean({ force: true }));
}

function cleanAll() {
    return gulp.src(['../_dist/css', '../_dist/js', '../_dist/images', '../_dist/fonts', '../_dist/favicons'], { read: false, allowEmpty: true })
        .pipe(clean({ force: true }));
}

/**
 * WATCH TASK
 */
function watch() {
    gulp.watch('assets/styles/**/*.scss', gulp.series(styles, adminStyles));
    gulp.watch('assets/scripts/**/*', gulp.series(scriptsLinter, scripts, scriptsIndividual));
    gulp.watch('assets/fonts/**/*', fonts);
    gulp.watch('assets/favicons/**/*', favicons);
    gulp.watch('assets/images/**/*', gulp.series(images, svgImages));
}

const build = gulp.series(
    cleanDist,
    gulp.parallel(styles, adminStyles, scriptsLinter, scripts, scriptsIndividual, fonts, favicons, images, svgImages)
);

const rebuild = gulp.series(
    cleanAll,
    gulp.parallel(styles, adminStyles, scriptsLinter, scripts, scriptsIndividual, fonts, favicons, images, svgImages)
);

exports.styles = styles;
exports.adminStyles = adminStyles;
exports.scripts = scripts;
exports.images = images;
exports.fonts = fonts;
exports.favicons = favicons;
exports.clean = cleanDist;
exports.watch = gulp.series(build, watch);
exports.build = build;
exports.rebuild = rebuild;
exports.default = build;
