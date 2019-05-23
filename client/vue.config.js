const path = require('path');
module.exports = {
    outputDir: '../public_html',
    publicPath: process.env.NODE_ENV === 'production'
    ? './public_html/'
    : '/',
    lintOnSave: false
}