require('./bootstrap');

import Vue from 'vue';
import axios from 'axios';
import storeData from './store';
import Vuex from 'vuex';

import Todos from './components/Todos';

Vue.component('todos', Todos);

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

Object.defineProperty(Vue.prototype, '$http', {
    get() {
        return axios;
    }
});

Vue.use(Vuex);

let store = new Vuex.Store(storeData);

const app = new Vue({
    el: '#app',
    store
});
