const tags = {
	state: {
		data: [],
		beingFetched: false,
	},
	getters: {

	},
	mutations: {
		/**
		 * Update the status of the fetching status of the tags data
		 * @param  {Object} state The app's state
		 * @param  {Boolean} value New fetching status
		 * @return {Void}       
		 */
		updateTagsDataFetchingStatus(state, value) {
			state.school.beingFetched = value;
		},

		/**
		 * Update the value of the tags used to review
		 * @param  {Object} state   The app's state
		 * @param  {Array} payload.data The schools's data to set
		 * @return {Void}         
		 */
		updateTagsData(state, {data}) {
			state.school.data = data;
			state.school.beingFetched = false;
		},
	},
};

export default tags;