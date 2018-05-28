const profs = {
	state: {
		prof: {
			data: [],
			beingFetched: false,
		},
	},
	getters: {
		profDataIsFetching(state) {
			return state.prof.beingFetched;
		},

		/**
		 * Filter the professors that have been approved
		 * @param  {Object} state The store's state
		 * @return {Array}       
		 */
		approvedProfs(state) {
			return state.prof.data.filter(prof => prof.approved);
		},

		/**
		 * Determine whether professors and all aggregate data is ready for use
		 * @param  {Object} state The store's state
		 * @return {Boolean}       
		 */
		profDataIsReady(state) {
			return !(state.prof.beingFetched || state.school.beingFetched || state.dept.beingFetched);
		},

		/**
		 * Return a function to find the full entry of a professor
		 * @param  {Object} state The store's state
		 * @param  {Object} getters The store's getters
		 * @return {Function}       
		 */
		fullProfessor(state, getters) {
			return (profId) => {
				const prof = getters.approvedProfs.find(({id}) => id == profId);

				if(prof) {
					prof.school = getters.approvedSchools.find(({id}) => id == prof.school_id);
					prof.department = state.dept.data.find(({id}) => id == prof.department_id);
				}

				return prof ? prof : null;
			};
		},

		/**
		 * Find a professor with the slug
		 * @param  {Object} state   The store's state
		 * @param  {Object} getters The store's getters
		 * @return {Function}         
		 */
		fullProfessorWithSlug(state, getters) {
			return (slug) => {
				const prof = getters.approvedProfs.find((prof) => prof.slug == slug);
				return prof ? getters.fullProfessor(prof.id) : null;
			}
		}
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