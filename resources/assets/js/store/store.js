import Vue from 'vue';
import Vuex from 'vuex';
import {user} from '../shared';

export default new Vuex.Store({
	state: {
		user,
		prof: {
			data: null,
			beingFetched: false,
		},
	},
	getters: {
		profDataIsFetching(state) {
			return state.prof.beingFetched;
		},
	},
	mutations: {
		updateProfsDataFetchingStatus(state, value) {
			state.prof.beingFetched = value;
		},
		updateProfsData(state, payload) {
			state.prof.data = payload.data;
			state.prof.beingFetched = false;
		},
	},
});