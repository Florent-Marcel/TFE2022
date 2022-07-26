import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUser, faCouch, faCircleXmark, faFilePdf } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import VueMultiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import moment from 'moment';
import 'moment/dist/locale/fr';
import 'moment/dist/locale/en-gb';
import globalMixin from './base'
import { usePage } from '@inertiajs/inertia-vue3'

library.add(faUser, faCouch, faCircleXmark, faFilePdf)

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        const myApp = createApp({ render: () => h(app, props) })
            .mixin({ methods: { route } })
            .mixin(globalMixin)
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(moment)
            .component('font-awesome-icon', FontAwesomeIcon)
            .component('VueMultiselect', VueMultiselect);

        myApp.config.globalProperties.$dateToLittleString = (date) =>{
            let locale = usePage().props.value.locale
            moment.locale(locale);
            return moment(date).format('L');
        };

        myApp.config.globalProperties.$dateToHourString = (date) =>{
            let locale = usePage().props.value.locale
            moment.locale(locale);
            return moment(date).format('LT');
        };

        myApp.config.globalProperties.$minutesToString = (minutes) => {
            let nbHours = Math.floor(minutes /60);
            let nbMinutes = minutes % 60;
            return `${nbHours}h${nbMinutes}`;
        };

        myApp.config.globalProperties.$dateToString = (date) =>{
            let locale = usePage().props.value.locale
            moment.locale(locale);
            return moment(date).format('LL');
        },

        myApp.config.globalProperties.$doubleToString = (num) => {
            num = parseFloat(num);
            return Math.round((num + Number.EPSILON) * 100) / 100
        },

        myApp.config.globalProperties.$secondsToMinutesString = (seconds) => {
            let nbMinutes = Math.floor(seconds /60);
            let nbSeconds = seconds % 60;
            return `${nbMinutes}m${nbSeconds}s`;
        },

        myApp.config.globalProperties.$t = (key) => {
            let locale = usePage().props.value.locale
            return `${key}_${locale}`;
        },

        myApp.config.globalProperties.$route = route

        myApp.mount(el);
        return myApp;
    },
    provide: {
        globalVariable: 123,
    },
});

InertiaProgress.init({ color: '#4B5563' });


