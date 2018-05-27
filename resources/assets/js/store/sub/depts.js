const depts = {
	state: {
		dept: {
			data: [],
			beingFetched: false,
		},
	},
	getters: {

	},
	mutations: {
		/**
		 * Update the status of the fetching status of the department datas
		 * @param  {Object} state The app's state
		 * @param  {Boolean} value New fetching status
		 * @return {Void}       
		 */
		updateDeptsDataFetchingStatus(state, value) {
			state.dept.beingFetched = value;
		},

		/**
		 * Update the value of the departement datas
		 * @param  {Object} state   The app's state
		 * @param  {Array} payload.data The depts's data to set
		 * @return {Void}         
		 */
		updateDeptsData(state, {data}) {
			state.dept.data = data;
			state.dept.beingFetched = false;
		},
	},
};

export default depts;