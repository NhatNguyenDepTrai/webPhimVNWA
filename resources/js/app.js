import './bootstrap';
import '../css/app.css';
import '../css/style.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import CKEditor from '@ckeditor/ckeditor5-vue';
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import store from './store';
import axios from 'axios';
window.axios = axios;
library.add(fas)
library.add(fab)
import { LoadingPlugin } from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';









const appName = import.meta.env.VITE_APP_NAME || 'VNWA ADMIN';

createInertiaApp({
    title: (title) => `${title} - VNWA ADMIN`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(store)
            .use(CKEditor)
            .use(LoadingPlugin, {
                color: 'purple'
            })
            .component('icon', FontAwesomeIcon)
            .component('DataTable', Vue3EasyDataTable)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
