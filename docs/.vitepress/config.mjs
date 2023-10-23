import { defineConfig } from 'vitepress'

let year = new Date().getFullYear();

const title = 'PlanCraft'
const description = 'Elevate Your Plans Management with PlanCraft for Laravel. Transforming Laravel Plans Management. Break free from conventional database storage constraints.'
const url = 'https://realrashid.github.io/plan-craft/'
const image = `https://api.placid.app/u/2wagk?hl=PlanCraft&img=https%3A%2F%2Frealrashid.github.io%2Fplan-craft%2F&subline=Transforming%20Laravel%20Plans%20Management.%20Break%20free%20from%20conventional%20database%20storage%20constraints.`
const twitter = 'rashidali05'
const github = 'https://github.com/realrashid/plan-craft'
const linkedin = 'https://linkedin.com/in/realrashid'

export default defineConfig({
    lang: 'en-US',
    title,
    description,
    base: '/plan-craft/',
    ignoreDeadLinks: true,
    lastUpdated: true,
    cleanUrls: true,
    appearance: 'dark',
    markdown: {
        defaultHighlightLang: 'php',
        theme: {
            dark: 'material-theme-palenight',
            light: 'github-light',
        },
    },

    head: [
        ['link', { rel: 'icon', type: 'image/svg+xml', href: '/logo.svg' }],
		['meta', { property: 'og:type', content: 'website' }],
		['meta', { property: 'og:title', content: title }],
		['meta', { property: 'og:image', content: image }],
		['meta', { property: 'og:url', content: url }],
		['meta', { property: 'og:description', content: description }],
		['meta', { name: 'twitter:card', content: 'summary_large_image' }],
		['meta', { name: 'twitter:image', content: image }],
		['meta', { name: 'twitter:site', content: `@${twitter}` }],
		['meta', { name: 'twitter:title', content: title }],
		['meta', { name: 'twitter:description', content: description }],
		['meta', { name: 'theme-color', content: '#1e3a8a' }],
        [
            'script',
            { async: '', src: 'https://www.googletagmanager.com/gtag/js?id=G-NX57383V8Y' }
        ],
        [
            'script',
            {},
            `window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-NX57383V8Y');`
        ]

    ],

    themeConfig: {

        logo: { src: '/logo-mini.svg', width: 24, height: 24 },

        nav: [
            { text: 'Get Started', link: '/guide/introduction' },
            { text: 'Installation', link: '/guide/installation' },
            { text: 'Demo App', link: '/demo/demo' },
        ],

        sidebar: [
            {
                text: 'Guide',
                collapsed: false,
                items: [
                    { text: 'Introduction', link: '/guide/introduction' },
                    { text: 'Installation', link: '/guide/installation' },
                    { text: 'Define Plans', link: '/guide/define-plans' },
                ]
            },
            {
                text: 'Usage',
                collapsed: false,
                items: [
                    { text: 'Assign Plan to Model', link: '/usage/usage' },
                    { text: 'Create Plan', link: '/usage/create' },
                    { text: 'Switch Plan', link: '/usage/switch-plan' },
                    { text: 'Current Plan', link: '/usage/current-plan' },
                    { text: 'Has Plan', link: '/usage/has-plan' },
                    { text: 'Has Active Plan', link: '/usage/has-active-plan' },
                    { text: 'Can Access Feature', link: '/usage/can-access-feature' },
                    { text: 'Check Eligibility', link: '/usage/check-eligibility' },
                    { text: 'Delete Plan', link: '/usage/delete-plan' },
                ]
            },
            {
                text: 'Example',
                collapsed: false,
                items: [
                    { text: 'Show Plans', link: '/example/show-plans' },
                    { text: 'Subscribe To Plan', link: '/example/subscribe' },
                    { text: 'Switch Plan', link: '/example/switch-plan' },
                    { text: 'Cancel Subscription', link: '/example/cancel-subscription' },
                    { text: 'Middleware', link: '/example/middleware' },
                ]
            },
            {
                text: 'Demo App',
                collapsed: false,
                items: [
                    { text: 'Demo App', link: '/demo/demo' },
                    { text: 'Get Started', link: '/demo/get-started' },
                ]
            },
        ],

        editLink: {
            pattern: `${github}/edit/main/docs/:path`,
            text: 'Suggest changes to this page',
        },

        socialLinks: [
			{ icon: 'twitter', link: `https://twitter.com/${twitter}` },
			{ icon: 'linkedin', link: `${linkedin}` },
			{ icon: 'github', link: `${github}` },
		],

        footer: {
            message: '<p align="center"> <b>Made with ❤️ from Pakistan</b> </p> Released under the <a href="https://github.com/realrashid/plan-craft/blob/main/LICENSE">MIT License</a>.',
            copyright: `Copyright © ${year} <a href="https://github.com/realrashid">Rashid Ali</a>`
        },

        search: {
            provider: 'local'
        },
    }
})
