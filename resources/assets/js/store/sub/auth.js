const auth = {
	state: {
		user: null,
		auth: {
			accessToken: null,
			expire: null,
		},
	},
	getters: {

	},
	mutations: {
		/**
		 * Update the access token in the state
		 * @param  {Object} state          The app's state
		 * @param  {String} payload.token  The new access token
		 * @param  {Number} payload.expire The time until it expires in seconds
		 * @return {Void}                
		 */
		updateAccessToken(state, {token, expire}) {
			state.auth.accessToken = token;
			state.auth.expire = expire ? (Date.now() + expire * 1000) : null;
		},

		/**
		 * Update the user model in the state if existing or set it
		 * @param  {Object} state        The app's state
		 * @param  {Object} payload.user The new user model
		 * @return {Void}              
		 */
		updateUser(state, {user}) {
			state.user = state.user ? { ...state.user, ...user } : user;
		},
	},
};

export default auth;