<template>
	<md-card md-with-hover>
		<SmartForm class="md-layout-item md-size-90" :submit="submitForm" :form="form">
			<md-card-header>
				<h1 class="md-title">Sign up today!</h1>
				<span class="md-subhead">Be among the teachers who are leading the movement toward a more transparent and accessible education model.</span>
			</md-card-header>

			<md-field :class="{'md-invalid': form.errors.has('firstname')}">
				<md-icon>person</md-icon>
				<label>Your first name:</label>
				<md-input
					data-name="firstname"
					v-model="form.firstname"
					placeholder="Please enter your first name here."
					maxlength="50"
				></md-input>
				<span 
      				class="md-error"
      				v-if="form.errors.has('firstname')"
      				v-text="form.errors.get('firstname')"
      			></span>
			</md-field>

			<md-field :class="{'md-invalid': form.errors.has('lastname')}">
				<md-icon>person</md-icon>
				<label>Your last name:</label>
				<md-input
					data-name="lastname"
					v-model="form.lastname"
					placeholder="Please enter your last name here."
					maxlength="50"
				></md-input>
				<span 
      				class="md-error"
      				v-if="form.errors.has('lastname')"
      				v-text="form.errors.get('lastname')"
      			></span>
			</md-field>

			<md-field :class="{'md-invalid': form.errors.has('email')}">
				<md-icon>email</md-icon>
				<label>Your email:</label>
				<md-input
					data-name="email"
					v-model="form.email"
					placeholder="Please enter your school email address here."
				></md-input>
				<span 
      				class="md-error"
      				v-if="form.errors.has('email')"
      				v-text="form.errors.get('email')"
      			></span>
			</md-field>

			<md-field :class="{'md-invalid': form.errors.has('password')}">
				<md-icon>lock</md-icon>
				<label>Your password:</label>
				<md-input
					data-name="password"
					type="password"
					v-model="form.password"
					placeholder="Enter a password at least 6 characters long."
				></md-input>
      			<span 
      				class="md-error"
      				v-if="form.errors.has('password')"
      				v-text="form.errors.get('password')"
      			></span>
			</md-field>

			<md-checkbox 
				data-name="terms"
				v-model="form.terms"
				@change="form.errors.clear('terms')"
			>
				By clicking this box you agree to the <a href="#">Terms and Conditions of Use</a> as well as our <a href="#">Privacy Policy</a>.
			</md-checkbox>
			<span 
  				:class="{'error': form.errors.has('terms')}"
  				v-if="form.errors.has('terms')"
  				v-text="form.errors.get('terms')"
  			></span>

			<md-card-actions>
			<md-button class="md-primary md-raised space-below" :disabled="form.errors.any()" type="submit">Create an Account</md-button>	
			</md-card-actions>
		</SmartForm>
	</md-card>
</template>

<script>
	import Form from 'Js/lib/Form';
	import Fetcher from 'Js/lib/Fetcher';
	import SmartForm from 'Js/components/common/SmartForm';
	import userData from 'Js/mixins/userData';
	import { submitProfRegistration, submitLogin } from 'Js/store/api';

	export default {
		name: 'TeacherRegistrationCard',
		mixins: [userData],
		components: {
			SmartForm,
		},
		data() {
			return {
				/**
				 * The form object for registration
				 * @type {Form}
				 */
				form: new Form({
					firstname: '',
					lastname: '',
					email: '',
					password: '',
					terms: false,
				}),
			};
		},
		methods: {
			/**
			 * Handle the submitting the form
			 * @return {Void} 
			 */
			submitForm() {
				const {query} = this.$route;
				const target = query.redirect ? query.redirect : 'index';
				const params = { ...query };
				delete params.redirect;

				this.form.submit(submitProfRegistration).then(() => {
					this.$router.push({name: target, params});

					const {email, password} = this.form;
					submitLogin({email, password}).then(this.updateStateWithUserData);
				});
			},
		},
	};
</script>

<style scoped>
	.error {
		color: #ff1744;
	}
</style>