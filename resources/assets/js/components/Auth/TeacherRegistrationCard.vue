<template>
	<md-card md-with-hover>
		<form class="md-layout-item md-size-90" @submit.preventDefault="submitForm">
			<md-card-header>
				<h1 class="md-title">Sign up today!</h1>
				<span class="md-subhead">Be among the teachers who are leading the movement toward a more transparent and accessible education model.</span>
			</md-card-header>
			<md-field>
				<md-icon>person</md-icon>
				<label>Your first name:</label>
				<md-input
					v-model="firstname"
					placeholder="Please enter your first name here."
					maxlength="50"
				></md-input>
			</md-field>

			<md-field>
				<md-icon>person</md-icon>
				<label>Your last name:</label>
				<md-input
					v-model="lastname"
					placeholder="Please enter your last name here."
					maxlength="50"
				></md-input>
			</md-field>

			<md-field>
				<md-icon>email</md-icon>
				<label>Your Email:</label>
				<md-input
					v-model="email"
					placeholder="Please enter your email address here."
				></md-input>
			</md-field>

			<md-field>
				<md-icon>lock</md-icon>
				<label>Your password:</label>
				<md-input
					type="password"
					v-model="password"
					placeholder="Enter a password at least 6 characters long."
				></md-input>
			</md-field>

			<md-checkbox 
				v-model="terms"
			></md-checkbox>
				By clicking this box you agree to the <a href="#">Terms and Conditions of Use</a> as well as our <a href="http://google.com" target="_blank">Privacy Policy</a>.

			<md-card-actions>
			<md-button class="md-primary md-raised space-below" :disabled="!formIsComplete" type="submit">Create an Account</md-button>	
			</md-card-actions>
		</form>
	</md-card>
</template>

<script>
	export default {
		name: 'TeacherRegistrationCard',
		data() {
			return {
				firstname: '',
				lastname: '',
				email: '',
				password: '',
				terms: false,
				errors: [],
			};
		},
		computed: {
			formIsComplete() {
				return this.firstname.length > 0 &&
						this.lastname.length > 0 &&
						this.email.length > 0 &&
						this.password.length > 0 &&
						this.terms == true &&
						errors.length == 0;
			}
		},
		methods: {
			submitForm() {
				console.log('registration form for teacher was submitted ');
			}
		},
	};
</script>