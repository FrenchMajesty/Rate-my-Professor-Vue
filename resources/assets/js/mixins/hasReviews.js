export default {
	/**
	 * When navigating to a different entry of the same profile type
	 * @param  {Route}   to   The route navigated to
	 * @param  {Route}   from The originating route
	 * @param  {Function} next The hook to resolve
	 * @return {Void}        
	 */
	beforeRouteUpdate(to, from, next) {
		this.clearReviews();
		next();
	},

	/**
	 * When navigating to a different page
	 * @param  {Route}   to   The route navigated to
	 * @param  {Route}   from The originating route
	 * @param  {Function} next The hook to resolve
	 * @return {Void}        
	 */
	beforeRouteLeave(to, from, next) {
		this.clearReviews();
		next();
	},
	methods: {
		/**
		 * Reset the `inView` reviews in the store
		 * @return {Void} 
		 */
		clearReviews() {
			this.$store.commit({
				type: 'updateTheReviewsInView',
				data: [],
			})
		},
	},
}