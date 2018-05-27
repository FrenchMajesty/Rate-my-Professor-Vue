<template>
	<div class="md-layout md-gutter no-margin md-alignment-top-space-around">
		<md-card 
			class="md-layout-item md-xsmall-size-90 md-small-size-80 md-medium-size-50 md-size-40"
			md-with-hover
		>
			<SmartForm :submit="submit" :form="form">
				<md-card-header>
					<h1 class="md-title">Your account password</h1>
					<span class="md-subhead">You can update your account's password anytime right here .</span>
				</md-card-header>

				<md-field :class="{'md-invalid': form.errors.has('current_password')}">
					<md-icon>lock</md-icon>
					<label>Your current password:</label>
					<md-input
						type="password"
						data-name="current_password"
						v-model="form.current_password"
						placeholder="Please enter your current password here."
					></md-input>
					<span 
	      				class="md-error"
	      				v-if="form.errors.has('current_password')"
	      				v-text="form.errors.get('current_password')"
	      			></span>
				</md-field>

				<md-field :class="{'md-invalid': form.errors.has('new_password')}">
					<md-icon>lock</md-icon>
					<label>Your new password:</label>
					<md-input
						type="password"
						data-name="new_password"
						v-model="form.new_password"
						placeholder="Make sure to chose a new password that is secure."
					></md-input>
					<span 
	      				class="md-error"
	      				v-if="form.errors.has('new_password')"
	      				v-text="form.errors.get('new_password')"
	      			></span>
				</md-field>

				<md-field :class="{'md-invalid': form.errors.has('new_password')}">
					<md-icon>lock</md-icon>
					<label>Your new password:</label>
					<md-input
						type="password"
						data-name="new_password"
						v-model="form.new_password_confirmation"
						placeholder="Please confirm your new password."
					></md-input>
					<span 
	      				class="md-error"
	      				v-if="form.errors.has('new_password')"
	      				v-text="form.errors.get('new_password')"
	      			></span>
				</md-field>

	    		<md-progress-bar v-if="isSubmitting" md-mode="query"></md-progress-bar>
				<md-card-actions>
				<md-button
					type="submit"
					class="md-primary" 
					:disabled="form.errors.any() || isSubmitting" 
				>
					Change my Password
				</md-button>
				</md-card-actions>
			</SmartForm>
		</md-card>
	</div>
</template>

<script>
	import Form from 'Js/lib/Form';
	import SmartForm from 'Js/components/common/SmartForm';
	import { changePassword } from 'Js/store/api';

	export default {
		name: 'ForgotPassword',
		components: {
			SmartForm,
		},
		data() {
			return {
				/**
				 * The form object to change the password
				 * @type {Form}
				 */
				form: new Form({
					current_password: '',
					new_password: '',
					new_password_confirmation: '',
				}),

				/**
				 * The current AJAX status of the form submit
				 * @type {Boolean}
				 */
				isSubmitting: false,
			};
		},
		methods: {	
			/**
			 * Submit the form and show a success message
			 * @return {Void} 
			 */
			submit() {
				this.isSubmitting = true;

				this.form.submit(changePassword).then(() => {
					this.isSubmitting = false;
					alert('Your password was successfully updated!');
					this.$router.push({name: 'home'});
				})
				.catch(err => {
					console.log(err);
					this.isSubmitting = false;
				});
			}
		},
	}
</script>