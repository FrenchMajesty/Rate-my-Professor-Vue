import VueRouter from 'vue-router';
import Index from './views/Index';
import Professor from './views/Professor';

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
];

export default new VueRouter({
	routes,
});