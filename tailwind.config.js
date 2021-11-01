const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    purge: [],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            spacing: {
                128: '32rem',
                256: '64rem',
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
};
