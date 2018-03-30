import Vue from 'vue';
import Vuex from 'vuex';
import auth from './sub/auth';
import schools from './sub/schools';
import profs from './sub/profs';

export default new Vuex.Store({
	state: {
		...auth.state,
		...profs.state,
		...schools.state,
	},
	getters: {
		...auth.getters,
		...profs.getters,
		...schools.getters,
	},
	mutations: {
		...auth.mutations,
		...profs.mutations,
		...schools.mutations,
	},
});