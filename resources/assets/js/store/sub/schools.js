const schools = {
	state: {
		school: {
			data: [],
			beingFetched: false,
		}
	},
	getters: {
		/**
		 * Determine whether schools and all aggregate data is ready for use
		 * @param  {Object} state The store's state
		 * @return {Boolean}       
		 */
		schoolDataIsReady(state) {
			return !(state.school.beingFetched || state.dept.beingFetched);
		},

		/**
		 * Filter and return only schools that have been approved
		 * @param  {Object} state.school The school branch of the app's state
		 * @return {Array}       
		 */
		approvedSchools({school}) {
			return school.data.filter(school => school.approved);
		},

		/**
		 * Return a function to find the full entry of a school
		 * @param  {Object} state The store's state
		 * @param  {Object} getters The store's getters
		 * @return {Function}       
		 */
		fullSchool(state, getters) {
			return (schoolId) => {
				const school = getters.approvedSchools.find(({id}) => id == schoolId);
				return school;
			};
		},

		/**
		 * Find a school entry with the slug
		 * @param  {Object} state   The store's state
		 * @param  {Object} getters The store's getters
		 * @return {Function}         
		 */
		fullSchoolWithSlug(state, getters) {
			return (slug) => {
				const school = getters.approvedSchools.find(school => school.slug == slug);
				return school ? getters.fullSchool(school.id) : null;
			};
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