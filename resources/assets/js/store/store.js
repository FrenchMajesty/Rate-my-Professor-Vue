import Vue from 'vue';
import Vuex from 'vuex';
import {user} from '../shared';
import schools from './sub/schools';
import profs from './sub/profs';

export default new Vuex.Store({
	state: {
		user,
		...profs.state,
		...schools.state,
	},
	getters: {
		...profs.getters,
		...schools.getters,
	},
	mutations: {
		...profs.mutations,
		...schools.mutations,
	},
});