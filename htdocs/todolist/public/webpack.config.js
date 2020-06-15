const path = require('path')
const webpack = require('webpack')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

// Modules configuration
module.exports = {
    entry: './src/main.js',
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'main.js',
        chunkFilename: 'vendor.js'
    },

    module: {
        rules: [
            // Babel to convert ES6 script to ES5 script (retro compatibility)
            {
                test: /\.js$/,
                exclude: '/node_modules',
                use: {
                    loader: 'babel-loader'
                }
            },
            // Gestion des css et scss
            {
                test: /\.sc|ass$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader
                    },
                    {
                        loader: 'css-loader'
                    },
                    {
                        loader: 'sass-loader'
                    }
                ]
            }
        ]
    },
    // Plugin management
    plugins: [
        new MiniCssExtractPlugin({
            filename: './assets/css/[name].css',
            chunkFilename: './assets/css/[id].css'
        })
    ]
}