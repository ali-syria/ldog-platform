const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
        },
        aspectRatio: { // defaults to {}
            'none': 0,
            'square': [1, 1], // or 1 / 1, or simply 1
            '16/9': [16, 9],  // or 16 / 9
            '4/3': [4, 3],    // or 4 / 3
            '21/9': [21, 9],  // or 21 / 9
        }
    },
    variants: {},
    purge: {
        content: [
            './app/**/*.php',
            './resources/**/*.html',
            './resources/**/*.js',
            './resources/**/*.jsx',
            './resources/**/*.ts',
            './resources/**/*.tsx',
            './resources/**/*.php',
            './resources/**/*.vue',
            './resources/**/*.twig',
        ],
        options: {
            defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
            whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /show$/],
        },
    },
    plugins: [
        require('@tailwindcss/ui'),
        require('@tailwindcss/typography'),
        require("tailwindcss-responsive-embed"),
        require("tailwindcss-aspect-ratio")
    ],
};
