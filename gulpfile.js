var gulp = require('gulp');
var watch = require('gulp-watch');
var path = require('path');
var concat = require('gulp-concat');
//
var jshint = require('gulp-jshint');
var jsmin = require('gulp-jsmin');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var gutil = require('gulp-util');
var imagemin = require('gulp-imagemin');
var clean = require('gulp-clean');
var minifyhtml = require('gulp-minify-html');
//
var autoprefixer = require('gulp-autoprefixer');
var minifyCSS = require('gulp-minify-css');
var less = require('gulp-less');
var sourcemaps = require('gulp-sourcemaps');
var base64 = require('gulp-base64');
var imageminPngquant = require('imagemin-pngquant');
var imageminZopfli = require('imagemin-zopfli');
var imageminGiflossy = require('imagemin-giflossy');
var imageminGuetzli = require('imagemin-guetzli');


gulp.task('default', function () {
    console.log('Please use specific GULP-Functions');
});

gulp.task('updater_less', function () {
    return gulp.src('./updater/files/less/**/*.less')
            .pipe(concat('styles.css'))
            .pipe(sourcemaps.init())
            .pipe(less())
            .pipe(sourcemaps.write())
            .pipe(autoprefixer(["last 8 version", "> 1%", "ie 8", "ie 7"]), {cascade: true})
            .pipe(gulp.dest('./updater/files/'));
});
gulp.task('updater_js', function () {
    return gulp.src('./updater/files/js/**/*.js')
            .pipe(sourcemaps.init())
            .pipe(concat('script.js'))
            .pipe(sourcemaps.write())
            .pipe(gulp.dest('./updater/files/'));
});
gulp.task('updater_watch', function () {
    gulp.watch('./updater/files/less/**/*.less', ['updater_less']);
    gulp.watch('./updater/files/js/**/*.js', ['updater_js']);
});


