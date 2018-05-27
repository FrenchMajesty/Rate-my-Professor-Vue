const schools = {
	state: {
		school: {
			data: null,
			beingFetched: false,
		}
	},
	getters: {
		/**
		 * Filter and return only schools that have been approved
		 * @param  {Object} state.school The school branch of the app's state
		 * @return {Array}       
		 */
		approvedSchools({school}) {
			if(school.data && school.data.length > 0) {
				return school.data.filter(school => school.approved);
			}
		},
	},
	mutations: {
		/**
		 * Update the status of the fetching status of the schools' data
		 * @param  {Object} state The app's state
		 * @param  {Boolean} value New fetching status
		 * @return {Void}       
		 */
		updateSchoolsDataFetchingStatus(state, value) {
			state.school.beingFetched = value;
		},

		/**
		 * Update the value of the schools' data
		 * @param  {Object} state   The app's state
		 * @param  {Array} payload.data The schools's data to set
		 * @return {Void}         
		 */
		updateSchoolsData(state, {data}) {
			state.school.data = data;
			state.school.beingFetched = false;
		},
	},
};

export default schools;