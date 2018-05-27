<template>
	<div class="md-layout md-gutter no-margin md-alignment-top-space-around">
		<md-card 
			class="md-layout-item md-xsmall-size-90 md-small-size-80 md-medium-size-50 md-size-40"
			v-if="canShowSchoolInput"
			md-with-hover
		>
			<SmartForm :submit="submitForm" :form="form">
				<md-card-header>
					<h1 class="md-title">Your account</h1>
					<span class="md-subhead">You can update your account's personal information right here.</span>
				</md-card-header>

				<md-field :class="{'md-invalid': form.errors.has('firstname')}">
					<md-icon>person</md-icon>
					<label>Your first name:</label>
					<md-input
						data-name="firstname"
						v-model="form.firstname"
						placeholder="Please enter your firstname here."
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
						placeholder="Please enter your lastname here."
					></md-input>
					<span 
	      				class="md-error"
	      				v-if="form.errors.has('lastname')"
	      				v-text="form.errors.get('lastname')"
	      			></span>
				</md-field>

				<transition
		  			name="search"
		  			mode="out-in"
		  			enter-active-class="animated zoomIn"
		  			leave-active-class="animated zoomOut"
		  		>
	        		<md-autocomplete 
	        			v-if="searchIsReady" 
	        			v-model="form.school" 
	        			:md-options="schools"
	        			:md-open-on-focus="false"
	        			md-input-placeholder="Enter your school's name (optional)"
	        			md-dense
	        		>
					    <label>I'm a student at</label>
					     <template slot="md-autocomplete-item" slot-scope="{ item, term }">
					        <md-highlight-text :md-term="term">{{item.name}} ({{item.nickname}})</md-highlight-text>
					     </template>
				      	<template slot="md-autocomplete-empty" slot-scope="{ term }">
				        	No schools matching "{{term}}" were found.
				      	</template>
				    </md-autocomplete>
		        	<div v-else class="mr-auto ml-auto text-center">
		    			<md-progress-bar md-mode="query"></md-progress-bar>
					</div>
				</transition>

	    		<md-progress-bar v-if="isSubmitting" md-mode="query"></md-progress-bar>
				<md-card-actions>
				<md-button class="md-primary" :disabled="form.errors.any()" type="submit">Update</md-button>
				</md-card-actions>
			</SmartForm>
		</md-card>
	</div>
</template>

<script>
	import Form from 'Js/lib/Form';
	import Fetcher from 'Js/lib/Fetcher';
	import SmartForm from 'Js/components/common/SmartForm';
	import { updateUserData } from 'Js/store/api';

	export default {
		name: 'Home',
		components: {
			SmartForm,
		},

		/**
		 * Wait 200ms before allowing the school input to be shown to avoid flickers
		 */
		mounted() {
			setTimeout(() => this.canShowSchoolInput = true, 250);
			Fetcher.schools(this);
		},
		data() {
			return {
				/**
				 * The state of the AJAX request of the form
				 * @type {Boolean}
				 */
				isSubmitting: false,

				/**
				 * Whether the school input is allowed to be shown
				 * @type {Boolean}
				 */
				canShowSchoolInput: false,

				/**
				 * The form object for account informations
				 * @type {Form}
				 */
				form: new Form({
					firstname: this.$store.state.user.firstname,
					lastname: this.$store.state.user.lastname,
					school: '',
				}),
			};
		},
		computed: {
			/**
			 * Return the data of the schools from the store
			 * @return {Array} 
			 */
			schools() {
				return this.$store.getters.approvedSchools;
			},

			/**
			 * Determine whether the data is ready for a search to be performed
			 * @return {Boolean} 
			 */
			searchIsReady() {
				const {beingFetched: fetching} = this.$store.state.school;
				return this.canShowSchoolInput && !fetching;
			},
		},
		methods: {
			/**
			 * Handle the submitting of the form and update the user in the store
			 * @return {Void} 
			 */
			submitForm() {
				this.isSubmitting = true;

				this.form.submit(updateUserData).then(({data: user}) => {
					this.isSubmitting = false;
					this.$store.commit({
						type: 'updateUser',
						user,
					});

					alert('Your account information was successfully updated!');
				});
			},
		},
	}
</script>