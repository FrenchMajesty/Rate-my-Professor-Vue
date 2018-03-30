<template>
	<md-card md-with-hover>
		<form 
			class="md-layout-item md-size-90" 
			@submit.preventDefault="submitForm" 
			@keydown="clearFieldErrors"
		>
			<md-card-header>
				<h1 class="md-title">Sign up today!</h1>
				<span class="md-subhead">Join the ranks of the awesome students who are active members of the community and make University life better.</span>
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
		</form>
	</md-card>
</template>

<script>
	import Form from 'Js/lib/Form';
	import { submitStudentRegistration, loadAllSchoolsData } from 'Js/store/api';

	export default {
		name: 'StudentRegistrationCard',

		/**
		 * Wait 200ms before allowing the school input to be shown to avoid flickers
		 */
		mounted() {
			setTimeout(() => this.canShowSchoolInput = true, 250);
			this.loadSchoolsData();
		},
		data() {
			return {
				/**
				 * Whether the school input is allowed to be shown
				 * @type {Boolean}
				 */
				canShowSchoolInput: false,

				/**
				 * The Form object for the registration card
				 * @type {Form}
				 */
				form: new Form({
					firstname: '',
					lastname: '',
					email: '',
					password: '',
					terms: false,
					school: '',
				}),
			};
		},
		watch: {
			form: (newValue) => {
				if(newValue.school) {
					console.log(newValue.school);
				}
			}
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
			 * Handle the submitting of the form
			 * @return {Void} 
			 */
			submitForm() {
				this.form.submit(submitStudentRegistration)
				.then(() => console.log('registration form for student was submitted '));
			},

			/**
			 * On keydown, clear the errors on the target input
			 * @param  {HTMLElement} options.target The input's HTML input
			 * @return {Void}                 
			 */
			clearFieldErrors({target}) {
				this.form.errors.clear(target.getAttribute('data-name'));
			},

			/**
			 * Init a request to load the schools' data
			 * @return {Void} 
			 */
			loadSchoolsData() {
				const {beingFetched} = this.$store.state.school;

				if(!beingFetched) {
					this.$store.commit('updateSchoolsDataFetchingStatus', true);

					loadAllSchoolsData().then(({data}) => {
						this.$store.commit({
							type: 'updateSchoolsData',
							data: data.schools,
						});
					})
					.catch(error => console.log(error));
				}
			}
		},
	};
</script>

<style scoped>
	.error {
		color: #ff1744;
	}
</style>