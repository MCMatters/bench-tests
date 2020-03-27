const path = require('path');
const webpack = require('webpack');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

const publicAssetsPath = path.resolve(__dirname, './public/assets');

module.exports = (context, argv) => {
  const devMode = argv.mode === 'development';

  process.env.NODE_ENV = devMode ? 'development' : 'production';

  const config = {
    stats: 'none',
    context: path.resolve(__dirname, './resources/assets/'),
    entry: {
      'app': [
        './js/app.js',
        '../../node_modules/bootstrap/dist/css/bootstrap.min.css'
      ],
    },
    output: {
      path: publicAssetsPath,
      filename: 'js/[name].js',
    },
    module: {
      rules: [
        {
          test: /\.vue$/,
          loader: 'vue-loader',
          options: {
            loaders: {
              js: {
                loader: 'babel-loader',
                options: {
                  cacheDirectory: true,
                },
              },
            },
          },
        },
        {
          test: /\.js$/,
          loader: 'babel-loader',
          exclude: /node_modules/,
          options: {
            cacheDirectory: true,
          },
        },
        {
          test: /\.(sa|sc|c)ss$/,
          use: [
            {
              loader: MiniCssExtractPlugin.loader,
              options: {
                processUrls: false,
              },
            },
            {
              loader: 'css-loader',
              options: {
                url: false,
              },
            },
          ],
        },
      ],
    },
    resolve: {
      alias: {
        'vue$': 'vue/dist/vue.esm.js',
      },
      extensions: ['.js', '.vue', '.json', '.css'],
    },
    plugins: [
      new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: ['public/assets'],
      }),
      new MiniCssExtractPlugin({
        filename: 'css/[name].css',
      }),
      new VueLoaderPlugin(),
    ],
  };

  if (!devMode) {
    config.plugins = config.plugins.concat([
      new webpack.LoaderOptionsPlugin({
        minimize: true,
      }),
    ]);
  }

  return config;
};
