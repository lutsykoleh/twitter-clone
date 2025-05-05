const gulp = require('gulp')
const sass = require('gulp-sass')(require('sass'))

// Compile SCSS to CSS
function compileSass() {
  return gulp
    .src('public/scss/**/*.scss') // Source SCSS files
    .pipe(sass().on('error', sass.logError)) // Compile SCSS to CSS
    .pipe(gulp.dest('public/css')) // Output CSS files
}

// Watch files for changes
function watchFiles() {
  gulp.watch('public/scss/**/*.scss', compileSass)
}

// Default task
const build = gulp.series(compileSass)
const watch = gulp.series(compileSass, watchFiles)

exports.build = build
exports.watch = watch
exports.default = watch
