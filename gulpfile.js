var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();
var autoprefixer = require('gulp-autoprefixer');
var plumber = require('gulp-plumber');
// var imagemin = require('gulp-imagemin');
var cssmin = require('gulp-cssmin');
// var rigger = require('gulp-rigger');
// var rename = require('gulp-rename');
var jsmin = require('gulp-uglify');
var concat = require('gulp-concat');
var order = require("gulp-order");



gulp.task('online', ['sass', 'svg|png|jpg' ,'jsmin'], function () {

    browserSync.init({
        port:8080,
        open:true,
        notify:false,
        tunnel:false,
        proxy:'localhost/brilliant/'
    });

    gulp.watch('wp-content/themes/Tino/assets/scss/*.+(scss|css)', ['sass']);
    gulp.watch('wp-content/themes/Tino/assets/images/src/*.+(svg|png|jpg)', ['svg|png|jpg']);
    // gulp.watch(['build/*.html', 'build/templates/*.html'], ['html']);
    gulp.watch('wp-content/themes/Tino/assets/js/raw/*.js', ['jsmin']);
});

gulp.task('sass',function () {
    gulp.src('wp-content/themes/Tino/assets/scss/*.+(scss|css)')
        .pipe(plumber())
        .pipe(order([
            '**/*',
            'main.scss'
        ]))
        // .pipe(concat, ['main.scss'])
        .pipe(concat('main.min.css'))
        .pipe(sass({outputStyle:'compressed'}))
        .pipe(sass({errLogToConsole:true}))
        .pipe(autoprefixer({
            browsers:['last 50 versions'],
            cascade:false
        }))
        .pipe(cssmin())
        .pipe(gulp.dest('wp-content/themes/Tino/assets/css/'))
        .pipe(browserSync.reload({stream:true}));
});

gulp.task('jsmin', function () {
    gulp.src('wp-content/themes/Tino/assets/js/raw/*.js')
        .pipe(order([
            "jquery.js",
            // "bootstrap.min.js",
            '*.js'
        ]))
        .pipe(concat('script.min.js'))
        .pipe(jsmin())
        .pipe(gulp.dest('wp-content/themes/Tino/assets/js/'))
        .pipe(browserSync.reload({stream:true}));
});
// gulp.task('jsmin', function () {
//     gulp.src('build/jsmain/*.js')
//         .pipe(concat('main.min.js'))
//         .pipe(jsmin())
//         .pipe(gulp.dest('dest/js/'))
//         .pipe(browserSync.reload({stream:true}));
// });

gulp.task('svg|png|jpg', function () {
   gulp.src('wp-content/themes/navisite/assets/images/src')
       // .pipe(imagemin({progressive: true}))
       .pipe(gulp.dest('wp-content/themes/Tino/assets/images/'))
       .pipe(browserSync.reload({stream:true}));
});


// gulp.task('html',function () {
//     return gulp.src('build/*.html')
//         .pipe(rigger())
//         .pipe(gulp.dest('dest/'))
//         .pipe(browserSync.reload({stream:true}));
// });


gulp.task('default',['online']);