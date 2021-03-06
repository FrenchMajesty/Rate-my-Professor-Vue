const reviews = {
	state: {
		reviews: {
			quick: '',
			type: '',
			inView: [],
			beingFetched: false,
		},
	},
	getters: {
		/**
		 * Return the value of quick written review
		 * @param  {Object} state The app's state
		 * @return {String}       
		 */
		quickReview(state) {
			return state.reviews.quick;
		},
	},
	mutations: {
		/**
		 * Update the quick review's value
		 * @param  {Object} state          The app's state
		 * @param  {String} review The quick review that was written
		 * @return {Void}                
		 */
		writeQuickReview(state, review) {
			state.reviews.quick = review;
		},

		/**
		 * Update the reviews that are currently in view on screen
		 * @param  {Object} state           The app's state
		 * @param  {Array} payload.reviews The reviews to show
		 * @param {String} payload.type The type of reviews they are
		 * @return {Void}                 
		 */
		updateTheReviewsInView(state, {reviews, type}) {
			state.reviews.inView = reviews;
			state.reviews.type = type;
			state.reviews.beingFetched = false;
		},

		/**
		 * Update the state to change the votes on a review
		 * @param  {Object} state        The app's state
		 * @param  {Array} payload.data The new feedback data to replace
		 * @param  {Number} payload.id   The ID of the review to rate
		 * @return {Void}              
		 */
		updateVotesOnProfessorReview(state, {data, id}) {
			const filteredOut = state.reviews.inView.filter(review => review.id != id);
			const review = state.reviews.inView.find(review => review.id == id);
			review.feedback = data;

			state.reviews.inView = [ ...filteredOut, review];
		},

		/**
		 * Update the status of the fetching status of the reviews
		 * @param  {Object} state The app's state
		 * @param  {Boolean} value New fetching status
		 * @return {Void}       
		 */
		updateReviewsDataFetchingStatus(state, value) {
			state.reviews.beingFetched = value;
		},
	}
};

export default reviews;