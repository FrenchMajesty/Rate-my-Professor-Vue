import { loadUserData } from 'Js/store/api';

export default {
	methods: {
		/**
		 * Update the app's state with the user's model and access token
		 * @param  {Object} response.data The token object
		 * @return {Void}              
		 */
		updateStateWithUserData({data}) {
			const {query} = this.$route;

			this.$store.commit({
				type: 'updateAccessToken',
				token: data.access_token,
				expire: data.expires_in,
			});

			loadUserData().then(({data: user}) => {
				this.isSubmitting = false;
				this.$store.commit({
					type: 'updateUser',
					user,
				});

				// Figure out what page to go to next
				const target = query.redirect ? query.redirect : 'index';
				const params = { ...query };
				delete params.redirect;

				this.$router.push({name: target, params});
			})
			.catch(err => {
				console.log(err);
				this.isSubmitting = false;
			});
		},
	},
}