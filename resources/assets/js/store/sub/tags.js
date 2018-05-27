const tags = {
	state: {
		tags: {
			data: [],
			beingFetched: false,
		},
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
			state.tags.beingFetched = value;
		},

		/**
		 * Update the value of the tags used to review
		 * @param  {Object} state   The app's state
		 * @param  {Array} payload.data The review tags to set
		 * @return {Void}         
		 */
		updateTagsData(state, {data}) {
			state.tags.data = data;
			state.tags.beingFetched = false;
		},
	},
};

export default tags;