import './bootstrap';

import {createApp} from 'vue/dist/vue.esm-bundler'
import Apps from './App.vue'
import svgIcons from './Helpers/globalSvgIcons.vue';
import ViewUIPlus from 'view-ui-plus'
import locale from 'view-ui-plus/dist/locale/en-US';
import router from "./router";
import store from "./store";
import 'view-ui-plus/dist/styles/viewuiplus.css'
import apiService from './Helpers/apiService';
import globals from './Helpers/globals';
const app = createApp({})
app.use(store);
app.use(router);
app.use(ViewUIPlus, { locale });
app.mixin(apiService);
app.mixin(globals);
app.component('main-content', Apps);
app.component('svg-icon', svgIcons);
app.mount('#app');
