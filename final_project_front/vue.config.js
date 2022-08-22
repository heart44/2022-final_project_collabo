const { defineConfig } = require('@vue/cli-service')
const path = require('path');

module.exports = defineConfig({
  outputDir: path.resolve('../nodeBack/public'),
  transpileDependencies: true,
  lintOnSave: false,
  devServer : {
    proxy: {
      '/': {
        target: 'http://192.168.0.42'
      }
    }
  }
})