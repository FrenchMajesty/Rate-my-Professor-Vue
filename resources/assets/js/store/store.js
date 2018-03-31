import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersist from 'vuex-persist';
import auth from './sub/auth';
import schools from './sub/schools';
import profs from './sub/profs';
import reviews from './sub/reviews';

const vuexLocalStorage = new VuexPersist({
	key: 'vuex', 
	storage: window.localStorage,
	reducer: (state) => ({
		user: state.user,
		auth: state.auth,
	}),
	filter: (mutation) => (mutation.type == 'updateUser' || mutation.type == 'updateAccessToken'),
})

export default new Vuex.Store({
	state: {
		...auth.state,
		...profs.state,
		...schools.state,
		...reviews.state,
	},
	getters: {
		...auth.getters,
		...profs.getters,
		...schools.getters,
		...reviews.getters,
	},
	mutations: {
		...auth.mutations,
		...profs.mutations,
		...schools.mutations,
		...reviews.mutations,
	},
	plugins: [vuexLocalStorage.plugin],
});