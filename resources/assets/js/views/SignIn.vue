<template>
	<div class="md-layout md-gutter no-margin md-alignment-top-space-around">
		<md-card 
			class="md-layout-item md-xsmall-size-90 md-small-size-80 md-medium-size-50 md-size-40"
			md-with-hover
		>
			<SmartForm :submit="submitForm" :form="form">
				<md-card-header>
					<h1 class="md-title">Sign In</h1>
					<span class="md-subhead">Don't have an account yet? No worries you can <router-link :to="{name: 'signup', query: $route.query}">sign up here</router-link> for free.</span>
				</md-card-header>

				<md-field :class="{'md-invalid': form.errors.has('email')}">
					<md-icon>email</md-icon>
					<label>Your Email:</label>
					<md-input
						data-name="email"
						v-model="form.email"
						placeholder="Please enter your email address here."
					></md-input>
					<span 
	      				class="md-error"
	      				v-if="form.errors.has('email')"
	      				v-text="form.errors.get('email')"
	      			></span>
				</md-field>

				<md-field 
					:class="{'md-invalid': form.errors.has('password')}"
				>
					<md-icon>lock</md-icon>
					<label>Your password:</label>
					<md-input
						data-name="password"
						type="password"
						v-model="form.password"
						placeholder="Enter your account's password here."
					></md-input>
	      			<span 
	      				class="md-error"
	      				v-if="form.errors.has('password')"
	      				v-text="form.errors.get('password')"
	      			></span>
				</md-field>
				<md-checkbox 
					data-name="remember"
					v-model="form.remember"
					@change="form.errors.clear('remember')"
				>
					Remember me so I don't have to login on this computer again.
				</md-checkbox>
				<span 
	  				:class="{'error': form.errors.has('remember')}"
	  				v-if="form.errors.has('remember')"
	  				v-text="form.errors.get('remember')"
	  			></span>

	    			<md-progress-bar v-if="isSubmitting" md-mode="query"></md-progress-bar>
				<md-card-actions>
				<md-button class="md-primary" :disabled="form.errors.any()" type="submit">Login</md-button>
				</md-card-actions>
			</SmartForm>
		</md-card>
	</div>
</template>

<script>
	import Form from 'Js/lib/Form';
	import SmartForm from 'Js/components/common/SmartForm';
	import { submitLogin, loadUserData } from 'Js/store/api';

	export default {
		name: 'SignIn',
		components: {
			SmartForm,
		},
		data() {
			return {
				/**
				 * The form object for the login form
				 * @type {Form}
				 */
				form: new Form({
					email: '',
					password: '',
					remember: false,
				}),

				/**
				 * The AJAX submit status of the form
				 * @type {Boolean}
				 */
				isSubmitting: false,
			};
		},
		methods: {
			/**
			 * Handle the submitting of the form
			 * @return {Void} 
			 */
			submitForm() {
				this.isSubmitting = true;

				this.form.submit(submitLogin)
				.then(this.updateStateWithUserData)
				.catch(_ => this.isSubmitting = false);
			},

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
</script>