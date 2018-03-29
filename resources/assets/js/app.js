import './bootstrap';
import router from './routes';
import store from './store/store';
import AppWrapper from './AppWrapper';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	router,
	store,
    render: (h) => h(AppWrapper) 
}).$mount('#app');
