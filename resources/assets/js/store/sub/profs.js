const profs = {
	state: {
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
		/**
		 * Update the status of the fetching status of the professors' data
		 * @param  {Object} state The app's state
		 * @param  {Boolean} value New fetching status
		 * @return {Void}       
		 */
		updateProfsDataFetchingStatus(state, value) {
			state.prof.beingFetched = value;
		},

		/**
		 * Update the value of the professors' data
		 * @param  {Object} state   The app's state
		 * @param  {Array} payload.data The professors's data to set
		 * @return {Void}         
		 */
		updateProfsData(state, {data}) {
			state.prof.data = data;
			state.prof.beingFetched = false;
		},
	},
};

export default profs;