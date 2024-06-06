const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true
})

module.exports = {
  devServer: {
    proxy: {
      '^/api': {
        target: 'http://localhost/PruebaTecnica/public',
        changeOrigin: true,
        pathRewrite: { '^/api': '' },
      },
    },
  },
};