import VueRouter from 'vue-router';
import store from './store/store';

// Page components
import Index from './views/Index';
import Professor from './views/Professor';
import School from './views/School';
import Register from './views/Register';
import SignIn from './views/SignIn';
import ChangePassword from './views/Auth/ChangePassword';
import Home from './views/Home';
import RateProfessor from './views/RateProfessor';
import RateSchool from './views/RateSchool';
import NotFound from './views/NotFound';


/**
 * Protect a route to only allow autheticated users
 * @param  {Object}   to   The route the user is coming from
 * @param  {Object}   from The route the user is going to
 * @param  {Function} next The navigation hook
 * @return {Void}        
 */
const userOnly = ({name: redirect, params}, from, next) => {
	if(! store.state.user) {
		next({
			name: 'signin',
			query: { redirect, ...params },
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
	// Universal pages
	{
		path: '/',
		name: 'index',
		component: Index,
	},
	{
		path: '/prof/:slug',
		name: 'professor',
		component: Professor,
	},
	{
		path: '/school/:slug',
		name: 'school',
		component: School,
	},
	{
		path: '/not-found',
		name: 'notFound',
		component: NotFound,
	},

	// Pages for guests only
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

	// Pages for users only
	{
		path: '/home',
		name: 'home',
		component: Home,
		beforeEnter: userOnly,
	},
	{
		path: '/profile/password',
		name: 'changePassword',
		component: ChangePassword,
		beforeEnter: userOnly,
	},
	{
		path: '/rate/professor/:id/:slug',
		name: 'rateProfessor',
		component: RateProfessor,
		beforeEnter: userOnly,
	},
	{
		path: '/rate/school/:id/:slug',
		name: 'rateSchool',
		component: RateSchool,
		beforeEnter: userOnly,
	},
];

export default new VueRouter({
	routes,
});