const Encore = require('@symfony/webpack-encore');

Encore.setOutputPath('public/build/') // project directory
  .setPublicPath('/build') // public path
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction()) // hashed filenames

  .enableSassLoader()
  .enableVueLoader(options => {
    options.loaders = {
      // js: ,
      // js:
    };
    options.postcss = [require('postcss-cssnext')()];
  })

  .addEntry('js/main', './assets/js/main.js');
// .addStyleEntry('css/app', './assets/css/app.css')

// uncomment for legacy applications that require $/jQuery as a global variable
// .autoProvidejQuery()

module.exports = Encore.getWebpackConfig();
