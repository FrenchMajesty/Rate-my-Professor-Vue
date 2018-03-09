import VueRouter from 'vue-router';
import Index from './views/Index';
import Professor from './views/Professor';
import Register from './views/Register';

const routes = [
	{
		path: '/',
		name: 'index',
		component: Index,
	},
	{
		path: '/prof',
		name: 'professor',
		component: Professor,
	},
	{
		path: '/signup',
		name: 'register',
		component: Register,
	},
];

export default new VueRouter({
	routes,
});