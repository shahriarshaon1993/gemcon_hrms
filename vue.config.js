import { BundleAnalyzerPlugin } from 'webpack-bundle-analyzer';
module.exports = {
    css: {
        extract: true,  // Extract CSS into separate files
    },
    chainWebpack: config => {
        config.plugins.delete('prefetch');
        config.module
        .rule('images')
        .test(/\.(png|jpe?g|gif|svg)(\?.*)?$/)
        .use('url-loader')
        .loader('url-loader')
        .options({
        limit: 8192,  // Files smaller than 8KB will be base64 encoded
        name: 'assets/images/[name].[hash:8].[ext]',
        });
    },
    plugins: [new BundleAnalyzerPlugin()],
    optimization: {
        minimize: true,
        minimizer: [
            new TerserPlugin({
                terserOptions: {
                    compress: {
                        drop_console: true, // Remove console logs in production
                    },
                },
            }),
        ],
    },
    splitChunks: {
        chunks: 'all', // Split all chunks (default is `async`)
    },
};
// export function chainWebpack(config) {
//     config.plugins.delete('prefetch');
//     config.module
//         .rule('images')
//         .test(/\.(png|jpe?g|gif|svg)(\?.*)?$/)
//         .use('url-loader')
//         .loader('url-loader')
//         .options({
//             limit: 8192, // Files smaller than 8KB will be inlined as base64
//             name: 'assets/images/[name].[hash:8].[ext]'
//         });
// }
// export const configureWebpack = {
//     plugins: [new BundleAnalyzerPlugin()],
//     optimization: {
//         minimize: true,
//         minimizer: [
//             new TerserPlugin({
//                 terserOptions: {
//                     compress: {
//                         drop_console: true, // Remove console logs in production
//                     },
//                 },
//             }),
//         ],
//     },
//     splitChunks: {
//         chunks: 'all', // Split all chunks (default is `async`)
//     },
// };