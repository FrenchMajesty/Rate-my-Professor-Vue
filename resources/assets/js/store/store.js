import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersist from 'vuex-persist';
import auth from './sub/auth';
import schools from './sub/schools';
import profs from './sub/profs';
import depts from './sub/depts';
import reviews from './sub/reviews';
import tags from './sub/tags';

const vuexLocalStorage = new VuexPersist({
	key: 'vuex', 
	storage: window.localStorage,
	reducer: ({user, auth}) => ({ user, auth }),
	filter: (mutation) => (mutation.type == 'updateUser' || mutation.type == 'updateAccessToken'),
})

export default new Vuex.Store({
	state: {
		...auth.state,
		...profs.state,
		...schools.state,
		...depts.state,
		...reviews.state,
		...tags.state,
	},
	getters: {
		...auth.getters,
		...profs.getters,
		...schools.getters,
		...depts.getters,
		...reviews.getters,
		...tags.getters,
	},
	mutations: {
		...auth.mutations,
		...profs.mutations,
		...schools.mutations,
		...depts.mutations,
		...reviews.mutations,
		...tags.mutations,
	},
	plugins: [vuexLocalStorage.plugin],
});