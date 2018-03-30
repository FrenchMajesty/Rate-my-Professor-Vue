import VueRouter from 'vue-router';
import Index from './views/Index';
import Professor from './views/Professor';
import Register from './views/Register';
import SignIn from './views/SignIn';
import Home from './views/Home';
import store from './store/store';

/**
 * Protect a route to only allow autheticated users
 * @param  {Object}   to   The route the user is coming from
 * @param  {Object}   from The route the user is going to
 * @param  {Function} next The navigation hook
 * @return {Void}        
 */
const userOnly = (to, from, next) => {
	if(! store.state.user) {
		next({
			name: 'signin',
			query: {redirect: to.name}
		});
	}

	next();
};

/**
 * Protect a route to only allow users that are NOT authenticated
 * @param  {Object}   to   The route the user is coming from
 * @param  {Object}   from The route the user is going to
 * @param  {Function} next The navigation hook
 * @return {Void}        
 */
const guestOnly = (to, from, next) => {
	if(store.state.user) {
		next(false);
	}

	next();
};

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
		name: 'signup',
		component: Register,
		beforeEnter: guestOnly,
	},
	{
		path: '/signin',
		name: 'signin',
		component: SignIn,
		beforeEnter: guestOnly,
	},
	{
		path: '/home',
		name: 'home',
		component: Home,
		beforeEnter: userOnly,
	}
];

export default new VueRouter({
	routes,
});