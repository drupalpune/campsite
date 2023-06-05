var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var cssnano = require('gulp-cssnano');
var rename = require('gulp-rename');
const sass = require('gulp-sass')(require('sass'));

gulp.task('sass', function() {
  return gulp.src('scss/style.scss')
    .pipe(sass())
    .pipe(autoprefixer())
    .pipe(cssnano())
    .pipe(rename('style.css'))
    .pipe(gulp.dest('css/'));
});

gulp.task('watch',  function() {
  gulp.watch('scss/**/*.scss', gulp.series('sass'));
});

gulp.task('default', gulp.series('sass', 'watch'));