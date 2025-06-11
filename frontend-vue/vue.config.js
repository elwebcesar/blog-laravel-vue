// const { defineConfig } = require('@vue/cli-service')
// module.exports = defineConfig({
//   transpileDependencies: true
// })


// const { defineConfig } = require('@vue/cli-service')
// module.exports = defineConfig({
//   transpileDependencies: true,
//   devServer: {
//     port: 8081, // Puerto del servidor de desarrollo
//     proxy: {
//       '/api': {
//         target: 'http://127.0.0.1:8000/api/', // URL backend
//         changeOrigin: true
//       }
//     }
//   },
//   publicPath: '/', // Ruta pública
//   outputDir: 'build', // Directorio de salida
//   assetsDir: 'static', // Directorio de assets
//   lintOnSave: true // Habilita ESLint en el guardado
// })


module.exports = {
  transpileDependencies: true,
  devServer: {
    port: 8081,
    proxy: {
      '^/api': { // Usar una expresión regular para capturar rutas que comiencen con /api
        target: 'http://127.0.0.1:8000', // Eliminar /api/ del target
        changeOrigin: true,
        pathRewrite: { '^/api': '/api' }, // Mantener /api en la URL del backend
      },
    },
  },
  publicPath: '/',
  outputDir: 'build',
  assetsDir: 'static',
  lintOnSave: true,
  configureWebpack: {
    resolve: {
      alias: {
        'vue$': 'vue/dist/vue.esm-bundler.js',
      },
    },
  },
  chainWebpack: config => {
    config.plugin('define').tap(args => {
      args[0] = {
        ...args[0],
        __VUE_OPTIONS_API__: JSON.stringify(true),
        __VUE_PROD_DEVTOOLS__: JSON.stringify(false),
        __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: JSON.stringify(false),
      };
      return args;
    });
  },
};
